<?php

namespace App\Enums;

/**
 * ════════════════════════════════════════════════════════════════════════
 * ContentStatus — دورة الحياة التحريرية الموحدة للأصول الرقمية الأربعة
 * ════════════════════════════════════════════════════════════════════════
 *
 * المصدر الوحيد للحقيقة لـ 10 حالات تحريرية:
 *   - التسميات العربية (label)
 *   - الألوان (color)
 *   - المجموعات (group): published / progress / draft
 *   - ترتيب المراحل (weight)
 *   - تعيين الحالات لكل نوع أصل (forAsset)
 *
 * المرجع: database/migrations/2026_01_01_000020-000023 (enum status)
 * ════════════════════════════════════════════════════════════════════════
 */
enum ContentStatus: string
{
    // ─── الحالات العشر ───────────────────────────────────────────────
    case DRAFT       = 'draft';
    case TRANSCRIBED = 'transcribed';
    case VERIFIED    = 'verified';
    case REVISED     = 'revised';
    case CURRICULUM  = 'curriculum';
    case SCHOLARLY   = 'scholarly';
    case PUBLISHED   = 'published';
    case TYPESET     = 'typeset';
    case COLLATED    = 'collated';
    case EDITED      = 'edited';

    // ─────────────────────────────────────────────────────────────────
    // 1. التسمية العربية (المصدر الوحيد — تُغني عن STATUS_LABELS في JS)
    // ─────────────────────────────────────────────────────────────────
    public function label(): string
    {
        return match ($this) {
            self::DRAFT       => 'مسودة 🔴',
            self::TRANSCRIBED => 'مفرغ ✍️',
            self::VERIFIED    => 'مطابق 🔍',
            self::REVISED     => 'معدل ✏️',
            self::CURRICULUM  => 'منهج 🎓',
            self::SCHOLARLY   => 'محكّم 🏅',
            self::PUBLISHED   => 'منشور 🌐',
            self::TYPESET     => 'مصفوف 🖨️',
            self::COLLATED    => 'مقابل 📋',
            self::EDITED      => 'محقق 🔬',
        };
    }

    // ─────────────────────────────────────────────────────────────────
    // 2. اللون السادس عشري (المصدر الوحيد — يُغني عن color محروقة في JS)
    // ─────────────────────────────────────────────────────────────────
    public function color(): string
    {
        return match ($this) {
            self::DRAFT       => '#f59e0b',
            self::TRANSCRIBED => '#8b5cf6',
            self::VERIFIED    => '#06b6d4',
            self::REVISED     => '#3b82f6',
            self::CURRICULUM  => '#ec4899',
            self::SCHOLARLY   => '#a855f7',
            self::PUBLISHED   => '#10b981',
            self::TYPESET     => '#06b6d4',
            self::COLLATED    => '#3b82f6',
            self::EDITED      => '#a855f7',
        };
    }

    // ─────────────────────────────────────────────────────────────────
    // 3. المجموعة (تُغني عن STATUS_FILTER_GROUPS في JS)
    //    - published: منشور + محكّم (متاح للعموم ومعتمد)
    //    - progress:  مراحل المعالجة التحريرية
    //    - draft:      مسودة فقط
    // ─────────────────────────────────────────────────────────────────
    public function group(): string
    {
        return match ($this) {
            self::PUBLISHED, self::SCHOLARLY            => 'published',
            self::DRAFT                                  => 'draft',
            self::TRANSCRIBED, self::VERIFIED,
            self::REVISED, self::CURRICULUM,
            self::TYPESET, self::COLLATED, self::EDITED  => 'progress',
        };
    }

    // ─────────────────────────────────────────────────────────────────
    // 4. وزن الترتيب (لمحرك الترتيب في الجدول والبطاقات)
    //    المسودة = 0، النشر = 100 (الأعلى)
    // ─────────────────────────────────────────────────────────────────
    public function weight(): int
    {
        return match ($this) {
            self::DRAFT       => 0,
            self::TRANSCRIBED => 10,
            self::VERIFIED    => 20,
            self::TYPESET     => 20,   // مسار المخطوطات
            self::REVISED     => 30,
            self::COLLATED    => 30,   // مسار المخطوطات
            self::CURRICULUM  => 40,
            self::EDITED      => 40,   // مسار المخطوطات
            self::SCHOLARLY   => 50,
            self::PUBLISHED   => 100,
        };
    }

    // ─────────────────────────────────────────────────────────────────
    // 5. تعيين الحالات لكل نوع أصل (يطابق migrations)
    //    - books: 7 حالات (مع scholarly)
    //    - manuscripts: 5 حالات (مع typeset/collated/edited)
    //    - audios/videos: 6 حالات (بلا scholarly)
    // ─────────────────────────────────────────────────────────────────
    public static function forAsset(string $asset): array
    {
        return match ($asset) {
            'book' => [
                self::DRAFT, self::TRANSCRIBED, self::VERIFIED,
                self::REVISED, self::CURRICULUM, self::SCHOLARLY, self::PUBLISHED,
            ],
            'manuscript' => [
                self::DRAFT, self::TYPESET, self::COLLATED, self::EDITED, self::PUBLISHED,
            ],
            'audio' => [
                self::DRAFT, self::TRANSCRIBED, self::VERIFIED,
                self::REVISED, self::CURRICULUM, self::PUBLISHED,
            ],
            'video' => [
                self::DRAFT, self::TRANSCRIBED, self::VERIFIED,
                self::REVISED, self::CURRICULUM, self::PUBLISHED,
            ],
            default => [],
        };
    }

    /**
     * تعيين الحالات من EntityType (تكامل مع app/Enums/EntityType.php)
     */
    public static function forEntityType(EntityType $type): array
    {
        return self::forAsset($type->value);
    }

    /**
     * هل تنطبق هذه الحالة على نوع أصل معين؟
     */
    public function appliesTo(string $asset): bool
    {
        return in_array($this, self::forAsset($asset), true);
    }

    // ─────────────────────────────────────────────────────────────────
    // 6. تصدير للواجهة (يُغني عن STATUS_LABELS المكررة في 3 ملفات Vue)
    // ─────────────────────────────────────────────────────────────────
    public static function toArray(): array
    {
        $result = [];
        foreach (self::cases() as $status) {
            $result[$status->value] = [
                'label'  => $status->label(),
                'color'  => $status->color(),
                'group'  => $status->group(),
                'weight' => $status->weight(),
            ];
        }
        return $result;
    }

    /**
     * الحالات المتاحة لكل نوع أصل (لتمريرها للواجهة)
     * الناتج: ['books' => ['draft', 'transcribed', ...], ...]
     */
    public static function assetStatuses(): array
    {
        return [
            'books'       => array_map(fn($s) => $s->value, self::forAsset('book')),
            'manuscripts' => array_map(fn($s) => $s->value, self::forAsset('manuscript')),
            'audios'      => array_map(fn($s) => $s->value, self::forAsset('audio')),
            'videos'      => array_map(fn($s) => $s->value, self::forAsset('video')),
        ];
    }

    /**
     * إنشاء حالة من نص (آمن)
     */
    public static function tryFromValue(?string $value): ?self
    {
        if ($value === null) {
            return null;
        }
        return self::tryFrom($value);
    }

    /**
     * التسمية العربية من نص (للتوافق مع البيانات القديمة)
     */
    public static function labelFromValue(?string $value): string
    {
        return self::tryFrom($value)?->label() ?? 'غير محدد';
    }
}
