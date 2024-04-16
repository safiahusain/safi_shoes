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
        Schema::create('sale_invoice_partiis', function (Blueprint $table) {
            $table->id();
            $table->string('product_name')->nullable();
            $table->string('warehouse')->nullable();
            $table->string('code')->nullable();
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->string('price')->nullable();
            $table->string('quantity')->nullable();
            $table->string('total')->nullable();
            $table->string('discount')->nullable();
            $table->string('less')->nullable();
            $table->string('net')->nullable();
            $table->string('saleInvoiceParti_id')->nullable();
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
        Schema::dropIfExists('sale_invoice_partiis');
    }
};
