<?php
// app/Models/PackageBlackoutDate.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageBlackoutDate extends Model
{
    protected $fillable = ['package_id', 'date', 'note'];

    protected function casts(): array
    {
         return ['date' => 'datetime'];
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}