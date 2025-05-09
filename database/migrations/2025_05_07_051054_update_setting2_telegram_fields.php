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
        Schema::table('tbsetting2', function (Blueprint $table) {
            if (Schema::hasColumn('tbsetting2', 'set_email')) {
                $table->renameColumn('set_email', 'set_telegramtoken');
            }
        });

        Schema::table('tbsetting2', function (Blueprint $table) {
            if (Schema::hasColumn('tbsetting2', 'set_email')) {
                $table->dropColumn('set_email');
            }
        });

        Schema::table('tbsetting2', function (Blueprint $table) {
            $table->text('set_telegramtoken')->nullable()->change();
            $table->string('set_chatid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbsetting2', function (Blueprint $table) {
            $table->renameColumn('set_telegramtoken', 'set_email');
            $table->dropColumn('set_chatid');
        });
    }
};
