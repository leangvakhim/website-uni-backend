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
        Schema::table('tbbanner', function (Blueprint $table) {
            if (!Schema::hasColumn('tbbanner', 'ban_sec')) {
                $table->foreignId('ban_sec')->nullable()->constrained('tbsection', 'sec_id')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbbanner', function (Blueprint $table) {
            $table->dropForeign(['ban_sec']);
            $table->dropColumn('ban_sec');
        });
    }
};
