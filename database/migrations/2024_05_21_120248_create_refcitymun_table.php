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
        Schema::create('refcitymun', function (Blueprint $table) {
            $table->id();
            $table->integer('psgcCode');
            $table->string('citymunDesc');
            $table->integer('regCode');
            $table->foreign('regCode')
                ->references('regCode')->on('refregion')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('provCode');
            $table->foreign('provCode')
                ->references('provCode')->on('refprovince')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('citymunCode')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refcitymun');
    }
};
