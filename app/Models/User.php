<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'user_category_id',
        'organization_name',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function category()
    {
        return $this->belongsTo(
            UserCategory::class,
            'user_category_id',
            'id'
        );
    }

    public function isInternal(): bool
    {
        return $this->category?->user_type === 'internal';
    }

    public function isExternal(): bool
    {
        return $this->category?->user_type === 'external';
    }
}