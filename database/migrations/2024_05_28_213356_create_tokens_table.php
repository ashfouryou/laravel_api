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
        Schema::create('api_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('token')->unique();
            $table->dateTime('expires_at')->nullable();
            $table->json('permissions')->nullable();
            $table->timestamps();
        });

        DB::table('api_tokens')->insert([
            'token' => Str::random(60),
            'expires_at' => null, // Set expiration date if needed
            'permissions' => json_encode(['read', 'write']), // Set permissions if needed
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      //
    }
};
