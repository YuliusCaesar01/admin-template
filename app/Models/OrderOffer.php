<?php

namespace App\Models;

use App\Models\OrderOfferDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderOffer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'notes',
        'terms',
        'offer_file_path',
        'invoice_file_path',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(OrderOfferDetail::class);
    }
}