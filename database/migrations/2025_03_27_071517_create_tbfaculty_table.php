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
        Schema::create('tbfaculty', function (Blueprint $table) {
            $table->id('f_id');
            $table->string('f_name', 255)->nullable();
            $table->string('f_position', 100)->nullable();
            $table->text('f_portfolio')->nullable(); 
        
            $table->foreignId('f_img')->nullable()->constrained('tbimage', 'image_id')->onDelete('set null');
            $table->foreignId('f_social')->nullable()->constrained('tbsocial', 'social_id')->onDelete('set null');
            $table->foreignId('f_contact')->nullable()->constrained('tbfaculty_contact', 'fc_id')->onDelete('set null');
            $table->foreignId('f_info')->nullable()->constrained('tbfaculty_info', 'finfo_id')->onDelete('set null');
            $table->foreignId('f_bg')->nullable()->constrained('tbfaculty_bg', 'fbg_id')->onDelete('set null');
        
            $table->integer('f_order');
            $table->integer('lang')->nullable(); 
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
        Schema::dropIfExists('tbfaculty');
    }
};
