<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarPurchasesTable extends Migration
{
    public function up()
    {
        Schema::create('car_purchases', function (Blueprint $table) {
            $table->id(); // auto-incrementing primary key
            $table->bigInteger('user_id')->unsigned(); // reference to the user
            $table->timestamps(); // created_at and updated_at columns
        });
    }

    public function down()
    {
        Schema::dropIfExists('car_purchases');
    }
}
