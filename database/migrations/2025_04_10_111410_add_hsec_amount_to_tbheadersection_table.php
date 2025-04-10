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
        Schema::table('tbheadersection', function (Blueprint $table) {
            $table->tinyInteger('hsec_amount')->nullable()->after('hsec_btntitle');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbheadersection', function (Blueprint $table) {
            $table->dropColumn('hsec_amount');
        });
    }
};
