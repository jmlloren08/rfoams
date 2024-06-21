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
        Schema::create('orientation_overall', function (Blueprint $table) {
            $table->id();
            $table->string('orientation_date');
            $table->string('agency_lgu');
            $table->string('office');
            $table->string('city_municipality');
            $table->string('province');
            $table->string('region');
            $table->string('is_ra_11032');
            $table->string('is_cart');
            $table->string('is_programs_and_services');
            $table->string('is_cc_orientation');
            $table->string('is_cc_workshop');
            $table->string('is_bpm_workshop');
            $table->string('is_ria');
            $table->string('is_eboss');
            $table->string('is_csm');
            $table->string('is_reeng');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orientation_overall');
    }
};
