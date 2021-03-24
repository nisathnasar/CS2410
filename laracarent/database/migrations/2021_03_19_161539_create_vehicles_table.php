<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('reg_no', 8)->unique();
            $table->enum('category', ['car', 'truck'])->default('car');
            $table->string('brand', 30)->nullable();
            $table->decimal('daily_rate', 6, 2)->default(9.99);
            $table->string('description', 256)->nullable();
            $table->string('image', 256)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
