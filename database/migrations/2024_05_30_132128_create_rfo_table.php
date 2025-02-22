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
        Schema::create('rfo', function (Blueprint $table) {
            $table->id();
            $table->string('rfo');
            $table->string('user_id');
            $table->string('position');
            $table->integer('contact_number');
            $table->string('regCode');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rfo');
    }
};
