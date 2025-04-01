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
        Schema::create('tbscholarship', function (Blueprint $table) {
            $table->id('sc_id');
            $table->string('sc_sponsor', 100)->nullable(); 
            $table->string('sc_title', 255)->nullable();
            $table->string('sc_shortdesc', 255)->nullable();
            $table->text('sc_detail')->nullable();
            $table->dateTime('sc_deadline');
            $table->dateTime('sc_postdate');
            $table->foreignId('sc_img')->nullable()->constrained('tbimage', 'image_id')->nullOnDelete(); 
            $table->foreignId('scletter_img')->nullable()->constrained('tbimage', 'image_id')->nullOnDelete(); 
            $table->tinyInteger('sc_fav')->default(0);
            $table->integer('lang')->nullable(); 
            $table->integer('sc_orders'); 
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
        Schema::dropIfExists('tbscholarship');
    }
};
