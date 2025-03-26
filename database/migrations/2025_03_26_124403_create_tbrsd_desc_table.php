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
        Schema::create('tbrsd_desc', function (Blueprint $table) {
            $table->id('rsdd_id');
            $table->text('rsdd_details')->nullable(); 
            $table->tinyInteger('active')->default(1);        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbrsd_desc');
    }
};
