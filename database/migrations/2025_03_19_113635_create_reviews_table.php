<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained('cars')->onDelete('cascade'); // Ensures review is linked to a car
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Reviewer (customer/user)
            $table->integer('rating'); // Rating out of 5
            $table->text('comment')->nullable(); // Review comment
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
