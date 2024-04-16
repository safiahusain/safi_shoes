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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('item_code')->nullable();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->string('category_id')->nullable();
            $table->string('color_id')->nullable();
            // $table->string('size_id')->nullable();
            $table->integer('size_id')->default(0);

            $table->string('company_id')->nullable();
            $table->string('brand_id')->nullable();
            $table->string('date')->nullable();
            $table->string('purchase_price')->nullable();
            $table->string('sale_price')->nullable();
            $table->string('new_stock')->nullable();
            // $table->integer('stock_38')->nullable();

            // $table->string('size_38')->nullable();
            // $table->string('size_39')->nullable();
            // $table->string('size_40')->nullable();
            // $table->string('size_41')->nullable();
            // $table->string('size_42')->nullable();
            // $table->string('size_43')->nullable();
            // $table->string('size_44')->nullable();
            // $table->string('size_45')->nullable();
            // $table->string('size_46')->nullable();
            // $table->string('l_size_36')->nullable();
            // $table->string('l_size_37')->nullable();
            // $table->string('l_size_38')->nullable();
            // $table->string('l_size_39')->nullable();
            // $table->string('l_size_40')->nullable();
            // $table->string('l_size_41')->nullable();
            // $table->string('l_size_42')->nullable();
            // $table->string('k_size_1')->nullable();
            // $table->string('k_size_2')->nullable();
            // $table->string('k_size_3')->nullable();
            // $table->string('k_size_4')->nullable();
            // $table->string('k_size_5')->nullable();
            // $table->string('k_size_6')->nullable();
            // $table->string('k_size_7')->nullable();
            // $table->string('k_size_8')->nullable();
            // $table->string('k_size_9')->nullable();
            // $table->string('k_size_10')->nullable();
            // $table->string('k_size_11')->nullable();
            // $table->string('k_size_12')->nullable();
            // $table->string('k_size_13')->nullable();
            // $table->string('k_size_14')->nullable();
            // $table->string('k_size_15')->nullable();
            // $table->string('k_size_16')->nullable();
            // $table->string('k_size_17')->nullable();
            // $table->string('k_size_18')->nullable();
            // $table->string('k_size_19')->nullable();
            // $table->string('k_size_20')->nullable();
            // $table->string('k_size_21')->nullable();
            // $table->string('k_size_22')->nullable();
            // $table->string('k_size_23')->nullable();
            // $table->string('k_size_24')->nullable();
            // $table->string('k_size_25')->nullable();
            // $table->string('k_size_26')->nullable();
            // $table->string('k_size_27')->nullable();
            // $table->string('k_size_28')->nullable();
            // $table->string('k_size_29')->nullable();
            // $table->string('k_size_30')->nullable();
            // $table->string('k_size_31')->nullable();
            // $table->string('k_size_32')->nullable();
            // $table->string('k_size_33')->nullable();
            // $table->string('k_size_34')->nullable();
            // $table->string('k_size_35')->nullable();

            $table->string('opening_balance')->nullable();

            $table->string('quantity')->nullable();
            $table->string('total_cost')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
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
        Schema::dropIfExists('products');
    }
};
