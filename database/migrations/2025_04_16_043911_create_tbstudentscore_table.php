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
        Schema::create('tbstudentscore', function (Blueprint $table) {
            $table->id('score_id');
            $table->foreignId('student_id')->nullable()->constrained('tbstudents', 'student_id')->onDelete('set null');
            $table->foreignId('subject_id')->nullable()->constrained('tbsubjects', 'subject_id')->onDelete('set null');
            $table->integer('score')->nullable();
            $table->tinyInteger('display')->default(0);
            $table->tinyInteger('active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbstudentscore');
    }
};
