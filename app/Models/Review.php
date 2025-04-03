<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'car_id', 'ratings'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Car
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

}
