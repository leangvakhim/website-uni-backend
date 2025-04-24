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
        Schema::table('tbrsd_meet', function (Blueprint $table) {
            $table->foreignId('rsdm_rsdtitle')->nullable()->constrained('tbrsd_title', 'rsdt_id')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbrsd_meet', function (Blueprint $table) {
            $table->dropForeign(['rsdm_rsdtitle']);
            $table->dropColumn('rsdm_rsdtitle');
        });
    }
};
