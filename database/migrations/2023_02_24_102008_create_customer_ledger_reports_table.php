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
        Schema::create('customer_ledger_reports', function (Blueprint $table) {
            $table->id();
            $table->string('bill_number')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('date')->nullable();
            $table->string('particular')->nullable();
            $table->string('sale_amount')->nullable();
            $table->string('paid_amount')->nullable();
            $table->string('sum_open_sale')->nullable();
            $table->string('balance')->nullable();
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
        Schema::dropIfExists('customer_ledger_reports');
    }
};
