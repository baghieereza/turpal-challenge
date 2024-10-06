<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;
    protected $fillable = ['product_id ' , 'price','start_time','end_time'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
