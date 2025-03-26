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
        Schema::create('tbfaculty_info', function (Blueprint $table) {
            $table->id('finfo_id');
            $table->string('finfo_title', 255)->nullable();
            $table->text('finfo_detail')->nullable(); 
            $table->integer('finfo_side'); 
            $table->integer('finfo_order');
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
        Schema::dropIfExists('tbfaculty_info');
    }
};
