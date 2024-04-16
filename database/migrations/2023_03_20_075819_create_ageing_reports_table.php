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
        Schema::create('ageing_reports', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('amount')->nullable();
            $table->string('ageing_date')->nullable();
            $table->string('due_date')->nullable();
            $table->string('receive_amount')->nullable();
            $table->string('remaining')->nullable();
            
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
        Schema::dropIfExists('ageing_reports');
    }
};
