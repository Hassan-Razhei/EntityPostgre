<?php

namespace Tests\Feature\Auth;

use App\Enums\UserRole;
use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * فحص سياسة الكيانات ومصفوفة الصلاحيات وبوابة العبور للمدير العام
 * الوثيقة المرجعية: .agent/auth/master_auth_rbac_blueprint.md (الركن الثالث: سياسات)
 */
class EntityPolicyTest extends TestCase
{
    use RefreshDatabase;

    private User $superAdmin;
    private User $chiefEditor;
    private User $editor;
    private User $cataloger;
    private User $transcriber;
    private User $verifiedResearcher;
    private User $researcher;
    private Book $book;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = User::factory()->withRole(UserRole::SUPER_ADMIN)->create();
        $this->chiefEditor = User::factory()->withRole(UserRole::CHIEF_EDITOR)->create();
        $this->editor = User::factory()->withRole(UserRole::EDITOR)->create();
        $this->cataloger = User::factory()->withRole(UserRole::CATALOGER)->create();
        $this->transcriber = User::factory()->withRole(UserRole::TRANSCRIBER)->create();
        $this->verifiedResearcher = User::factory()->withRole(UserRole::VERIFIED_RESEARCHER)->create();
        $this->researcher = User::factory()->withRole(UserRole::RESEARCHER)->create();

        $this->book = Book::factory()->create([
            'title' => 'كتاب تجريبي للسياسات',
        ]);
    }

    #[Test]
    public function it_allows_viewing_public_entities_for_all(): void
    {
        $this->assertTrue(Gate::forUser($this->researcher)->allows('view', $this->book));
        $this->assertTrue(Gate::forUser($this->editor)->allows('view', $this->book));
    }

    #[Test]
    public function it_restricts_restricted_entities_to_verified_researchers_and_staff(): void
    {
        $restrictedBook = Book::factory()->create([
            'title' => 'مخطوط نادر مقيد',
        ]);
        // تمييز الكيان كمقيد
        $restrictedBook->is_restricted = true;

        $this->assertFalse(Gate::forUser($this->researcher)->allows('view', $restrictedBook), 'الباحث العادي لا يحق له استعراض المصنفات المقيدة');
        $this->assertTrue(Gate::forUser($this->verifiedResearcher)->allows('view', $restrictedBook), 'الباحث الموثق يحق له استعراض المصنفات المقيدة');
        $this->assertTrue(Gate::forUser($this->editor)->allows('view', $restrictedBook), 'المحرر يحق له استعراض المصنفات المقيدة');
        $this->assertTrue(Gate::forUser($this->superAdmin)->allows('view', $restrictedBook), 'المدير العام يحق له استعراض كافة المصنفات');
    }

    #[Test]
    public function it_restricts_studio_access_to_transcriber_editor_chief_and_super_admin(): void
    {
        // مسموح لطاقم الاستوديو
        $this->assertTrue(Gate::forUser($this->transcriber)->allows('accessStudio', $this->book));
        $this->assertTrue(Gate::forUser($this->editor)->allows('accessStudio', $this->book));
        $this->assertTrue(Gate::forUser($this->chiefEditor)->allows('accessStudio', $this->book));
        $this->assertTrue(Gate::forUser($this->superAdmin)->allows('accessStudio', $this->book));

        // ممنوع للفهرسة والباحثين
        $this->assertFalse(Gate::forUser($this->cataloger)->allows('accessStudio', $this->book));
        $this->assertFalse(Gate::forUser($this->researcher)->allows('accessStudio', $this->book));
    }

    #[Test]
    public function it_restricts_publishing_to_chief_editor_and_super_admin(): void
    {
        $this->assertTrue(Gate::forUser($this->chiefEditor)->allows('publish', $this->book));
        $this->assertTrue(Gate::forUser($this->superAdmin)->allows('publish', $this->book));

        $this->assertFalse(Gate::forUser($this->editor)->allows('publish', $this->book), 'المحرر لا يحق له اعتماد النشر');
        $this->assertFalse(Gate::forUser($this->cataloger)->allows('publish', $this->book));
        $this->assertFalse(Gate::forUser($this->researcher)->allows('publish', $this->book));
    }

    #[Test]
    public function it_restricts_soft_delete_to_chief_editor_and_super_admin(): void
    {
        $this->assertTrue(Gate::forUser($this->chiefEditor)->allows('delete', $this->book));
        $this->assertTrue(Gate::forUser($this->superAdmin)->allows('delete', $this->book));

        $this->assertFalse(Gate::forUser($this->editor)->allows('delete', $this->book), 'المحرر لا يملك صلاحية حذف المصنف');
        $this->assertFalse(Gate::forUser($this->cataloger)->allows('delete', $this->book));
        $this->assertFalse(Gate::forUser($this->researcher)->allows('delete', $this->book));
    }

    #[Test]
    public function it_restricts_force_delete_strictly_to_super_admin(): void
    {
        $this->assertTrue(Gate::forUser($this->superAdmin)->allows('forceDelete', $this->book));

        $this->assertFalse(Gate::forUser($this->chiefEditor)->allows('forceDelete', $this->book), 'الحذف النهائي محصور بالمدير العام فقط');
        $this->assertFalse(Gate::forUser($this->editor)->allows('forceDelete', $this->book));
        $this->assertFalse(Gate::forUser($this->researcher)->allows('forceDelete', $this->book));
    }
}
