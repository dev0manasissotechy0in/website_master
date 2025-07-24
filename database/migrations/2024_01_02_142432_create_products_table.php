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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->integer('category');
            $table->integer('sub_category')->nullable();
            $table->string('tags')->nullable();
            $table->integer('price')->nullable();
            $table->string('thumbnail')->nullable();
            $table->text('images')->nullable();
            $table->text('desc')->nullable();
            $table->string('preview_link')->nullable();
            $table->string('download_file')->nullable();
            $table->integer('user');
            $table->boolean('status')->default('1');
            $table->boolean('approved')->default('0');
            $table->boolean('featured')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
