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
        Schema::create('slides', function (Blueprint $table) {
            $table->id();
            $table->string('title_en', 500);
            $table->string('title_kh', 500);
            $table->text('description_en')->nullable();
            $table->text('description_kh')->nullable();
            $table->string('url', 255);
            $table->string('image')->nullable();
            $table->string('status', 255)->default('active');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slides');
        Schema::table('slides', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
