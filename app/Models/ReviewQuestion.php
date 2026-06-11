<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\ReviewQuestionCategoryEnum; // Penting: Tambahkan ini

class ReviewQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_text',
        'category', // Tambahkan ini
    ];

    protected $casts = [
        'category' => ReviewQuestionCategoryEnum::class, // Tambahkan ini
    ];

    /**
     * Get all of the reviews for the ReviewQuestion
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}