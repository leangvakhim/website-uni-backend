<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbrsdl', function (Blueprint $table) {
            $table->id('rsdl_id');
            $table->string('rsdl_title', 255)->nullable();
            $table->text('rsdl_detail')->nullable(); 
            $table->tinyInteger('rsdl_fav')->default(0);
            $table->integer('lang')->nullable(); 
            $table->integer('rsdl_order');
            $table->tinyInteger('display')->default(0);
            $table->tinyInteger('active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbrsdl');
    }
};
