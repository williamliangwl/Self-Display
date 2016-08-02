<?php
/**
 * Created by PhpStorm.
 * User: willi
 * Date: 28-Jul-16
 * Time: 12:10 AM
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    protected $table = 'buyers';
    public $fillable = [
        'id',
        'phone',
        'name',
        'address'
    ];
}