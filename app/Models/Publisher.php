<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Publisher extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'country_code',
        'logo_path',
    ];

    /**
     * النسخ التي نشرها هذا الناشر
     */
    public function versions()
    {
        return $this->hasMany(Version::class);
    }

    /**
     * الكتب المنشورة عبر هذا الناشر
     */
    public function books()
    {
        return $this->hasManyThrough(
            Book::class,
            Version::class,
            'publisher_id',
            'id',
            'id',
            'versionable_id'
        )->where('versions.versionable_type', 'book');
    }

    /**
     * الصوتيات المنشورة عبر هذا الناشر
     */
    public function audios()
    {
        return $this->hasManyThrough(
            Audio::class,
            Version::class,
            'publisher_id',
            'id',
            'id',
            'versionable_id'
        )->where('versions.versionable_type', 'audio');
    }

    /**
     * المرئيات المنشورة عبر هذا الناشر
     */
    public function videos()
    {
        return $this->hasManyThrough(
            Video::class,
            Version::class,
            'publisher_id',
            'id',
            'id',
            'versionable_id'
        )->where('versions.versionable_type', 'video');
    }

    /**
     * المخطوطات المنشورة عبر هذا الناشر
     */
    public function manuscripts()
    {
        return $this->hasManyThrough(
            Manuscript::class,
            Version::class,
            'publisher_id',
            'id',
            'id',
            'versionable_id'
        )->where('versions.versionable_type', 'manuscript');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($publisher) {
            if (empty($publisher->slug)) {
                $publisher->slug = \App\Helpers\SlugHelper::generate($publisher->name);
            }
        });

        static::updating(function ($publisher) {
            if (empty($publisher->slug)) {
                $publisher->slug = \App\Helpers\SlugHelper::generate($publisher->name);
            }
        });
    }
}
