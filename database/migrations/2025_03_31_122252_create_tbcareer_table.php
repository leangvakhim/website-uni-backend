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
        Schema::create('tbcareer', function (Blueprint $table) {
            $table->id('c_id');
            $table->text('c_title')->nullable();
            $table->text('c_shorttitle')->nullable();
            $table->foreignId('c_img')->nullable()->constrained('tbimage', 'image_id')->nullOnDelete(); 
            $table->dateTime('c_date')->nullable();
            $table->text('c_detail')->nullable(); 
            $table->tinyInteger('c_fav')->default(0);
            $table->integer('lang')->nullable();
            $table->integer('c_order');
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
        Schema::dropIfExists('tbcareer');
    }
};
