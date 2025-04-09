<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('coupon_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('coupon_id')->constrained();
            $table->foreignId('order_id')->nullable()->constrained();
            $table->timestamps();
            
            $table->unique(['user_id', 'coupon_id']); // Ensure one coupon per user
        });
    }

    public function down()
    {
        Schema::dropIfExists('coupon_usages');
    }
};