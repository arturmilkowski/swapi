<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(
            'people',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('planet_id')->nullable();
                $table->string('name');
                $table->integer('height');
                $table->integer('mass');
                $table->string('hair_color', 30);
                $table->string('gender', 6);
                $table->string('homeworld');
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
}
