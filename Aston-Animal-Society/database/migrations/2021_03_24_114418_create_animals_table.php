<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date_of_birth');
            $table->mediumText('description')->nullable();
            $table->enum('availability', ['available', 'unavailable'])->default('available');
            $table->enum('animal_type', ['cat', 'dog', 'bird', 'fish', 'reptile', 'horse', 'other'])->default('other');
            $table->string('image', 256)->nullable();
            $table->string('image2', 256)->nullable();
            $table->string('image3', 256)->nullable();
            $table->timestamps();
            $table->bigInteger('adopted_by')->unsigned()->nullable();

            $table->foreign('adopted_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animals');
    }
}
