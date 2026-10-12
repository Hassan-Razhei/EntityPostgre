<?php

namespace Tests\Unit\Enums;

use App\Enums\ContentStatus;
use App\Enums\EntityType;
use App\Http\Controllers\AdminDashboardController;
use App\Models\Audio;
use App\Models\Book;
use App\Models\Manuscript;
use App\Models\Video;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * ════════════════════════════════════════════════════════════════════════
 * 🔴 اختبار شامل: ContentStatus — الدورة الكاملة
 * ════════════════════════════════════════════════════════════════════════
 *
 * هذا الاختبار يُثبِّت العقد (contract) بين الطبقات الخمس:
 *
 *   1. قاعدة البيانات (migrations → enum)
 *   2. الـ Enum (ContentStatus)
 *   3. الباك إند (AdminDashboardController → $stats)
 *   4. الواجهة (AssetHeaderBanner ← props، AssetTableView ← STATUS_FILTER_GROUPS)
 *   5. الجدول (DenseDataTable ← STATUS_LABELS)
 *
 * القاعدة الذهبية: أي حالة يجب أن:
 *   ✅ تكون موجودة في migration
 *   ✅ تملك label عربي + color
 *   ✅ تُنتج مفتاح {asset}_{status} في $stats
 *   ✅ يطابق نقر بطاقتها عدد الصفوف الفعلية
 *
 * ════════════════════════════════════════════════════════════════════════
 */
class ContentStatusIntegrationTest extends TestCase
{
    // ────────────────────────────────────────────────────────────────────
    // القسم 1: الـ Enum نفسه (التعريفات الأساسية)
    // ────────────────────────────────────────────────────────────────────

    #[Test]
    public function section_1_it_defines_all_10_editorial_statuses(): void
    {
        $expected = [
            'draft', 'transcribed', 'verified', 'revised', 'curriculum',
            'scholarly', 'published', 'typeset', 'collated', 'edited',
        ];
        $actual = array_map(fn($s) => $s->value, ContentStatus::cases());

        sort($expected);
        sort($actual);

        $this->assertEquals($expected, $actual, 'الـ Enum يجب أن يعرّف 10 حالات');
    }

    #[Test]
    public function section_1_it_maps_statuses_to_arabic_labels(): void
    {
        $this->assertSame('مسودة 🔴', ContentStatus::DRAFT->label());
        $this->assertSame('مفرغ ✍️', ContentStatus::TRANSCRIBED->label());
        $this->assertSame('مطابق 🔍', ContentStatus::VERIFIED->label());
        $this->assertSame('معدل ✏️', ContentStatus::REVISED->label());
        $this->assertSame('منهج 🎓', ContentStatus::CURRICULUM->label());
        $this->assertSame('محكّم 🏅', ContentStatus::SCHOLARLY->label());
        $this->assertSame('منشور 🌐', ContentStatus::PUBLISHED->label());
        $this->assertSame('مصفوف 🖨️', ContentStatus::TYPESET->label());
        $this->assertSame('مقابل 📋', ContentStatus::COLLATED->label());
        $this->assertSame('محقق 🔬', ContentStatus::EDITED->label());
    }

    #[Test]
    public function section_1_it_assigns_hex_colors_to_statuses(): void
    {
        $this->assertSame('#f59e0b', ContentStatus::DRAFT->color());
        $this->assertSame('#8b5cf6', ContentStatus::TRANSCRIBED->color());
        $this->assertSame('#06b6d4', ContentStatus::VERIFIED->color());
        $this->assertSame('#3b82f6', ContentStatus::REVISED->color());
        $this->assertSame('#ec4899', ContentStatus::CURRICULUM->color());
        $this->assertSame('#a855f7', ContentStatus::SCHOLARLY->color());
        $this->assertSame('#10b981', ContentStatus::PUBLISHED->color());
        $this->assertSame('#06b6d4', ContentStatus::TYPESET->color());
        $this->assertSame('#3b82f6', ContentStatus::COLLATED->color());
        $this->assertSame('#a855f7', ContentStatus::EDITED->color());
    }

