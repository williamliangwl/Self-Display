<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class OutTransaction extends Model
{
    protected $table = 'out_transactions';
    public $fillable = [
        'id',
        'user_id',
        'date',
        'recipient'
    ];
}
