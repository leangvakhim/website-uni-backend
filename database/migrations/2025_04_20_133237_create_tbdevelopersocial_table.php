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
        Schema::create('tbdevelopersocial', function (Blueprint $table) {
            $table->id('ds_id');
            $table->string('ds_title', 50)->nullable();
            $table->foreignId('ds_img')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->foreignId('ds_developer')->nullable()->constrained('tbdeveloper', 'd_id')->onDelete('set null');
            $table->text('ds_link')->nullable();
            $table->integer('ds_order')->nullable();
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
        Schema::dropIfExists('tbdevelopersocial');
    }
};
