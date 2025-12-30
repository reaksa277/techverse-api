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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title_en', 500);
            $table->string('title_kh', 500);
            $table->text('description_en');
            $table->text('description_kh');
            $table->text('info_en')->nullable();
            $table->text('info_kh')->nullable();
            $table->string('image', 1000)->nullable();
            $table->string('status', 255)->default('1');
            $table->foreignId('category_id')->constrained('category_articles')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropForeign(['category_id']);
        });

        Schema::dropIfExists('articles');
    }
};
