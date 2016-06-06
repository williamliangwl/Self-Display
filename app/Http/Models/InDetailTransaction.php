<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class InDetailTransaction extends Model
{
    protected $table = 'in_detail_transactions';
    public $fillable = [
        'id',
        'transaction_id',
        'product_id',
        'quantity'
    ];
}
