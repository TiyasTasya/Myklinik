<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Country extends Model
{
    protected $fillable = [
        'name',
        'code',
        'dial_code',
        'flag',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);  // ganti Country::class sesuai nama model kamu
    }
}
