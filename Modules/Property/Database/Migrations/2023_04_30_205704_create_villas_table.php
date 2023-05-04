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
        Schema::create('villas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_type_id')
                ->constrained('property_types')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('city_id')
                ->constrained('cities')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('country_id')
                ->constrained('countries')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('type')->default('villa');
            $table->string('address')->nullable();
            $table->double('latitude', 15, 8)->nullable();
            $table->double('longitude', 15, 8)->nullable();
            $table->float('space');
            $table->string('budget');
            $table->integer('number_of_rooms');
            $table->integer('number_of_kitchen');
            $table->integer('number_of_bathroom');
            $table->integer('role_villa');
            $table->string('description')->nullable();
            $table->string('is_there_swimming_pool')->nullable();

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
        Schema::dropIfExists('villas');
    }
};
