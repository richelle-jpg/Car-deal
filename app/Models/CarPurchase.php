<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarPurchase extends Model
{
    protected $table = 'car_purchases';
    protected $fillable = ['name', 'price', 'quantity'];
}
