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
        Schema::create('tbsubtse', function (Blueprint $table) {
            $table->id('stse_id');
            $table->string('stse_title', 255)->nullable();
            $table->text('stse_detail')->nullable();     
            $table->integer('stse_order');
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
        Schema::dropIfExists('tbsubtse');
    }
};
