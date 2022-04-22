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
        Schema::create('campinggears', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('campinggearcategory_id');
            $table->string('image');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('stok');
            $table->string('price');
            $table->string('slug')->unique();
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
        Schema::dropIfExists('campinggears');
    }
};
