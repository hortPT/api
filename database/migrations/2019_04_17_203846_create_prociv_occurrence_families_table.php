<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcivOccurrenceFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('prociv_occurrence_families', function (Blueprint $table) {
            $table->tinyIncrements('id');

            $table->unsignedSmallInteger('code')->unique();
            $table->string('name')->unique();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::drop('prociv_occurrence_families');
    }
}
