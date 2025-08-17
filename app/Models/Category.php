<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($category) {
            if (!empty($category->name)) {
                $category->slug = \Illuminate\Support\Str::slug($category->name);
            }
        });
    }

    /**
     * Relasi ke Book (satu kategori punya banyak buku).
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class, 'category_id');
    }
}
