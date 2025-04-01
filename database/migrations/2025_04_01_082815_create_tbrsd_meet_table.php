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
        Schema::create('tbrsd_meet', function (Blueprint $table) {
            $table->id('rsdm_id');
            $table->text('rsdm_detail')->nullable();
            $table->foreignId('rsdm_img')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->foreignId('rsdm_faculty')->nullable()->constrained('tbfaculty_contact', 'fc_id')->onDelete('set null');
            $table->tinyInteger('active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbrsd_meet');
    }
};
