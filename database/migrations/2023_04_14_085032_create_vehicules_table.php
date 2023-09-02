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
        Schema::create('vehicules', function (Blueprint $table) {
            $table->id();
            $table->string('images')->nullable(false);
            $table->string('model')->nullable(false);
            $table->date('year')->nullable(false);
            $table->string('color')->nullable(false);
            $table->integer('mileage')->nullable(false);
            $table->string('fuel_type')->nullable(false);
            $table->decimal('daily_price',9,3)->nullable(false);
            $table->decimal('weekly_price',9,3)->nullable(false);
            $table->decimal('monthly_price',9,3)->nullable(false);
            $table->unsignedBigInteger('agency_id')->nullable(false);
            $table->foreign('agency_id')->references('id')->on('agencies')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicules');
    }
};
