<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'category';

    protected $fillable = [
        'id',
        'category_id',
        'nama_category',
    ];

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class, 'category_id', 'category_id');
    }
}