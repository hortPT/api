<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcivOccurrencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('prociv_occurrences', static function (Blueprint $table): void {
            $table->increments('id');
            $table->string('remote_id')->unique();

            $table->unsignedSmallInteger('ground_assets');
            $table->unsignedSmallInteger('ground_operatives');

            $table->unsignedSmallInteger('aerial_assets');
            $table->unsignedSmallInteger('aerial_operatives');

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
        Schema::drop('prociv_occurrences');
    }
}
