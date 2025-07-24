<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('user_name');
            $table->string('image')->nullable();
            $table->string('email')->unique();
            $table->integer('phone');
            $table->string('password');
            $table->string('country');
            $table->string('type');
            $table->integer('status')->default('0');
            $table->integer('approved_seller')->default('0');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert([
            'name' => env('APP_NAME'),
            'slug' => Str::slug(env('APP_NAME')),
            'user_name' => Str::slug(env('APP_NAME')),
            'email' => 'admin@site.com',
            'phone' => '1234567890',
            'password' => Hash::make('123456'),
            'country' => 'United States',
            'type' => 'admin',
            'status' => '1',
            'approved_seller' => '1',
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s'),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
