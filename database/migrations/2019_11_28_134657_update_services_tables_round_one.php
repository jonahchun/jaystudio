<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Services\Model\Source\Type as ServiceType;

class UpdateServicesTablesRoundOne extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_' . ServiceType::PHOTO . '_detail', function (Blueprint $table) {
            $table->string('status')->nullable(true)->change();
            $table->date('completion')->nullable(true)->change();
        });

        Schema::table('service_' . ServiceType::VIDEO . '_detail', function (Blueprint $table) {
            $table->string('status')->nullable(true)->change();
            $table->date('completion')->nullable(true)->change();
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
