<?php

namespace App\Models;

use App\Traits\ModelBoot;
use App\Traits\Scopes\ScopeActive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory, ScopeActive, ModelBoot;

    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';
    public const FILE_STORE_PATH = 'coupons';

    protected static function booted()
    {
        static::creating(function ($blog) {
            $blog->slug = Str::slug($blog->title);
        });

        static::updating(function ($blog) {
            $blog->slug = Str::slug($blog->title);
        });
    }

    protected $fillable = [
        'title',
        'slug',
        'description',
        'banner',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $appends = ['banner_url'];

    public function getBannerUrlAttribute()
    {
        return getStorageImage(self::FILE_STORE_PATH, $this->banner);
    }

}

