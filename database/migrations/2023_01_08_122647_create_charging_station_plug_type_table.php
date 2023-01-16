<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charging_station_plug_type', function (Blueprint $table) {
            $table->id();
            $table->foreignId('charging_station_id')->constrained('charging_stations')->onDelete('cascade');
            $table->foreignId('plug_type_id')->constrained('plug_types')->onDelete('cascade');
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
        Schema::dropIfExists('charging_station_plug_type');
    }
};