    #[Test]
    public function section_1_it_groups_statuses_into_published_progress_draft(): void
    {
        // published_group = منشور + محكّم
        $this->assertSame('published', ContentStatus::PUBLISHED->group());
        $this->assertSame('published', ContentStatus::SCHOLARLY->group());

        // progress_group = المتبقي من مراحل المعالجة
        foreach ([
            ContentStatus::TRANSCRIBED,
            ContentStatus::VERIFIED,
            ContentStatus::REVISED,
            ContentStatus::CURRICULUM,
            ContentStatus::TYPESET,
            ContentStatus::COLLATED,
            ContentStatus::EDITED,
        ] as $status) {
            $this->assertSame('progress', $status->group(), "{$status->value} يجب أن تكون في progress");
        }

        // draft_group = مسودة فقط
        $this->assertSame('draft', ContentStatus::DRAFT->group());
    }

    #[Test]
    public function section_1_it_provides_weight_for_ordering(): void
    {
        // المسودة أولاً، النشر أخيراً
        $this->assertSame(0, ContentStatus::DRAFT->weight());
        $this->assertSame(100, ContentStatus::PUBLISHED->weight());

        // المحكّم قبل النشر مباشرة
        $this->assertGreaterThan(ContentStatus::CURRICULUM->weight(), ContentStatus::SCHOLARLY->weight());
        $this->assertLessThan(ContentStatus::PUBLISHED->weight(), ContentStatus::SCHOLARLY->weight());

        // الأوزان فريدة داخل كل مسار (book/manuscript منفصلان)
        $bookWeights = array_map(fn($s) => $s->weight(), ContentStatus::forAsset('book'));
        $this->assertCount(count(array_unique($bookWeights)), $bookWeights, 'أوزان مسار الكتب فريدة');

        $manuscriptWeights = array_map(fn($s) => $s->weight(), ContentStatus::forAsset('manuscript'));
        $this->assertCount(count(array_unique($manuscriptWeights)), $manuscriptWeights, 'أوزان مسار المخطوطات فريدة');
    }

    #[Test]
    public function section_1_it_provides_labels_and_colors_as_array_for_frontend(): void
    {
        $meta = ContentStatus::toArray();

        $this->assertIsArray($meta);
        $this->assertCount(10, $meta);

        // كل حالة يجب أن تحمل: label + color + group
        foreach (ContentStatus::cases() as $status) {
            $this->assertArrayHasKey($status->value, $meta);
            $this->assertArrayHasKey('label', $meta[$status->value]);
            $this->assertArrayHasKey('color', $meta[$status->value]);
            $this->assertArrayHasKey('group', $meta[$status->value]);
        }

        // التحقق من قيمة محددة
        $this->assertSame('منشور 🌐', $meta['published']['label']);
        $this->assertSame('#10b981', $meta['published']['color']);
        $this->assertSame('published', $meta['published']['group']);
    }

    // ────────────────────────────────────────────────────────────────────
    // القسم 2: مطابقة قاعدة البيانات (منع الانحراف)
    // ────────────────────────────────────────────────────────────────────

    #[Test]
    public function section_2_it_matches_the_database_enum_definitions(): void
    {
        // 🔴 هذا هو الاختبار الحاسم: يمنع وجود حالة في Enum ليست في القاعدة
        $migrations = [
            'book' => ['draft', 'transcribed', 'verified', 'revised', 'curriculum', 'scholarly', 'published'],
            'manuscript' => ['draft', 'typeset', 'collated', 'edited', 'published'],
            'audio' => ['draft', 'transcribed', 'verified', 'revised', 'curriculum', 'published'],
            'video' => ['draft', 'transcribed', 'verified', 'revised', 'curriculum', 'published'],
        ];

        foreach ($migrations as $asset => $expected) {
            $actual = array_map(fn($s) => $s->value, ContentStatus::forAsset($asset));
            sort($expected);
            sort($actual);
            $this->assertEquals($expected, $actual, "حالات {$asset} في Enum يجب أن تطابق migration");
        }
    }

