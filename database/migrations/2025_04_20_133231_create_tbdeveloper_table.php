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
        Schema::create('tbdeveloper', function (Blueprint $table) {
            $table->id('d_id');
            $table->string('d_name', 50)->nullable();
            $table->string('d_position', 50)->nullable();
            $table->text('d_write')->nullable();
            $table->foreignId('d_img')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->integer('lang')->nullable();
            $table->integer('d_order')->nullable();
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
        Schema::dropIfExists('tbdeveloper');
    }
};
