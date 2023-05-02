<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_type_id')
                ->constrained('property')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('city_id')
                ->constrained('city')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('country_id')
                ->constrained('country')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('address')->nullable();
            $table->double('latitude', 15, 8)->nullable();
            $table->double('longitude', 15, 8)->nullable();
            $table->float('space');
            $table->string('budget');
            $table->number('number_of_rooms');
            $table->number('number_of_kitchen');
            $table->number('number_of_bathroom');
            $table->number('role_number');
            $table->string('description')->nullable();
            $table->string('type')->default('apartment');

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
        Schema::dropIfExists('apartments');
    }
};
