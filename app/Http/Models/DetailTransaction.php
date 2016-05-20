<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaction extends Model
{
    protected $table = 'detail_transactions';
    public $fillable = [
        'id',
        'transaction_id',
        'product_id',
        'quantity'
    ];
}
