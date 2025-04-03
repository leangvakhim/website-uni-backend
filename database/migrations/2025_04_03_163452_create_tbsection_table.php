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
        Schema::create('tbsection', function (Blueprint $table) {
            $table->id('sec_id');
            $table->foreignId('sec_page')->nullable()->constrained('tbpage', 'p_id')->onDelete('set null'); 
            $table->integer('sec_order');
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
        Schema::dropIfExists('tbsection');
    }
};
