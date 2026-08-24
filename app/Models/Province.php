<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Province extends Model
{
    protected $table = 'indonesia_regions';

    protected $primaryKey = 'code';

    public $incrementing = false;

    public $timestamps = false;

    protected $keyType = 'string';

    protected $fillable = ['code', 'name', 'status', 'postal_code', 'search_text'];

    protected static function booted(): void
    {
        static::addGlobalScope('province', function (Builder $query) {
            $query->whereRaw('CHAR_LENGTH(code) = 2');
        });
    }

    public function regencies()
    {
        return $this->hasMany(Regency::class, 'code', 'code');
    }
}
