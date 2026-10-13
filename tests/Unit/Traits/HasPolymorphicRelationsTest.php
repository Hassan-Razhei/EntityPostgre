<?php

namespace Tests\Unit\Traits;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Traits\HasPolymorphicRelations;
use App\Models\Tag;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\Test;

// نموذج تجريبي يستخدم جداول منفصلة
class TestEntity extends Model
{
    use HasPolymorphicRelations, HasUuids;

    protected $table = 'test_entities';
    protected $fillable = ['name'];

    protected $tagsPivotTable = 'test_taggables';
    protected $categoriesPivotTable = 'test_categorizables';

    // تجاوز علاقة tags لاستخدام pivot table مختلف
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'entity', 'test_taggables')
            ->withTimestamps();
    }
}

class HasPolymorphicRelationsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // إنشاء جدول test_entities إذا لم يكن موجوداً
        if (!Schema::hasTable('test_entities')) {
            Schema::create('test_entities', function ($table) {
                $table->uuid('id')->primary();
                $table->string('name');
                $table->timestamps();
            });
        }

        // إنشاء جدول test_taggables منفصل (وليس taggables العام)
        if (!Schema::hasTable('test_taggables')) {
            Schema::create('test_taggables', function ($table) {
                // $table->id();
                $table->foreignUuid('tag_id');
                $table->uuidMorphs('entity'); // NOT nullable
                $table->timestamps();

                $table->index(['entity_id', 'entity_type']);
                // $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade'); // foreignUuid handles constraint? No, need to be explicit or use constrained method if creating table
                // Since 'tag_id' is foreignUuid, if we want constraint:
                $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');

                // منع التكرار
                $table->unique(['tag_id', 'entity_id', 'entity_type'], 'test_taggable_unique');
            });
        }
    }

    /*protected function tearDown(): void
    {
        // إسقاط الجداول المؤقتة فقط
        Schema::dropIfExists('test_taggables');
        Schema::dropIfExists('test_entities');
        parent::tearDown();
    }*/

    #[Test]
    public function trait_adds_polymorphic_methods()
    {
        $model = new TestEntity();

        // التحقق من وجود الطرق
        $this->assertTrue(method_exists($model, 'activities'));
        $this->assertTrue(method_exists($model, 'tags'));
    }

    #[Test]
    public function tags_relationship_works()
    {
        // إنشاء tag أولاً
        $tag = Tag::create(['name' => 'PHP Testing']);

        // إنشاء entity تجريبية
        $entity = TestEntity::create(['name' => 'Test Entity']);

        // إرفاق tag
        $entity->tags()->attach($tag->id);

        // تحميل العلاقة من جديد
        $entity->load('tags');

        // التحقق
        $this->assertCount(1, $entity->tags);
        $this->assertEquals('PHP Testing', $entity->tags->first()->name);
        $this->assertEquals('php-testing', $entity->tags->first()->slug);
    }

    #[Test]
    public function morph_map_works_for_tags()
    {
        // Arrange
        $book = Book::create(['title' => 'Test Book', 'author' => 'Author']);
        $tag = Tag::create(['name' => 'Test Tag']);

        // Act
        $book->tags()->attach($tag);

        // Assert - يجب أن تعمل العلاقة العكسية الآن
        $this->assertCount(1, $tag->entities);
        $this->assertInstanceOf(Book::class, $tag->entities->first());
    }

    #[Test]
    public function it_attaches_tags_by_name_and_creates_missing_ones()
    {
        $book = Book::create(['title' => 'Book Tag Name Test', 'author' => 'Author']);

        $ids = $book->attachTagsByName(['Laravel', 'Architecture']);

        $this->assertCount(2, $ids);
        $this->assertCount(2, $book->fresh()->tags);
        $this->assertEqualsCanonicalizing(
            ['Laravel', 'Architecture'],
            $book->fresh()->tags->pluck('name')->toArray()
        );
    }

    #[Test]
    public function it_attaches_categories_by_name_and_creates_missing_ones()
    {
        $book = Book::create(['title' => 'Book Category Name Test', 'author' => 'Author']);

        $ids = $book->attachCategoriesByName(['Programming', 'Design Patterns']);

        $this->assertCount(2, $ids);
        $this->assertCount(2, $book->fresh()->categories);
        $this->assertEqualsCanonicalizing(
            ['Programming', 'Design Patterns'],
            $book->fresh()->categories->pluck('name')->toArray()
        );
    }

    #[Test]
    public function it_copies_tags_from_another_entity()
    {
        $source = Book::create(['title' => 'Source Book', 'author' => 'Author']);
        $target = Book::create(['title' => 'Target Book', 'author' => 'Author']);

        $tag1 = Tag::create(['name' => 'PHP']);
        $tag2 = Tag::create(['name' => 'PostgreSQL']);
        $source->tags()->attach([$tag1->id, $tag2->id]);

        $target->copyTagsFrom($source);

        $this->assertCount(2, $target->fresh()->tags);
        $this->assertEqualsCanonicalizing(
            ['PHP', 'PostgreSQL'],
            $target->fresh()->tags->pluck('name')->toArray()
        );
    }

    #[Test]
    public function it_finds_common_tags_with_another_entity()
    {
        $book1 = Book::create(['title' => 'Book 1', 'author' => 'Author']);
        $book2 = Book::create(['title' => 'Book 2', 'author' => 'Author']);

        $tagShared = Tag::create(['name' => 'Shared Tag']);
        $tagOnly1 = Tag::create(['name' => 'Only Book 1']);
        $tagOnly2 = Tag::create(['name' => 'Only Book 2']);

        $book1->tags()->attach([$tagShared->id, $tagOnly1->id]);
        $book2->tags()->attach([$tagShared->id, $tagOnly2->id]);

        $common = $book1->getCommonTagsWith($book2);

        $this->assertCount(1, $common);
        $this->assertEquals('Shared Tag', $common->first()->name);
    }
}

