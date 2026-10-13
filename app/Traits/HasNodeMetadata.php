<?php

namespace App\Traits;

use Illuminate\Support\Carbon;

/**
 * سمة البيانات الوصفية الذكية لعقد المحتوى (Smart Node Metadata)
 *
 * تتولى إدارة وقراءة وتخزين الخصائص المتنوعة للوسائط (الصوت، الفيديو، المخطوطات، التحرير)
 * بشفافية تامة داخل حقل JSONB (metadata) في PostgreSQL مع الحفاظ على تجربة Eloquent الأصلية.
 */
trait HasNodeMetadata
{
    /**
     * الحصول على قيمة من البيانات الوصفية مع قيمة افتراضية
     */
    public function getMetadata(string $key, mixed $default = null): mixed
    {
        return $this->metadata[$key] ?? $default;
    }

    /**
     * تعيين قيمة داخل مصفوفة البيانات الوصفية
     */
    public function setMetadata(string $key, mixed $value): static
    {
        $meta = $this->metadata ?? [];
        $meta[$key] = $value;
        $this->metadata = $meta;

        return $this;
    }

    /**
     * التحقق من وجود مفتاح داخل البيانات الوصفية
     */
    public function hasMetadata(string $key): bool
    {
        return array_key_exists($key, $this->metadata ?? []);
    }

    /**
     * إزالة مفتاح من البيانات الوصفية
     */
    public function forgetMetadata(string $key): static
    {
        $meta = $this->metadata ?? [];
        unset($meta[$key]);
        $this->metadata = $meta;

        return $this;
    }

    // ==================== أوقات ومقاطع الصوتيات والمرئيات ====================

    /**
     * للصوتيات والمرئيات: بداية المقطع بالثواني
     */
    public function getStartTimeAttribute(): ?float
    {
        return isset($this->metadata['start_time']) ? (float) $this->metadata['start_time'] : null;
    }

    public function setStartTimeAttribute($value): void
    {
        $this->setMetadata('start_time', (float) $value);
    }

    /**
     * للصوتيات والمرئيات: نهاية المقطع بالثواني
     */
    public function getEndTimeAttribute(): ?float
    {
        return isset($this->metadata['end_time']) ? (float) $this->metadata['end_time'] : null;
    }

    public function setEndTimeAttribute($value): void
    {
        $this->setMetadata('end_time', (float) $value);
    }

    /**
     * مدة المقطع بالثواني
     */
    public function getDurationAttribute(): ?float
    {
        return isset($this->metadata['duration']) ? (float) $this->metadata['duration'] : null;
    }

    public function setDurationAttribute($value): void
    {
        $this->setMetadata('duration', (float) $value);
    }

    // ==================== المخطوطات الرقمية ====================

    /**
     * للمخطوطات: رقم اللوحة (Folio Number)
     */
    public function getFolioNumberAttribute(): ?string
    {
        return $this->getMetadata('folio_number');
    }

    public function setFolioNumberAttribute($value): void
    {
        $this->setMetadata('folio_number', $value !== null ? (string) $value : null);
    }

    /**
     * للمخطوطات: رابط صورة اللوحة
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->getMetadata('image_url');
    }

    public function setImageUrlAttribute($value): void
    {
        $this->setMetadata('image_url', $value !== null ? (string) $value : null);
    }

    // ==================== التحرير والتحقيق المكتبي ====================

    /**
     * رقم الصفحة في الكتاب أو المطبوع
     */
    public function getPageNumberAttribute(): ?int
    {
        return isset($this->metadata['page_number']) ? (int) $this->metadata['page_number'] : null;
    }

    public function setPageNumberAttribute($value): void
    {
        $this->setMetadata('page_number', $value !== null ? (int) $value : null);
    }

    /**
     * الوصف للمشاهد أو المقاطع
     */
    public function getDescriptionAttribute(): ?string
    {
        return $this->getMetadata('description');
    }

    public function setDescriptionAttribute($value): void
    {
        $this->setMetadata('description', $value !== null ? (string) $value : null);
    }

    /**
     * رابط المورد الخارجي
     */
    public function getResourceUrlAttribute(): ?string
    {
        return $this->getMetadata('resource_url');
    }

    public function setResourceUrlAttribute($value): void
    {
        $this->setMetadata('resource_url', $value !== null ? (string) $value : null);
    }

    /**
     * حالة النسخ أو التفريغ الصوتي/النصي
     */
    public function getTranscriptionStatusAttribute(): ?string
    {
        return $this->getMetadata('transcription_status');
    }

    public function setTranscriptionStatusAttribute($value): void
    {
        $this->setMetadata('transcription_status', $value !== null ? (string) $value : null);
    }

    /**
     * هل تم التعديل يدوياً من المحرر في الاستوديو
     */
    public function getIsManuallyEditedAttribute(): bool
    {
        return (bool) $this->getMetadata('is_manually_edited', false);
    }

    public function setIsManuallyEditedAttribute($value): void
    {
        $this->setMetadata('is_manually_edited', (bool) $value);
    }

    /**
     * معرّف آخر محرر قام بالتعديل
     */
    public function getLastEditorIdAttribute(): ?string
    {
        return $this->getMetadata('last_editor_id');
    }

    public function setLastEditorIdAttribute($value): void
    {
        $this->setMetadata('last_editor_id', $value !== null ? (string) $value : null);
    }

    /**
     * وقت آخر تعديل (متوافق مع طوابع Eloquent الزمنية)
     */
    public function getLastUpdatedAttribute(): ?Carbon
    {
        return $this->updated_at;
    }

    public function setLastUpdatedAttribute($value): void
    {
        // يتم التعامل معه تلقائياً بواسطة Eloquent timestamps
    }
}
