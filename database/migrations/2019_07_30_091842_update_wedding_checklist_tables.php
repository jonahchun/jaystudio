<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateWeddingChecklistTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wedding_checklist_preparations', function (Blueprint $table) {
            $table->tinyInteger('has_details')->after('sort_order');
        });

        Schema::table('wedding_checklist_ceremonies', function (Blueprint $table) {
            $table->tinyInteger('has_details')->after('sort_order');
        });

        Schema::table('wedding_checklist_portrait_sessions_first_looks', function (Blueprint $table) {
            $table->tinyInteger('has_details')->after('sort_order');
        });

        Schema::table('wedding_checklist_receptions', function (Blueprint $table) {
            $table->tinyInteger('has_details')->after('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
