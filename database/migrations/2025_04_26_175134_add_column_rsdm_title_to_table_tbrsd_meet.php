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
            $table->string('rsdm_title', 255)->after('rsdm_rsdtitle')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbrsd_meet', function (Blueprint $table) {
            $table->dropColumn('rsdm_title');
        });
    }
};
