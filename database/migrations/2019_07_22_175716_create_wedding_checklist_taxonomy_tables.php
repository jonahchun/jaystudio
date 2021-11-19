<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeddingChecklistTaxonomyTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wedding_checklist_preparations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('title');
            $table->unsignedInteger('sort_order')->nullable(true);
            $table->timestamps();
        });

        Schema::create('wedding_checklist_ceremonies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('title');
            $table->unsignedInteger('sort_order')->nullable(true);
            $table->timestamps();
        });

        Schema::create('wedding_checklist_portrait_sessions_first_looks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('title');
            $table->unsignedInteger('sort_order')->nullable(true);
            $table->timestamps();
        });

        Schema::create('wedding_checklist_receptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('title');
            $table->unsignedInteger('sort_order')->nullable(true);
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
        Schema::dropIfExists('wedding_checklist_preparations');
        Schema::dropIfExists('wedding_checklist_ceremonies');
        Schema::dropIfExists('wedding_checklist_portrait_sessions_first_looks');
        Schema::dropIfExists('wedding_checklist_receptions');
    }
}
