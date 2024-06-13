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
        Schema::create('commendation', function (Blueprint $table) {
            $table->id();
            $table->date('date_of_commendation');
            $table->string('city_municipality');
            $table->string('province');
            $table->string('region');
            $table->date('date_of_inspection');
            $table->string('service_provider');
            $table->date('first_validation');
            $table->string('remarks_1');
            $table->date('second_validation');
            $table->string('remarks_2');
            $table->string('other_activity');
            $table->integer('number_of_brgys');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commendation');
    }
};
