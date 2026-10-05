<?php

namespace Tests\Feature\Auth;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * فحص مصفوفة الاعتماد الشاملة (14 عملية تشغيلية × 12 دوراً = 168 نقطة تقاطع)
 * الوثيقة المرجعية: .agent/auth/master_auth_rbac_blueprint.md (الركن السادس + السابع: درع المناعة)
 */
class AuthorizationMatrixTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    #[DataProvider('authorizationMatrixProvider')]
    public function it_strictly_enforces_the_168_authorization_matrix_checkpoints(
        UserRole $role,
        string $operation,
        bool $expected
    ): void {
        $user = $role === UserRole::GUEST
            ? null
            : User::factory()->withRole($role)->make(['id' => rand(100, 999), 'is_active' => true]);

        $actual = Gate::forUser($user)->allows($operation);

        $roleLabel = $role->label();
        $this->assertSame(
            $expected,
            $actual,
            "فشل التدقيق في المصفوفة: الدور [{$role->value} - {$roleLabel}] في العملية [{$operation}]. المتوقع: " . ($expected ? 'مسموح (TRUE)' : 'محظور (FALSE)') . " ولكن الفعلي: " . ($actual ? 'مسموح' : 'محظور')
        );
    }

    /**
     * مزود بيانات مصفوفة الصلاحيات التنفيذية للأدوار الـ 12 والعمليات الـ 14
     * المجموع = 168 حالة فحص دقيقة
     */
    public static function authorizationMatrixProvider(): array
    {
        // مصفوفة الصلاحيات المرجعية المستمدة حرفياً من جدول الدليل المعماري
        // الأدوار بالترتيب: Guest, Subscriber, Researcher, Verified Researcher, Transcriber, Cataloger, Editor, Academic Reviewer, Chief Editor, Backup Operator, System Auditor, Super Admin
        $matrix = [
            // 1. تصفح الفهارس والبحث العام
            'browse_catalog' => [
                UserRole::GUEST->value => true,
                UserRole::SUBSCRIBER->value => true,
                UserRole::RESEARCHER->value => true,
                UserRole::VERIFIED_RESEARCHER->value => true,
                UserRole::TRANSCRIBER->value => true,
                UserRole::CATALOGER->value => true,
                UserRole::EDITOR->value => true,
                UserRole::ACADEMIC_REVIEWER->value => true,
                UserRole::CHIEF_EDITOR->value => true,
                UserRole::BACKUP_OPERATOR->value => true,
                UserRole::SYSTEM_AUDITOR->value => true,
                UserRole::SUPER_ADMIN->value => true,
            ],
            // 2. تشغيل وبث وسائط الكتب العامة
            'stream_media' => [
                UserRole::GUEST->value => true,
                UserRole::SUBSCRIBER->value => true,
                UserRole::RESEARCHER->value => true,
                UserRole::VERIFIED_RESEARCHER->value => true,
                UserRole::TRANSCRIBER->value => true,
                UserRole::CATALOGER->value => true,
                UserRole::EDITOR->value => true,
                UserRole::ACADEMIC_REVIEWER->value => true,
                UserRole::CHIEF_EDITOR->value => true,
                UserRole::BACKUP_OPERATOR->value => true,
                UserRole::SYSTEM_AUDITOR->value => true,
                UserRole::SUPER_ADMIN->value => true,
            ],
            // 3. حفظ مواضع القراءة والملاحظات
            'save_research_notes' => [
                UserRole::GUEST->value => false,
                UserRole::SUBSCRIBER->value => true,
                UserRole::RESEARCHER->value => true,
                UserRole::VERIFIED_RESEARCHER->value => true,
                UserRole::TRANSCRIBER->value => true,
                UserRole::CATALOGER->value => true,
                UserRole::EDITOR->value => true,
                UserRole::ACADEMIC_REVIEWER->value => true,
                UserRole::CHIEF_EDITOR->value => true,
                UserRole::BACKUP_OPERATOR->value => true,
                UserRole::SYSTEM_AUDITOR->value => true,
                UserRole::SUPER_ADMIN->value => true,
            ],
            // 4. تصدير الاقتباسات والأبحاث بدقة عالية
            'export_citations' => [
                UserRole::GUEST->value => false,
                UserRole::SUBSCRIBER->value => true,
                UserRole::RESEARCHER->value => false,
                UserRole::VERIFIED_RESEARCHER->value => true,
                UserRole::TRANSCRIBER->value => false,
                UserRole::CATALOGER->value => false,
                UserRole::EDITOR->value => true,
                UserRole::ACADEMIC_REVIEWER->value => true,
                UserRole::CHIEF_EDITOR->value => true,
                UserRole::BACKUP_OPERATOR->value => false,
                UserRole::SYSTEM_AUDITOR->value => false,
                UserRole::SUPER_ADMIN->value => true,
            ],
            // 5. استعراض المخطوطات والمسودات المقيدة
            'view_restricted_drafts' => [
                UserRole::GUEST->value => false,
                UserRole::SUBSCRIBER->value => false,
                UserRole::RESEARCHER->value => false,
                UserRole::VERIFIED_RESEARCHER->value => true,
                UserRole::TRANSCRIBER->value => false,
                UserRole::CATALOGER->value => false,
                UserRole::EDITOR->value => true,
                UserRole::ACADEMIC_REVIEWER->value => true,
                UserRole::CHIEF_EDITOR->value => true,
                UserRole::BACKUP_OPERATOR->value => false,
                UserRole::SYSTEM_AUDITOR->value => true,
                UserRole::SUPER_ADMIN->value => true,
            ],
            // 6. تفريغ النصوص ومطابقة المقاطع بالاستوديو
            'transcribe_in_studio' => [
                UserRole::GUEST->value => false,
                UserRole::SUBSCRIBER->value => false,
                UserRole::RESEARCHER->value => false,
                UserRole::VERIFIED_RESEARCHER->value => false,
                UserRole::TRANSCRIBER->value => true,
                UserRole::CATALOGER->value => false,
                UserRole::EDITOR->value => true,
                UserRole::ACADEMIC_REVIEWER->value => false,
                UserRole::CHIEF_EDITOR->value => true,
                UserRole::BACKUP_OPERATOR->value => false,
                UserRole::SYSTEM_AUDITOR->value => false,
                UserRole::SUPER_ADMIN->value => true,
            ],
            // 7. إدخال وتعديل البيانات الوصفية والوسوم
            'curate_metadata' => [
                UserRole::GUEST->value => false,
                UserRole::SUBSCRIBER->value => false,
                UserRole::RESEARCHER->value => false,
                UserRole::VERIFIED_RESEARCHER->value => false,
                UserRole::TRANSCRIBER->value => false,
                UserRole::CATALOGER->value => true,
                UserRole::EDITOR->value => true,
                UserRole::ACADEMIC_REVIEWER->value => false,
                UserRole::CHIEF_EDITOR->value => true,
                UserRole::BACKUP_OPERATOR->value => false,
                UserRole::SYSTEM_AUDITOR->value => false,
                UserRole::SUPER_ADMIN->value => true,
            ],
            // 8. رفع وسائط جديدة على قرص media
            'upload_media' => [
                UserRole::GUEST->value => false,
                UserRole::SUBSCRIBER->value => false,
                UserRole::RESEARCHER->value => false,
                UserRole::VERIFIED_RESEARCHER->value => false,
                UserRole::TRANSCRIBER->value => false,
                UserRole::CATALOGER->value => false,
                UserRole::EDITOR->value => true,
                UserRole::ACADEMIC_REVIEWER->value => false,
                UserRole::CHIEF_EDITOR->value => true,
                UserRole::BACKUP_OPERATOR->value => false,
                UserRole::SYSTEM_AUDITOR->value => false,
                UserRole::SUPER_ADMIN->value => true,
            ],
            // 9. تحكيم وتدقيق النسخ وإيداع التقارير العلمية
            'review_academically' => [
                UserRole::GUEST->value => false,
                UserRole::SUBSCRIBER->value => false,
                UserRole::RESEARCHER->value => false,
                UserRole::VERIFIED_RESEARCHER->value => false,
                UserRole::TRANSCRIBER->value => false,
                UserRole::CATALOGER->value => false,
                UserRole::EDITOR->value => false,
                UserRole::ACADEMIC_REVIEWER->value => true,
                UserRole::CHIEF_EDITOR->value => true,
                UserRole::BACKUP_OPERATOR->value => false,
                UserRole::SYSTEM_AUDITOR->value => false,
                UserRole::SUPER_ADMIN->value => true,
            ],
            // 10. اعتماد ونشر العمل وإتاحته للجمهور
            'publish_entity' => [
                UserRole::GUEST->value => false,
                UserRole::SUBSCRIBER->value => false,
                UserRole::RESEARCHER->value => false,
                UserRole::VERIFIED_RESEARCHER->value => false,
                UserRole::TRANSCRIBER->value => false,
                UserRole::CATALOGER->value => false,
                UserRole::EDITOR->value => false,
                UserRole::ACADEMIC_REVIEWER->value => false,
                UserRole::CHIEF_EDITOR->value => true,
                UserRole::BACKUP_OPERATOR->value => false,
                UserRole::SYSTEM_AUDITOR->value => false,
                UserRole::SUPER_ADMIN->value => true,
            ],
            // 11. تجميد وحذف السجلات مؤقتاً (Soft Delete)
            'soft_delete_records' => [
                UserRole::GUEST->value => false,
                UserRole::SUBSCRIBER->value => false,
                UserRole::RESEARCHER->value => false,
                UserRole::VERIFIED_RESEARCHER->value => false,
                UserRole::TRANSCRIBER->value => false,
                UserRole::CATALOGER->value => false,
                UserRole::EDITOR->value => false,
                UserRole::ACADEMIC_REVIEWER->value => false,
                UserRole::CHIEF_EDITOR->value => true,
                UserRole::BACKUP_OPERATOR->value => false,
                UserRole::SYSTEM_AUDITOR->value => false,
                UserRole::SUPER_ADMIN->value => true,
            ],
            // 12. إدارة النسخ الاحتياطي ومزامنة الأقراص
            'manage_backups_storage' => [
                UserRole::GUEST->value => false,
                UserRole::SUBSCRIBER->value => false,
                UserRole::RESEARCHER->value => false,
                UserRole::VERIFIED_RESEARCHER->value => false,
                UserRole::TRANSCRIBER->value => false,
                UserRole::CATALOGER->value => false,
                UserRole::EDITOR->value => false,
                UserRole::ACADEMIC_REVIEWER->value => false,
                UserRole::CHIEF_EDITOR->value => false,
                UserRole::BACKUP_OPERATOR->value => true,
                UserRole::SYSTEM_AUDITOR->value => false,
                UserRole::SUPER_ADMIN->value => true,
            ],
            // 13. الاطلاع على سجلات الأمان والتعديل (Audit)
            'view_audit_logs' => [
                UserRole::GUEST->value => false,
                UserRole::SUBSCRIBER->value => false,
                UserRole::RESEARCHER->value => false,
                UserRole::VERIFIED_RESEARCHER->value => false,
                UserRole::TRANSCRIBER->value => false,
                UserRole::CATALOGER->value => false,
                UserRole::EDITOR->value => false,
                UserRole::ACADEMIC_REVIEWER->value => false,
                UserRole::CHIEF_EDITOR->value => false,
                UserRole::BACKUP_OPERATOR->value => false,
                UserRole::SYSTEM_AUDITOR->value => true,
                UserRole::SUPER_ADMIN->value => true,
            ],
            // 14. تشغيل أوامر النظام التدميرية وتعديل الرتب
            'manage_system_commands' => [
                UserRole::GUEST->value => false,
                UserRole::SUBSCRIBER->value => false,
                UserRole::RESEARCHER->value => false,
                UserRole::VERIFIED_RESEARCHER->value => false,
                UserRole::TRANSCRIBER->value => false,
                UserRole::CATALOGER->value => false,
                UserRole::EDITOR->value => false,
                UserRole::ACADEMIC_REVIEWER->value => false,
                UserRole::CHIEF_EDITOR->value => false,
                UserRole::BACKUP_OPERATOR->value => false,
                UserRole::SYSTEM_AUDITOR->value => false,
                UserRole::SUPER_ADMIN->value => true,
            ],
        ];

        $cases = [];
        foreach ($matrix as $operation => $rolesAllowed) {
            foreach (UserRole::cases() as $role) {
                $expected = $rolesAllowed[$role->value] ?? false;
                $datasetName = "{$operation} for {$role->value}";
                $cases[$datasetName] = [$role, $operation, $expected];
            }
        }

        return $cases;
    }
}
