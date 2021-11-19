<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddServiceAdditionalTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_uploads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('service_id');

            $table->string('file');
            $table->unsignedTinyInteger('status')->default(\App\Services\Model\Source\Upload\Status::PENDING_APPROVAL);

            $table->timestamps();

            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onDelete('cascade');
        });

        Schema::create('service_edit_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('service_id');

            $table->unsignedTinyInteger('status')->default(\App\Services\Model\Source\EditRequest\Status::SUBMITTED);
            $table->text('detail');
            $table->text('comment')->nullable(true);
            $table->string('file')->nullable(true);

            $table->timestamps();

            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_uploads');
        Schema::dropIfExists('service_edit_requests');
    }
}
