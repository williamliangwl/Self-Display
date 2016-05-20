<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    public $fillable = [
        'id',
        'user_id',
        'date'
    ];
}
