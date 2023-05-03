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
        Schema::create('feature_property', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feature_id')
                ->constrained('features')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('apartment_id')->nullable()
                ->constrained('apartments')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('villa_id')->nullable()
                ->constrained('villas')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('land_id')->nullable()
                ->constrained('lands')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('shop_id')->nullable()
                ->constrained('shops')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('hangar_id')->nullable()
                ->constrained('hangars')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
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
        Schema::dropIfExists('feature_property');
    }
};
