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
        Schema::create('orientation_inspected_agencies', function (Blueprint $table) {
            $table->id();
            $table->string('agency_lgu');
            $table->date('date_of_inspection');
            $table->string('office');
            $table->string('city_municipality');
            $table->string('province');
            $table->string('region');
            $table->date('action_plan_and_inspection_report_date_sent_to_cmeo');
            $table->date('feedback_date_sent_to_oddgo');
            $table->date('official_report_date_sent_to_oddgo');
            $table->date('feedback_date_received_from_oddgo');
            $table->date('official_report_date_received_from_oddgo');
            $table->date('feedback_date_sent_to_agencies_lgus');
            $table->date('official_report_date_sent_to_agencies_lgus');
            $table->string('orientation');
            $table->string('setup');
            $table->string('resource_speakers');
            $table->string('bpm_workshop');
            $table->string('re_engineering');
            $table->string('cc_workshop');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orientation_inspected_agencies');
    }
};
