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
        Schema::create('tbmenu', function (Blueprint $table) {
            $table->id('menu_id');
            $table->string('title', 255);
            $table->integer('menu_order');
            $table->foreignId('menup_id')->nullable()->constrained('tbmenu', 'menu_id')->onDelete('set null'); 
            $table->integer('lang')->nullable();
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
        Schema::dropIfExists('tbmenu');
    }
};
