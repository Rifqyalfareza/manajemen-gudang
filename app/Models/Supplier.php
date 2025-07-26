<?php

namespace App\Models;

use Filament\Panel\Concerns\HasFont;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function stockIns()
    {
        return $this->hasMany(StockIn::class);
    }
}
