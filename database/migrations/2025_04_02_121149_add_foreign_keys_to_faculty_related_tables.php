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
        Schema::table('tbfaculty_contact', function (Blueprint $table) {
            $table->foreignId('fc_f')->nullable()->constrained('tbfaculty', 'f_id')->onDelete('set null');
        });

        Schema::table('tbfaculty_bg', function (Blueprint $table) {
            $table->foreignId('fbg_f')->nullable()->constrained('tbfaculty', 'f_id')->onDelete('set null');
        });

        Schema::table('tbfaculty_info', function (Blueprint $table) {
            $table->foreignId('finfo_f')->nullable()->constrained('tbfaculty', 'f_id')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
            Schema::table('tbfaculty_contact', function (Blueprint $table) {
                $table->dropForeign(['fc_f']);
                $table->dropColumn('fc_f');
            });
    
            Schema::table('tbfaculty_bg', function (Blueprint $table) {
                $table->dropForeign(['fbg_f']);
                $table->dropColumn(['fbg_f']);
            });
    
            Schema::table('tbfaculty_info', function (Blueprint $table) {
                $table->dropForeign(['finfo_f']);
                $table->dropColumn('finfo_f');
            });
    }
};
