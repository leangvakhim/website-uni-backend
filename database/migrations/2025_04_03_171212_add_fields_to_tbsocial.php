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
        Schema::table('tbsocial', function (Blueprint $table) {
            // $table->text('social_link')->nullable();
            if (!Schema::hasColumn('tbsocial', 'social_link')) {
                $table->text('social_link')->nullable();
            }
            $table->foreignId('social_faculty')->nullable()->constrained('tbfaculty', 'f_id')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbsocial', function (Blueprint $table) {
            $table->dropColumn('social_link');
            $table->dropForeign(['social_faculty']);
            $table->dropColumn('social_faculty');

        });
    }
};
