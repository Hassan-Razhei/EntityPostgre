<?php

namespace Tests\Feature\Console;

use App\Enums\UserRole;
use App\Models\Activity;
use App\Models\Book;
use App\Models\ContentNode;
use App\Models\Manuscript;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SeedRealisticEnhancementsTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_seeds_super_admin_and_representative_rbac_roles(): void
    {
        $this->artisan('project:seed-realistic --count=2')
            ->expectsConfirmation(
                '⚠️  سيتم حذف جميع البيانات الحالية وإعادة تعبئتها. هل أنت متأكد؟',
                'yes'
            )
            ->assertExitCode(0);

        // 1. Check super admin account
        $admin = User::where('email', 'admin@admin.com')->first();
        $this->assertNotNull($admin);
        $this->assertSame(UserRole::SUPER_ADMIN, $admin->role);

        // 2. Check representative role users
        $rolesFound = User::pluck('role')->unique()->toArray();
        $this->assertContains(UserRole::SUPER_ADMIN, $rolesFound);
        $this->assertContains(UserRole::CHIEF_EDITOR, $rolesFound);
        $this->assertContains(UserRole::EDITOR, $rolesFound);
        $this->assertContains(UserRole::RESEARCHER, $rolesFound);
    }

    #[Test]
    public function it_seeds_soft_deleted_records_for_trash_bin(): void
    {
        $this->artisan('project:seed-realistic --count=3')
            ->expectsConfirmation(
                '⚠️  سيتم حذف جميع البيانات الحالية وإعادة تعبئتها. هل أنت متأكد؟',
                'yes'
            )
            ->assertExitCode(0);

        $trashedBooks = Book::onlyTrashed()->count();
        $trashedManuscripts = Manuscript::onlyTrashed()->count();

        $this->assertGreaterThan(0, $trashedBooks, 'Expected at least one soft-deleted book');
        $this->assertGreaterThan(0, $trashedManuscripts, 'Expected at least one soft-deleted manuscript');
    }

    #[Test]
    public function it_seeds_diverse_activity_types(): void
    {
        $this->artisan('project:seed-realistic --count=2')
            ->expectsConfirmation(
                '⚠️  سيتم حذف جميع البيانات الحالية وإعادة تعبئتها. هل أنت متأكد؟',
                'yes'
            )
            ->assertExitCode(0);

        $activityTypes = Activity::pluck('activity_type')->unique()->toArray();

        $this->assertContains('publish', $activityTypes);
        $this->assertContains('update', $activityTypes);
        $this->assertContains('delete', $activityTypes);
        $this->assertContains('create', $activityTypes);
    }

    #[Test]
    public function it_populates_direct_isbn_and_author_fields_on_books(): void
    {
        $this->artisan('project:seed-realistic --count=2')
            ->expectsConfirmation(
                '⚠️  سيتم حذف جميع البيانات الحالية وإعادة تعبئتها. هل أنت متأكد؟',
                'yes'
            )
            ->assertExitCode(0);

        $books = Book::all();
        $this->assertNotEmpty($books);

        foreach ($books as $book) {
            $this->assertNotEmpty($book->author, "Book [{$book->title}] must have author field populated");
            $this->assertNotEmpty($book->isbn, "Book [{$book->title}] must have isbn field populated");
        }
    }

    #[Test]
    public function it_seeds_manuscript_folios_and_studio_curation_metadata(): void
    {
        $this->artisan('project:seed-realistic --count=2')
            ->expectsConfirmation(
                '⚠️  سيتم حذف جميع البيانات الحالية وإعادة تعبئتها. هل أنت متأكد؟',
                'yes'
            )
            ->assertExitCode(0);

        // Check folio numbers on manuscript content nodes
        $manuscriptNodes = ContentNode::where('type', 'page')->get();
        $this->assertNotEmpty($manuscriptNodes);
        $hasFolio = $manuscriptNodes->contains(fn($node) => !empty($node->folio_number));
        $this->assertTrue($hasFolio, 'Expected manuscript pages to have folio_number populated');

        // Check studio curation metadata via model accessors
        $curatedNodes = ContentNode::all()->filter(fn($node) => $node->is_manually_edited);
        $this->assertNotEmpty($curatedNodes, 'Expected some nodes to be marked as curated in studio');
        $this->assertNotNull($curatedNodes->first()->metadata['last_editor_id'] ?? null);
    }
}
