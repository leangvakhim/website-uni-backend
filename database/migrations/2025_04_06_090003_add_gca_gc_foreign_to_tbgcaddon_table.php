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
        Schema::table('tbgcaddon', function (Blueprint $table) {
            $table->foreignId('gca_gc')->nullable()->constrained('tbgc', 'gc_id')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbgcaddon', function (Blueprint $table) {
            $table->dropForeign(['gca_gc']);
            $table->dropColumn('gca_gc');
        });
    }
};
