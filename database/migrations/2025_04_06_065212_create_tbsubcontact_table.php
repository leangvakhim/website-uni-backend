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
        Schema::create('tbsubcontact', function (Blueprint $table) {
            $table->id('scon_id');
            $table->string('scon_title', 50)->nullable();
            $table->string('scon_detail', 255)->nullable();
            $table->foreignId('scon_img')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->integer('scon_order')->nullable();
            $table->boolean('display')->default(0);
            $table->boolean('active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbsubcontact');
    }
};
