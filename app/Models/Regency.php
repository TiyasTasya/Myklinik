<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Regency extends Model
{
    protected $table = 'indonesia_regions';

    protected $primaryKey = 'code';

    public $incrementing = false;

    public $timestamps = false;

    protected $keyType = 'string';

    protected $fillable = ['code', 'name', 'status', 'postal_code', 'search_text'];

    protected static function booted(): void
    {
        static::addGlobalScope('regency', function (Builder $query) {
            $query->whereRaw('CHAR_LENGTH(code) = 5');
        });
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'code', 'code');
    }

    public function districts()
    {
        return $this->hasMany(District::class, 'code', 'code');
    }
}
