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
        Schema::create('eboss', function (Blueprint $table) {
            $table->id();
            $table->date('date_of_inspection');
            $table->string('city_municipality');
            $table->string('province');
            $table->string('region');
            $table->date('date_submitted');
            $table->string('type_of_boss');
            $table->date('deadline_of_action_plan');
            $table->date('submission_of_action_plan');
            $table->string('remarks');
            $table->string('bplo_head');
            $table->string('contact_no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eboss');
    }
};
