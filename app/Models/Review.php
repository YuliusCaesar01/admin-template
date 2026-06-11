<?php

namespace App\Models;

use App\Models\ReviewQuestion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'review_question_id',
        'rating',
        'comment',
    ];

    protected $casts = [
        'rating' => \App\Enums\ReviewRatingEnum::class, // Penting: Tambahkan ini
    ];

    /**
     * Get the order that owns the Review
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the reviewQuestion that owns the Review
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reviewQuestion(): BelongsTo
    {
        return $this->belongsTo(ReviewQuestion::class);
    }
}