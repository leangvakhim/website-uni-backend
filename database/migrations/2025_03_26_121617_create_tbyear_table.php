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
        Schema::create('tbyear', function (Blueprint $table) {
            $table->id('y_id');
            $table->string('y_title', 50)->nullable();
            $table->string('y_subtitle', 255)->nullable();
            $table->text('y_detail')->nullable();
            $table->integer('y_order');
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
        Schema::dropIfExists('tbyear');
    }
};
