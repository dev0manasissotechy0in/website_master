<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon');
            $table->string('link');
            $table->boolean('status')->default('1');
            $table->timestamps();
        });

        DB::table('social_links')->insert([
            ['name' => 'Facebook',
            'icon' => 'bi bi-facebook',
            'link' => 'https://www.facebook.com/yahooobaba/',],
            ['name' => 'Instagram',
            'icon' => 'bi bi-instagram',
            'link' => 'https://www.instagram.com/yahooobaba/',],
            ['name' => 'Linkedin',
            'icon' => 'bi bi-linkedin',
            'link' => 'https://www.linkedin.com/yahooobaba/',],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_links');
    }
};
