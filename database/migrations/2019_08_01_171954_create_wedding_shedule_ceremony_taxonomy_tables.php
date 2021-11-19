<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeddingSheduleCeremonyTaxonomyTables extends Migration
{
    
    protected $tables = [
        'wedding_schedule_ceremony_settings',
        'wedding_schedule_ceremony_details',
        'wedding_schedule_ceremony_traditions'
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach($this->tables as $table) {
            Schema::create($table, function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->string('title');
                $table->string('identifier');
                $table->unsignedInteger('sort_order')->nullable(true);

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach($this->tables as $table) {
            Schema::dropIfExists($table);
        }
    }
}
