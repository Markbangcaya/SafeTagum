<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokenizedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'safetagumtokens';

    public function up()
    {
        Schema::create('tokenizeds', function (Blueprint $table) {
            $table->id();
            $table->string('token', 100)->unique();
            $table->string('originaldata', 100);
            $table->timestamps();

            //php artisan migrate --database=safetagumtokens --path=database/migrations/2024_08_05_075221_create_tokenizeds_table.php
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tokenizeds');
    }
}
