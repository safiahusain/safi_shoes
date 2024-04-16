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
        Schema::create('purchase_invoice_partis', function (Blueprint $table) {
            $table->id();
            $table->string('old_balance');
            $table->string('date');
            $table->string('company_id');
            $table->string('company_name');
            $table->string('sub_total');
            $table->string('discount');
            $table->string('less');
            $table->string('net');
            $table->string('net_customer_balance');
            $table->string('total_value_of_sub_previous');
            $table->string('paid_customer_balance');
            $table->string('total_discount_value');
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
        Schema::dropIfExists('purchase_invoice_partis');
    }
};