    #[Test]
    public function section_2_it_knows_which_asset_type_each_status_applies_to(): void
    {
        // books: تملك scholarly (فريدة)
        $this->assertContains(ContentStatus::SCHOLARLY, ContentStatus::forAsset('book'));
        $this->assertNotContains(ContentStatus::SCHOLARLY, ContentStatus::forAsset('audio'));
        $this->assertNotContains(ContentStatus::SCHOLARLY, ContentStatus::forAsset('video'));
        $this->assertNotContains(ContentStatus::SCHOLARLY, ContentStatus::forAsset('manuscript'));

        // manuscripts: تملك typeset/collated/edited (فريدة)
        foreach ([ContentStatus::TYPESET, ContentStatus::COLLATED, ContentStatus::EDITED] as $s) {
            $this->assertContains($s, ContentStatus::forAsset('manuscript'));
            $this->assertNotContains($s, ContentStatus::forAsset('book'));
            $this->assertNotContains($s, ContentStatus::forAsset('audio'));
            $this->assertNotContains($s, ContentStatus::forAsset('video'));
        }

        // الكل يملك draft و published
        foreach (['book', 'manuscript', 'audio', 'video'] as $asset) {
            $this->assertContains(ContentStatus::DRAFT, ContentStatus::forAsset($asset));
            $this->assertContains(ContentStatus::PUBLISHED, ContentStatus::forAsset($asset));
        }
    }

    #[Test]
    public function section_2_it_maps_entity_type_to_statuses(): void
    {
        // EntityType::BOOK → حالات الكتب
        $this->assertEquals(
            ContentStatus::forAsset('book'),
            ContentStatus::forEntityType(EntityType::BOOK)
        );
        $this->assertEquals(
            ContentStatus::forAsset('manuscript'),
            ContentStatus::forEntityType(EntityType::MANUSCRIPT)
        );
        $this->assertEquals(
            ContentStatus::forAsset('audio'),
            ContentStatus::forEntityType(EntityType::AUDIO)
        );
        $this->assertEquals(
            ContentStatus::forAsset('video'),
            ContentStatus::forEntityType(EntityType::VIDEO)
        );
    }

    // ────────────────────────────────────────────────────────────────────
    // القسم 3: الباك إند — $stats تُبنى من Enum
    // ────────────────────────────────────────────────────────────────────

    #[Test]
    public function section_3_it_exports_stats_keys_for_each_asset_status(): void
    {
        // 🔴 الباك إند يجب أن يُصدّر: {asset}_{status} لكل حالة
        // هذا ما يمنع: بطاقة تقرأ books_curriculum والكونترولر لا يُرسلها
        $requiredKeys = [];

        foreach (['books', 'manuscripts', 'audios', 'videos'] as $asset) {
            $entityType = match ($asset) {
                'books' => 'book',
                'manuscripts' => 'manuscript',
                'audios' => 'audio',
                'videos' => 'video',
            };

            foreach (ContentStatus::forAsset($entityType) as $status) {
                $requiredKeys[] = "{$asset}_{$status->value}";
            }
        }

        // استدعاء الكنترولر والتقاط $stats
        $response = $this->withoutMiddleware()
            ->get('/superadmin/dashboard');

        $response->assertOk();
        $stats = $response->viewData('page')['props']['stats'];

        foreach ($requiredKeys as $key) {
            $this->assertArrayHasKey($key, $stats, "الباك إند يجب أن يُصدّر: {$key}");
            $this->assertIsInt($stats[$key], "{$key} يجب أن يكون عدداً صحيحاً");
        }
    }

