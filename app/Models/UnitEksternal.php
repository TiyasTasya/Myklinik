<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UnitEksternal extends Model
{
    protected $fillable = ['parent_id', 'nama', 'status'];

    protected $casts = ['status' => 'boolean'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(UnitEksternal::class, 'parent_id');
    }

    public function subUnits(): HasMany
    {
        return $this->hasMany(UnitEksternal::class, 'parent_id');
    }
}
