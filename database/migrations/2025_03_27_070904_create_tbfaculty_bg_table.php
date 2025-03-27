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
        Schema::create('tbfaculty_bg', function (Blueprint $table) {
            $table->id('fbg_id'); 
            $table->text('fbg_name')->nullable();
            $table->foreignId('fbg_img')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->integer('fbg_order');
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
        Schema::dropIfExists('tbfaculty_bg');
    }
};
