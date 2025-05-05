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
        Schema::create('tbemail', function (Blueprint $table) {
            $table->id('m_id'); 
            $table->string('m_firstname', 255)->nullable();
            $table->string('m_lastname', 255)->nullable();
            $table->string('m_email', 100)->nullable();
            $table->text('m_description')->nullable();
            $table->tinyInteger('m_active')->default(1); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbemail');
    }
};
