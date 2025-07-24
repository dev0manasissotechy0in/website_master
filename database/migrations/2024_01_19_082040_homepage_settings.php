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
        Schema::create('homepage_settings', function (Blueprint $table) {
            $table->id();
            $table->string('section_name');
            $table->string('section_title');
            $table->text('section_desc')->nullable();
            $table->boolean('status')->default('1');
            $table->timestamps();
        });

        DB::table('homepage_settings')->insert([
            ['section_name' => 'Featured Products',
            'section_title' => 'Featured Products',
            'section_desc' => '',
            'status' => '0',],
            ['section_name' => 'Latest Products',
            'section_title' => 'Latest Products',
            'section_desc' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Enim voluptates maxime a nemo exercitationem totam.',
            'status' => '1',],
            ['section_name' => 'Blog Section',
            'section_title' => 'Latest Blogs',
            'section_desc' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Enim voluptates maxime a nemo exercitationem totam.',
            'status' => '1',],
            ['section_name' => 'Newsletter',
            'section_title' => 'Subscribe Our Newsletter',
            'section_desc' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Enim voluptates maxime a nemo exercitationem totam.',
            'status' => '1',],
            ['section_name' => 'Testimonials',
            'section_title' => 'Testimonials',
            'section_desc' => '',
            'status' => '1',],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homepage_settings');
    }
};
