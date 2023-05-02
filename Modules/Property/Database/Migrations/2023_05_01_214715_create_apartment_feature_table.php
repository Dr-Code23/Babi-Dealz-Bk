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
        Schema::create('apartment_feature', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apartment_id')
                ->constrained('apartments')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('feature_id')
                ->constrained('features')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

//            $table->primary(['apartment_id', 'feature_id']);

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
        Schema::dropIfExists('apartment_feature');
    }
};
