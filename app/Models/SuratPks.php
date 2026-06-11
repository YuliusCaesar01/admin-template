<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratPks extends Model
{
    use SoftDeletes;

    protected $table = 'surat_pks';

    protected $fillable = [
        'order_id',
        'nomor',
        'type',
        'bulan',
        'tahun',
    ];

    protected function casts(): array
    {
        return [
            'bulan' => 'integer',
            'tahun' => 'integer',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getNomorSuratAttribute(): string
    {
        return $this->nomor ?? static::generateNomor($this->bulan, $this->tahun);
    }


    public static function generateNomor(int $bulan, int $tahun): string
    {
        $romawi = ['', 'I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'];

        $urutan = static::whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->withTrashed()
            ->count() + 1; // +1 supaya mulai dari 001

        return sprintf('%03d/PKS/PM.PUTP/ATMI/%s/%d', $urutan, $romawi[$bulan], $tahun);
    }
}