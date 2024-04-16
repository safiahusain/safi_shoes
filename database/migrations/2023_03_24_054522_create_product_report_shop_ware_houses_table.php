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
        Schema::create('product_report_shop_ware_houses', function (Blueprint $table) {
            $table->id();
            $table->string('shop_godam')->nullable();
            $table->string('code')->nullable();
            $table->string('product_name')->nullable();
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->string('purchase_quantity')->nullable();
            $table->string('purchase_return_quantity')->nullable();
            $table->string('sale_quantity')->nullable();
            $table->string('sale_return_quantity')->nullable();
            $table->string('purchase_value')->nullable();
            $table->string('purchase_return_value')->nullable();
            $table->string('sale_value')->nullable();
            $table->string('sale_return_value')->nullable();
            $table->string('company_name')->nullable();
            
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
        Schema::dropIfExists('product_report_shop_ware_houses');
    }
};
