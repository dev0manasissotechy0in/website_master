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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->longText('desc')->nullable();
            $table->boolean('show_in_header')->default('0');
            $table->boolean('show_in_footer')->default('0');
            $table->boolean('status')->default('1');
            $table->timestamps();
        });

        DB::table('pages')->insert([
            ['title' => 'About',
            'slug' => 'about',],
            ['title' => 'Terms & Conditions',
            'slug' => 'terms-conditions',],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
