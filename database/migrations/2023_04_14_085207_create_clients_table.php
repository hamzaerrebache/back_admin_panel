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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('mail')->unique();
            $table->string('first_name_client')->nullable(false);
            $table->string('last_name_client')->nullable(false);
            $table->timestamp('email_verified_at')->nullable(false);
            $table->string('password_client')->nullable(false);
            $table->string('adress_client')->nullable(false);
            $table->integer('code_postal_client')->nullable(false);
            $table->string('city_client')->nullable(false);
            $table->string('country_client')->nullable(false);
            $table->string('pays_client')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
