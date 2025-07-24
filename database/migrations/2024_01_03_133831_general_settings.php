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
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name');
            $table->string('site_logo');
            $table->string('favicon');
            $table->string('site_email');
            $table->string('site_contact');
            $table->text('site_desc')->nullable();
            $table->string('cur_format');
            $table->string('copyright_txt');
            $table->boolean('show_email')->default('1');
            $table->boolean('show_contact')->default('1');
            $table->string('address');
            $table->string('country');
            $table->string('site_seo_title')->nullable();
            $table->text('site_seo_desc')->nullable();
        });

        DB::table('general_settings')->insert([
            'site_name' => 'YahooBaba Tour Travel',
            'site_logo' => 'logo.png',
            'favicon' => 'favicon.png',
            'site_email' => 'company@email.com',
            'site_contact' => '0987654321',
            'site_desc' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable. If you are going to use a passage of Lorem Ipsum you need to be sure there isnt anything embarrassing hidden in the middle of text.',
            'cur_format' => '$',
            'copyright_txt' => 'Copyright © 2023-2024',
            'address' => 'New York',
            'country' => 'United States',
            'site_seo_title' => 'Yahoobaba Tour Travel',
            'site_seo_desc' => 'Yahoobaba Tour Travel',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }
};
