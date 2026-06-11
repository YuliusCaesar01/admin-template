<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderFile extends Model
{
    protected $table = 'order_file';

    protected $fillable = [
        'order_id',
        'hasil_uji_file',
        'file_name',
        'link_url',
        'link_label',
    ];

    /**
     * Relasi ke order
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}