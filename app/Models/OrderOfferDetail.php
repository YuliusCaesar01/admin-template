<?php

namespace App\Models;

use App\Models\Package;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderOfferDetail extends Model
{
    protected $fillable = [
        'order_offer_id',
        'package_id',
        'qty',
        'price',
        'nama_mahasiswa',
    ];

    protected function casts(): array
    {
        return [
            'qty'   => 'integer',
            'price' => 'decimal:2',
        ];
    }

    public function offer(): BelongsTo
    {
        return $this->belongsTo(OrderOffer::class, 'order_offer_id');
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}