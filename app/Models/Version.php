<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id
 * @property string $versionable_id
 * @property string $versionable_type
 * @property string|null $publisher_id
 * @property int|null $language_id
 * @property int|null $shelf_id
 * @property string|null $title
 * @property string|null $file_path
 * @property string|null $cover_path
 * @property string|null $format
 * @property int $file_size
 * @property string|null $isbn
 * @property int|null $pages
 * @property int|null $published_year
 * @property int $edition_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Model $versionable
 * @property-read \App\Models\Publisher|null $publisher
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @property-read \App\Models\Language|null $language
 * @property-read \App\Models\Shelf|null $shelf
 * @property-read string|null $file_url
 */
class Version extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'versionable_id',
        'versionable_type',
        'publisher_id',
        'language_id',
        'shelf_id',
        'title',
        'file_path',
        'cover_path',
        'format',
        'file_size',
        'isbn',
        'pages',
        'published_year',
        'edition_number',
    ];

    /**
     * العنصر المرتبط بهذه النسخة (كتاب، فيديو، إلخ)
     */
    public function versionable()
    {
        return $this->morphTo();
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function shelf()
    {
        return $this->belongsTo(Shelf::class);
    }

    protected $appends = ['file_url', 'cover_url'];

    public function getFileUrlAttribute(): ?string
    {
        if (empty($this->file_path)) {
            return null;
        }

        if (str_starts_with($this->file_path, 'http://') || str_starts_with($this->file_path, 'https://')) {
            return $this->file_path;
        }

        return \Illuminate\Support\Facades\Storage::disk('media')->url($this->file_path);
    }

    public function getCoverUrlAttribute(): ?string
    {
        if (empty($this->cover_path)) {
            return null;
        }

        if (str_starts_with($this->cover_path, 'http://') || str_starts_with($this->cover_path, 'https://')) {
            return $this->cover_path;
        }

        return \Illuminate\Support\Facades\Storage::disk('media')->url($this->cover_path);
    }
}
