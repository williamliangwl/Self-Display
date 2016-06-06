<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class InTransaction extends Model
{
    protected $table = 'in_transactions';
    public $fillable = [
        'id',
        'user_id',
        'date'
    ];
}
