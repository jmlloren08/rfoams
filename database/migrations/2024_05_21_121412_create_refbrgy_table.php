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
        Schema::create('refbrgy', function (Blueprint $table) {
            $table->id();
            $table->integer('brgyCode');
            $table->string('brgyDesc');
            // foreign key to refregion
            $table->integer('regCode');
            $table->foreign('regCode')
                ->references('regCode')->on('refregion')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            // foreign key to refprovince
            $table->integer('provCode');
            $table->foreign('provCode')
                ->references('provCode')->on('refprovince')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            // foreign key to refcitymun
            $table->integer('citymunCode');
            $table->foreign('citymunCode')
                ->references('citymunCode')->on('refcitymun')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refbrgy');
    }
};
