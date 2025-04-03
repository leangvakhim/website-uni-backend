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
        Schema::create('tbpartnership', function (Blueprint $table) {
            $table->id('ps_id');
            $table->text('ps_title')->nullable();
            $table->foreignId('ps_img')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null'); 
            $table->tinyInteger('ps_type');
            $table->integer('ps_order');
            $table->tinyInteger('active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbpartnership');
    }
};
