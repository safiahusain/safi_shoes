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
        Schema::create('bank_entries', function (Blueprint $table) {
             $table->id();
            $table->string('bank_name');
            $table->string('description')->nullable();
            $table->string('date')->nullable();
            $table->string('deposit')->nullable();
            $table->string('withdrawal')->nullable();
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
        Schema::dropIfExists('bank_entries');
    }
};
