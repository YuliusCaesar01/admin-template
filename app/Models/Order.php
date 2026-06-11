<?php

namespace App\Models;

use App\Models\OrderOffer;
use App\Models\Review;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_code',
        'access_token',
        'type',
        'status',
        'sent_at',
        'pic_id',
        'created_by',
        'tujuan_pengujian',    
        'waktu_diharapkan',    
        'keterangan_tambahan', 
        'waktu_pelaksanaan',  
        'lokasi_pelaksanaan',  
        'file',
        'bukti_bayar',
        'saran',
    ];

    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime',
            'waktu_diharapkan' => 'date',
            'waktu_pelaksanaan' => 'date',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS CONSTANTS
    |--------------------------------------------------------------------------
    */

    public const STATUS_DRAFT        = 'draft';
    public const STATUS_SUBMIT       = 'submit';
    public const STATUS_OFFERED      = 'offered';
    public const STATUS_REJECTED     = 'rejected';
    public const STATUS_FORM_REQUIRED = 'form_required';
    public const STATUS_APPROVED     = 'approved';
    public const STATUS_PROCESSING   = 'processing';
    public const STATUS_DONE         = 'done';
    public const TYPE_INTERNAL = 'internal';
    public const TYPE_EXTERNAL = 'external';

    /*
    |--------------------------------------------------------------------------
    | BOOT
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::creating(function (self $order) {

            if (blank($order->access_token)) {
                $order->access_token = Str::random(6);
            }

            if (blank($order->order_code)) {
                $prefix = match($order->type) {
                    self::TYPE_INTERNAL => 'INT',
                    self::TYPE_EXTERNAL => 'EXT',
                    default             => 'ORD',
                };

                do {
                    $order->order_code =
                        'ORD-' . now()->format('Ymd') . '-' . $prefix . rand(100, 999);
                } while (self::where('order_code', $order->order_code)->exists());
            }

            if (blank($order->status)) {
                $order->status = self::STATUS_DRAFT;
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function offer(): HasOne
    {
        return $this->hasOne(OrderOffer::class);
    }

    public function getGrandTotalAttribute()
    {
        if (!$this->offer) return 0;

        return $this->offer->details->sum(function ($d) {
            return $d->qty * $d->price;
        });
    }

    public function pic(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pic_id');
    }


    public function canOpenPermohonanPdf(): bool
    {
        // Kondisi 1: order offer harus sudah ada
        if (!$this->relationLoaded('offer')) {
            $this->load('offer.details');
        }

        if (!$this->offer) {
            return false;
        }

        // Kondisi 2: offer harus punya minimal 1 detail
        if ($this->offer->details->isEmpty()) {
            return false;
        }

        return true;
    }

    public function canOpenMouKesanggupanPdf(): bool
    {
        // Status harus approved atau setelahnya
        if (!in_array($this->status, [
            self::STATUS_APPROVED,
            self::STATUS_PROCESSING,
            self::STATUS_DONE,
        ])) {
            return false;
        }

        // Waktu & lokasi harus ada
        if (blank($this->waktu_pelaksanaan) || blank($this->lokasi_pelaksanaan)) {
            return false;
        }

        // Order offer harus ada
        if (!$this->relationLoaded('offer')) {
            $this->load('offer.details');
        }

        if (!$this->offer) {
            return false;
        }

        // Offer minimal punya 1 detail
        if ($this->offer->details->isEmpty()) {
            return false;
        }

        return true;
    }

    public function canOpenBapPdf(): bool
    {
        return $this->status === self::STATUS_DONE;
    }

    public function canOpenBuktiBayar(): bool
    {
        return !blank($this->bukti_bayar);
    }

    public function canOpenLaporanKegiatanPdf(): bool
    {
        return $this->status === self::STATUS_DONE;
    }

    public function suratpks(): HasOne
    {
        return $this->hasOne(SuratPks::class);
    }

    public function suratmou(): HasOne
    {
        return $this->hasOne(SuratMou::class);
    }

    public function suratkesanggupan(): HasOne
    {
        return $this->hasOne(SuratKesanggupan::class);
    }

    public function suratbap(): HasOne
    {
        return $this->hasOne(SuratBap::class);
    }

    public function hasilUjiFiles()
    {
        return $this->hasMany(OrderFile::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

}