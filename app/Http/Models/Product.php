<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    public $fillable = [
        'id',
        'name',
        'stock',
        'price',
        'capital_price',
        'is_active'
    ];
}
