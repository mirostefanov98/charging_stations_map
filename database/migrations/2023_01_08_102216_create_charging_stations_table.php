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
        Schema::create('charging_stations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->onDelete('SET NULL');
            $table->string('name');
            $table->string('working_time');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 10, 8);
            $table->unsignedBigInteger('charging_station_type_id')->nullable()->onDelete('SET NULL');
            $table->text('description');
            $table->json('images')->nullable();
            $table->boolean('publish');
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
        Schema::dropIfExists('charging_stations');
    }
};