    #[Test]
    public function section_3_it_exports_funnel_stats_for_stats_view(): void
    {
        // funnel_* تغذّي القمع في DashboardStatsView (مسار مختلف عن التصنيف)
        $response = $this->withoutMiddleware()->get('/superadmin/dashboard');
        $stats = $response->viewData('page')['props']['stats'];

        foreach (['funnel_drafts', 'funnel_reviewed', 'funnel_scholarly', 'funnel_published'] as $key) {
            $this->assertArrayHasKey($key, $stats, "funnel: {$key} يجب أن يبقى للقمع");
        }
    }

    #[Test]
    public function section_3_it_no_longer_exports_removed_group_keys(): void
    {
        // 🔴 المجموعات القديمة (*_group) حُذفت — البطاقات صارت منفصلة
        $response = $this->withoutMiddleware()->get('/superadmin/dashboard');
        $stats = $response->viewData('page')['props']['stats'];

        foreach (['books_published_group', 'books_progress_group',
                  'manuscripts_progress_group', 'audios_progress_group',
                  'videos_progress_group'] as $key) {
            $this->assertArrayNotHasKey($key, $stats, "{$key} حُذف — البطاقات منفصلة الآن");
        }
    }

    #[Test]
    public function section_3_it_calculates_status_counts_correctly(): void
    {
        // 🔴 العدد في stats يجب أن يطابق العدد الفعلي في القاعدة لكل حالة
        $bookCounts = Book::groupBy('status')->selectRaw('status, count(*) as count')->pluck('count', 'status');

        $response = $this->withoutMiddleware()->get('/superadmin/dashboard');
        $stats = $response->viewData('page')['props']['stats'];

        foreach (ContentStatus::forAsset('book') as $status) {
            $key = "books_{$status->value}";
            $expected = $bookCounts[$status->value] ?? 0;
            $this->assertSame($expected, $stats[$key], "stats[{$key}] يجب أن يطابق القاعدة");
        }

        // مجموع الحالات = الإجمالي (تناسق حسابي)
        $sum = 0;
        foreach (ContentStatus::forAsset('book') as $status) {
            $sum += $stats["books_{$status->value}"];
        }
        $this->assertSame(Book::count(), $sum, 'مجموع حالات الكتب = إجمالي الكتب');
    }

    #[Test]
    public function section_3_it_matches_enum_counts_to_database(): void
    {
        // 🔴 العدد في stats يجب أن يطابق العدد الفعلي في القاعدة
        $bookCounts = Book::groupBy('status')->selectRaw('status, count(*) as count')->pluck('count', 'status');

        $response = $this->withoutMiddleware()->get('/superadmin/dashboard');
        $stats = $response->viewData('page')['props']['stats'];

        foreach (ContentStatus::forAsset('book') as $status) {
            $key = "books_{$status->value}";
            $expected = $bookCounts[$status->value] ?? 0;
            $this->assertSame($expected, $stats[$key], "stats[{$key}] يجب أن يطابق القاعدة");
        }
    }

    // ────────────────────────────────────────────────────────────────────
    // القسم 4: العقد مع الواجهة (منع البطاقات الوهمية)
    // ────────────────────────────────────────────────────────────────────

    #[Test]
    public function section_4_it_exports_status_meta_for_frontend(): void
    {
        // 🔴 الواجهة يجب أن تستقبل label + color + group من الباك إند
        // (يُغني عن STATUS_LABELS المكررة في 3 ملفات Vue)
        $response = $this->withoutMiddleware()->get('/superadmin/dashboard');
        $props = $response->viewData('page')['props'];

        $this->assertArrayHasKey('statusMeta', $props);
        $meta = $props['statusMeta'];

        $this->assertSame('منشور 🌐', $meta['published']['label']);
        $this->assertSame('#10b981', $meta['published']['color']);
        $this->assertSame('published', $meta['published']['group']);

        // كل الحالات العشر
        $this->assertCount(10, $meta);
    }

