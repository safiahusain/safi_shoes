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
        Schema::create('purchase_invoice_return_partis', function (Blueprint $table) {
            $table->id();
            $table->string('old_balance')->nullable();
            $table->string('date')->nullable();
            $table->string('company_id')->nullable();
            $table->string('company_name')->nullable();
            $table->string('sub_total')->nullable();
            $table->string('discount')->nullable();
            $table->string('less')->nullable();
            $table->string('net')->nullable();
            $table->string('net_customer_balance')->nullable();
            $table->string('total_value_of_sub_previous')->nullable();
            $table->string('paid_customer_balance')->nullable();
            $table->string('total_discount_value')->nullable();
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
        Schema::dropIfExists('purchase_invoice_return_partis');
    }
};
