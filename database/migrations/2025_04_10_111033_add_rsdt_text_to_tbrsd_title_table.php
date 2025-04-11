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
        Schema::table('tbrsd_title', function (Blueprint $table) {
            $table->foreignId('rsdt_text')->nullable()->constrained('tbrsd', 'rsd_id')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbrsd_title', function (Blueprint $table) {
            $table->dropForeign(['rsdt_text']);
            $table->dropColumn('rsdt_text');
        });
    }
};
