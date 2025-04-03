<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Car extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'type',
        'price',
        'color',
        'description',
        'number_of_cars',
        'picture',
    ];

    /**
     * Define a relationship with the Order model.
     * A car can have multiple orders (purchases).
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'car_id');
    }

    // Calculate average rating
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('ratings') ?: 0;
}
}
