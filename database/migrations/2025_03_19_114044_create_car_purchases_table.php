<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('car_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained('cars')->onDelete('cascade'); // Car being purchased
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Buyer
            $table->decimal('amount_paid', 10, 2); // Price paid
            $table->date('purchase_date'); // Date of purchase
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('car_purchases');
    }
};
