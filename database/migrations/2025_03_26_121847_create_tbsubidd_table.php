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
        Schema::create('tbsubidd', function (Blueprint $table) {
            $table->id('sidd_id'); 
            $table->string('sidd_title', 255)->nullable();
            $table->string('sidd_subtitle', 255)->nullable();
            $table->string('sidd_tag', 255)->nullable();
            $table->dateTime('sidd_date')->nullable();
            $table->integer('sidd_order');
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
        Schema::dropIfExists('tbsubidd');
    }
};
