<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_assessments', function (Blueprint $table) {
            $table->id();
            $table->string('case_id', 50)->nullable();
            $table->string('epi_id', 50)->nullable();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('type_of_disease');
            $table->date('date_onset_of_illness')->nullable();
            $table->string('health_facility', 100)->nullable();
            $table->date('patient_admitted')->nullable();
            $table->enum('case_classification', ['Suspected', 'Confirmed', 'Probable'])->nullable();
            $table->date('date_of_death')->nullable();
            $table->unsignedBigInteger('assess_by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('type_of_disease')->references('id')->on('diseases');
            $table->foreign('assess_by')->references('id')->on('users');

            $table->index(['type_of_disease', 'assess_by', 'patient_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_assessments');
    }
}
