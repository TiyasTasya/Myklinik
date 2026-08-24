<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class District extends Model
{
    protected $table = 'indonesia_regions';

    protected $primaryKey = 'code';

    public $incrementing = false;

    public $timestamps = false;

    protected $keyType = 'string';

    protected $fillable = ['code', 'name', 'status', 'postal_code', 'search_text'];

    protected static function booted(): void
    {
        static::addGlobalScope('district', function (Builder $query) {
            $query->whereRaw('CHAR_LENGTH(code) = 8');
        });
    }

    public function regency()
    {
        return $this->belongsTo(Regency::class, 'code', 'code');
    }

    public function villages()
    {
        return $this->hasMany(Village::class, 'code', 'code');
    }
}
