<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $table = 'expenses';
    public $fillable = [
        'id',
        'date',
        'description',
        'price'
    ];
}
