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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('item_code')->nullable();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->string('category_id')->nullable();
            $table->string('color_id')->nullable();
            $table->string('size_id')->nullable();
            $table->string('company_id')->nullable();
            $table->string('brand_id')->nullable();
            $table->string('date')->nullable();
            $table->string('purchase_price')->nullable();
            $table->string('sale_price')->nullable();
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
        Schema::dropIfExists('stocks');
    }
};
