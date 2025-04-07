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
        Schema::table('tbrason', function (Blueprint $table) {
            $table->foreignId('rason_ras')->nullable()->constrained('tbras', 'ras_id')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbrason', function (Blueprint $table) {
            $table->dropForeign(['rason_ras']);
            $table->dropColumn('rason_ras');
        });
    }
};
