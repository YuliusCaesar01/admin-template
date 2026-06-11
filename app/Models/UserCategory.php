<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class UserCategory extends Model
{

    protected $primaryKey = 'category_id';
    
    use HasUuids;

    protected $fillable = [
        'code',
        'user_type',
        'category_name',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    public function users()
    {
        return $this->hasMany(User::class);
    }
}