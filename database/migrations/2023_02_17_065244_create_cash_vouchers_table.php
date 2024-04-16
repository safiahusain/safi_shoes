<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('voice_number')->nullable();
            $table->string('entry_type')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('description')->nullable();
            $table->string('paid_amount')->nullable();
            $table->string('date')->nullable();
            $table->string('salesman')->nullable();
            $table->string('customer')->nullable();
            $table->string('customer_address')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_vouchers');
    }
};
