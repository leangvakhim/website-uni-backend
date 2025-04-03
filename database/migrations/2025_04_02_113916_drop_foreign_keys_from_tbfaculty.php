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
        Schema::table('tbfaculty', function (Blueprint $table) {
            $table->dropForeign(['f_social']);
            $table->dropForeign(['f_contact']);
            $table->dropForeign(['f_info']);
            $table->dropForeign(['f_bg']);

            $table->dropColumn('f_social');
            $table->dropColumn('f_contact');
            $table->dropColumn('f_info');
            $table->dropColumn('f_bg');     
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbfaculty', function (Blueprint $table) {
            $table->foreignId('f_social')->nullable()->constrained('tbsocial', 'social_id')->onDelete('set null');
            $table->foreignId('f_contact')->nullable()->constrained('tbfaculty_contact', 'fc_id')->onDelete('set null');
            $table->foreignId('f_info')->nullable()->constrained('tbfaculty_info', 'finfo_id')->onDelete('set null');
            $table->foreignId('f_bg')->nullable()->constrained('tbfaculty_bg', 'fbg_id')->onDelete('set null');
        });
    }
};
