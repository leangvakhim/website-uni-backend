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
        Schema::table('tbtext', function (Blueprint $table) {
            if (!Schema::hasColumn('tbtext', 'text_sec')) {
                $table->foreignId('text_sec')->nullable()->after('text_id')->constrained('tbsection', 'sec_id')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbtext', function (Blueprint $table) {
            if (Schema::hasColumn('tbtext', 'text_sec')){
                $table->dropForeign(['text_sec']);
                $table->dropColumn('text_sec');
            }
        });
    }
};
