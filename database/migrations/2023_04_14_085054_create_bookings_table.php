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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->date('pickup_date');
            $table->string('pickup_location');
            $table->string('return_location');
            $table->string('return_date');
            $table->decimal('total_price');
            // les champs foreign key 
            $table->unsignedBigInteger('vehicule_id')->nullable(false);
            $table->unsignedBigInteger('agency_id')->nullable(false);
            $table->unsignedBigInteger('client_id')->nullable(false);
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('agency_id')->references('id')->on('agencies')->onDelete('cascade');
            $table->foreign('vehicule_id')->references('id')->on('vehicules')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
