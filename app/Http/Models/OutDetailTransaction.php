<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class OutDetailTransaction extends Model
{
    protected $table = 'out_detail_transactions';
    public $fillable = [
        'id',
        'transaction_id',
        'product_id',
        'quantity',
        'deal_price'
    ];
}
