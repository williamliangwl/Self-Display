<?php
/**
 * Created by PhpStorm.
 * User: willi
 * Date: 02-Aug-16
 * Time: 5:32 PM
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class CashExpense extends Model
{
    protected $table = 'cash_expenses';
    public $fillable = [
        'id',
        'date',
        'description',
        'price',
        'user_id'
    ];
}