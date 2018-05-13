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

            $table->increments('id');

            $table->string('brand');

            $table->string('color');

            $table->string('user_id');

            $table->integer('category_id');

            $table->string('vcn')->unique()->comment(
                'This represents the Vehincle Chasis Number'
            );

            $table->string('vln')->unique()->comment(
                'This represents the Vehincle License Number'
            );

            $table->enum('types', [
                'suv',
                'wagon',
                'saloon',
                'scooter',
                'trailer',
                'motorcycle',
            ]);

            $table->softDeletes();

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
