<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Village extends Model
{
    protected $table = 'indonesia_regions';

    protected $primaryKey = 'code';

    public $incrementing = false;

    public $timestamps = false;

    protected $keyType = 'string';

    protected $fillable = [
        'code',
        'name',
        'postal_code',
        'status',
        'search_text',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('village', function (Builder $query) {
            $query->whereRaw('CHAR_LENGTH(code) = 13');
        });
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'code', 'code');
    }
}
