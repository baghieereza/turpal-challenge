<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    const DefaultFilterPeriod = 2;
    protected $fillable = ['name' , 'description','thumbnail'];

    protected $casts = ['thumbnail' => 'array'];

    public function availabilities()
    {
        return $this->hasMany(Availability::class);
    }
}
