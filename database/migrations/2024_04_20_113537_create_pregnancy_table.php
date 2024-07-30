<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pregnancy', function (Blueprint $table) {
            $table->string('week');
            $table->double('length');
            $table->double('weight');
            $table->string('hCG norms', length: 100);
            $table->string('Heart_rate', length: 100)->nullable();
            $table->text('Title1')->nullable();
            $table->text('Description1')->nullable();
            $table->text('Title2')->nullable();
            $table->text('Description2')->nullable();
            $table->text('Title3')->nullable();
            $table->text('Description3')->nullable();
            $table->text('Title4')->nullable();
            $table->text('Description4')->nullable();
            $table->text('Fruits_and_Veggies');
            $table->text('Fruits_and_Veggies_photo');
            $table->text('baby_photo');
            $table->string('youtupe_vedio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pregnancy');
    }
};
