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
        Schema::create('tbbutton', function (Blueprint $table) {
            $table->id('button_id'); 
            $table->string('btn_title', 255)->nullable(); 
            $table->text('btn_url')->nullable(); 
            $table->integer('lang')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbbutton');
    }
};
