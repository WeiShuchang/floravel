<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Adding user_id field
            $table->unsignedBigInteger('flower_id'); // Add foreign key to reference the flowers table
            $table->decimal('total_amount', 10, 2); // Assuming total_amount is in decimal format with 10 digits in total and 2 decimal places
            $table->boolean('pending')->default(true); // Adding pending field, defaulting it to true
            $table->string('shipping_address'); // Adding shipping_address field
            $table->decimal('quantity', 10);
            $table->boolean('is_delivered')->default(false);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict'); // Adding foreign key constraint
            $table->foreign('flower_id')->references('id')->on('flowers')->onDelete('restrict'); // Add foreign key constraint
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
