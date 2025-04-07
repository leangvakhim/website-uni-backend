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
        Schema::table('tbfaqaddon', function (Blueprint $table) {
            $table->foreignId('fa_faq')->nullable()->constrained('tbfaq', 'faq_id')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbfaqaddon', function (Blueprint $table) {
            $table->dropForeign(['fa_faq']);
            $table->dropColumn('fa_faq');
        });
    }
};
