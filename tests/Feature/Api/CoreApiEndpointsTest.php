<?php

namespace Tests\Feature\Api;

use App\Models\Audio;
use App\Models\Book;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Manuscript;
use App\Models\Note;
use App\Models\Series;
use App\Models\Tag;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoreApiEndpointsTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->createOne();
        $this->actingAs($this->user);
    }

    public function test_can_create_book_via_api(): void
    {
        $response = $this->postJson('/api/books', [
            'title' => 'كتاب تجريبي عبر API',
            'author' => 'مؤلف تجريبي',
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'message' => 'تم إنشاء الكتاب بنجاح',
        ]);
        $this->assertDatabaseHas('books', [
            'title' => 'كتاب تجريبي عبر API',
        ]);
    }

    public function test_can_create_audio_via_api(): void
    {
        $response = $this->postJson('/api/audios', [
            'title' => 'ملف صوتي تجريبي عبر API',
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'message' => 'تم إنشاء الملف الصوتي بنجاح',
        ]);
        $this->assertDatabaseHas('audios', [
            'title' => 'ملف صوتي تجريبي عبر API',
        ]);
    }

    public function test_can_create_video_via_api(): void
    {
        $response = $this->postJson('/api/videos', [
            'title' => 'ملف مرئي تجريبي عبر API',
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'message' => 'تم إنشاء الفيديو بنجاح',
        ]);
        $this->assertDatabaseHas('videos', [
            'title' => 'ملف مرئي تجريبي عبر API',
        ]);
    }

    public function test_can_create_manuscript_via_api(): void
    {
        $response = $this->postJson('/api/manuscripts', [
            'title' => 'مخطوطة تجريبية عبر API',
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'message' => 'تم إنشاء المخطوطة بنجاح',
        ]);
        $this->assertDatabaseHas('manuscripts', [
            'title' => 'مخطوطة تجريبية عبر API',
        ]);
    }

    public function test_can_create_category_via_api(): void
    {
        $response = $this->postJson('/api/categories', [
            'name' => 'تصنيف تجريبي عبر API',
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'message' => 'تم إنشاء التصنيف بنجاح',
        ]);
        $this->assertDatabaseHas('categories', [
            'name' => 'تصنيف تجريبي عبر API',
        ]);
    }

    public function test_can_create_tag_via_api(): void
    {
        $response = $this->postJson('/api/tags', [
            'name' => 'وسم تجريبي عبر API',
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'message' => 'تم إنشاء الـ Tag بنجاح',
        ]);
        $this->assertDatabaseHas('tags', [
            'name' => 'وسم تجريبي عبر API',
        ]);
    }

    public function test_can_create_collection_via_api(): void
    {
        $response = $this->postJson('/api/collections', [
            'name' => 'مجموعة تجريبية عبر API',
            'description' => 'وصف المجموعة',
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'message' => 'تم إنشاء المجموعة بنجاح',
        ]);
        $this->assertDatabaseHas('collections', [
            'name' => 'مجموعة تجريبية عبر API',
        ]);
    }

    public function test_can_create_series_via_api(): void
    {
        $response = $this->postJson('/api/series', [
            'title' => 'سلسلة تجريبية عبر API',
            'description' => 'وصف السلسلة',
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'message' => 'تم إنشاء السلسلة بنجاح',
        ]);
        $this->assertDatabaseHas('series', [
            'title' => 'سلسلة تجريبية عبر API',
        ]);
    }

    public function test_can_create_comment_and_note_via_api(): void
    {
        $book = Book::factory()->createOne(['title' => 'كتاب للتعليق والملاحظة']);

        // Testing with true polymorphic entity_id & entity_type
        $commentResponse = $this->postJson('/api/comments', [
            'content' => 'تعليق تجريبي عبر API',
            'entity_id' => $book->id,
            'entity_type' => 'book',
        ]);

        $commentResponse->assertStatus(201);
        $commentResponse->assertJsonFragment([
            'message' => 'تم إضافة التعليق بنجاح',
        ]);

        $noteResponse = $this->postJson('/api/notes', [
            'content' => 'ملاحظة تجريبية عبر API',
            'entity_id' => $book->id,
            'entity_type' => 'book',
        ]);

        $noteResponse->assertStatus(201);
        $noteResponse->assertJsonFragment([
            'message' => 'تم إضافة الملاحظة بنجاح',
        ]);

        // Testing backward compatibility with commentable_id
        $compatResponse = $this->postJson('/api/comments', [
            'content' => 'تعليق تجريبي بتوافقية قديمة',
            'commentable_id' => $book->id,
            'commentable_type' => 'book',
        ]);
        $compatResponse->assertStatus(201);
    }
}
