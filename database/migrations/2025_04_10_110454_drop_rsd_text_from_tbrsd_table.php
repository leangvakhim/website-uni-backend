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
        Schema::table('tbrsd', function (Blueprint $table) {
            $table->dropForeign(['rsd_text']); 
            $table->dropColumn('rsd_text');   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbrsd', function (Blueprint $table) {
            $table->foreignId('rsd_text')->nullable()->constrained('tbrsd_title', 'rsdt_id')->onDelete('set null');
        });
    }
};
