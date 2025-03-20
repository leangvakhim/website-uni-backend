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
        Schema::create('tbsocial', function (Blueprint $table) {
            $table->id('social_id'); 
            $table->foreignId('social_img')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null'); 
            $table->integer('social_order'); 
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
        Schema::table('tbsocial', function (Blueprint $table) {
            
        });
    }
};
