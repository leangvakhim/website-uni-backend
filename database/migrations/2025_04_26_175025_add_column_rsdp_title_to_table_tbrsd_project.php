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
        Schema::table('tbrsd_project', function (Blueprint $table) {
            $table->string('rsdp_title', 255)->after('rsdp_rsdtile')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbrsd_project', function (Blueprint $table) {
            $table->dropColumn('rsdp_title');
        });
    }
};
