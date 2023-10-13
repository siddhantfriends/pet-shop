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

            $table->foreignId('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('no action');

            $table->foreignId('order_status_id')->references('id')->on('order_statuses')
                ->onUpdate('cascade')->onDelete('no action');

            $table->foreignId('payment_id')->references('id')->on('payments')
                ->onUpdate('cascade')->onDelete('no action');

            $table->string('uuid')->unique();
            $table->json('products');
            $table->json('address');
            $table->float('delivery_fee')->nullable();
            $table->float('amount');
            $table->timestamps();
            $table->timestamp('shipped_at')->nullable();
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
