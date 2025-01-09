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
        Schema::create('cities__municipalities', function (Blueprint $table) {
            $table->id();
            $table->string('psgcCode');
            $table->string('citymunDesc');
            $table->string('regCode');
            $table->string('provCode');
            $table->string('citymunCode');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities__municipalities');
    }
};
