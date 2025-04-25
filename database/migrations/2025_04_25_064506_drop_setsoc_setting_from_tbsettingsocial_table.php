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
        Schema::table('tbsettingsocial', function (Blueprint $table) {
            $table->dropForeign(['setsoc_setting']);
            $table->dropColumn('setsoc_setting');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbsettingsocial', function (Blueprint $table) {
            $table->foreignId('setsoc_setting')->nullable()->constrained('tbsetting2', 'set_id')->onDelete('set null');
        });
    }
};