    #[Test]
    public function section_4_it_exports_asset_type_statuses_for_frontend(): void
    {
        // 🔴 الواجهة يجب أن تعرف أي حالات تنطبق على أي أصل
        // (لتُخفي بطاقات scholarly من شاشة المخطوطات مثلاً)
        $response = $this->withoutMiddleware()->get('/superadmin/dashboard');
        $props = $response->viewData('page')['props'];

        $this->assertArrayHasKey('assetStatuses', $props);

        $assetStatuses = $props['assetStatuses'];

        // books: 7 حالات
        $this->assertCount(7, $assetStatuses['books']);
        $this->assertContains('scholarly', $assetStatuses['books']);
        $this->assertNotContains('typeset', $assetStatuses['books']);

        // manuscripts: 5 حالات
        $this->assertCount(5, $assetStatuses['manuscripts']);
        $this->assertContains('typeset', $assetStatuses['manuscripts']);
        $this->assertNotContains('scholarly', $assetStatuses['manuscripts']);

        // audios/videos: 6 حالات
        $this->assertCount(6, $assetStatuses['audios']);
        $this->assertNotContains('scholarly', $assetStatuses['audios']);
    }

    // ────────────────────────────────────────────────────────────────────
    // القسم 5: سلامة شاملة (التحقق النهائي)
    // ────────────────────────────────────────────────────────────────────

    #[Test]
    public function section_5_every_enum_status_has_a_migration_definition(): void
    {
        // 🔴 لا توجد حالة في Enum بلا تعريف في migration
        foreach (ContentStatus::cases() as $status) {
            $foundInMigration = false;

            foreach (['book', 'manuscript', 'audio', 'video'] as $asset) {
                if (in_array($status, ContentStatus::forAsset($asset), true)) {
                    $foundInMigration = true;
                    break;
                }
            }

            $this->assertTrue(
                $foundInMigration,
                "الحالة {$status->value} يجب أن تكون معرّفة في migration واحد على الأقل"
            );
        }
    }

    #[Test]
    public function section_5_every_asset_in_database_has_valid_status(): void
    {
        // 🔴 كل صف في القاعدة يجب أن تكون حالته واحدة من حالات Enum
        $invalidBooks = Book::whereNotIn('status', array_map(fn($s) => $s->value, ContentStatus::cases()))->count();
        $this->assertSame(0, $invalidBooks, 'لا يجب أن يوجد كتاب بحالة غير معرّفة في Enum');

        $invalidManuscripts = Manuscript::whereNotIn('status', array_map(fn($s) => $s->value, ContentStatus::cases()))->count();
        $this->assertSame(0, $invalidManuscripts, 'لا يجب أن يوجد مخطوط بحالة غير معرّفة في Enum');

        $invalidAudios = Audio::whereNotIn('status', array_map(fn($s) => $s->value, ContentStatus::cases()))->count();
        $this->assertSame(0, $invalidAudios, 'لا يجب أن يوجد تسجيل صوتي بحالة غير معرّفة في Enum');

        $invalidVideos = Video::whereNotIn('status', array_map(fn($s) => $s->value, ContentStatus::cases()))->count();
        $this->assertSame(0, $invalidVideos, 'لا يجب أن يوجد مرئي بحالة غير معرّفة في Enum');
    }

    #[Test]
    public function section_5_no_duplicate_labels_or_colors(): void
    {
        // 🔴 كل حالة لها تسمية فريدة (للتمييز في الواجهة)
        $labels = array_map(fn($s) => $s->label(), ContentStatus::cases());
        $this->assertCount(count(array_unique($labels)), $labels, 'التسميات يجب أن تكون فريدة');

        // الألوان يمكن أن تتشابه (مثل verified و typeset كلاهما cyan) لكن يجب أن تكون صحيحة
        $colors = array_map(fn($s) => $s->color(), ContentStatus::cases());
        $this->assertCount(count(ContentStatus::cases()), $colors, 'كل حالة لها لون');
    }
}
