<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('middlename');
            $table->string('lastname');
            $table->date('birthdate');
            $table->string('gender');
            $table->string('occupation')->nullable();
            $table->string('civil_status', 10)->nullable();
            $table->string('nationality', 30)->nullable();
            $table->string('contact_number', 15);
            $table->string('email')->nullable()->unique();

            $table->string('street/purok');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->unsignedBigInteger('barangay_id');
            $table->string('city');
            $table->string('province');

            $table->unsignedBigInteger('type_of_disease');
            $table->unsignedBigInteger('last_modified_by');
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('barangay_id')->references('id')->on('barangays');
            $table->foreign('type_of_disease')->references('id')->on('diseases');
            $table->foreign('last_modified_by')->references('id')->on('users');

            $table->index(['barangay_id', 'type_of_disease', 'last_modified_by']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
