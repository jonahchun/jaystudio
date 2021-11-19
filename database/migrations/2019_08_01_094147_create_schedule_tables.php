<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_wedding_schedule', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id');
            
            $table->text('availability')->nullable(true);
            $table->text('comment')->nullable(true);
            $table->string('file')->nullable(true);

            $table->tinyInteger('current_step');

            $table->timestamps();

            $table->foreign('customer_id')
                ->references('id')
                ->on('customer')
                ->onDelete('cascade');
        });

        Schema::create('customer_wedding_schedule_preparation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('schedule_id');

            $table->string('type')->nullable(true);

            $table->string('preparation_start_time')->nullable(true);
            $table->date('preparation_start_date')->nullable(true);

            $table->string('transportation_start_time')->nullable(true);
            $table->date('transportation_start_date')->nullable(true);

            $table->string('emergency_contact')->nullable(true);
            $table->tinyInteger('is_private')->nullable(true);

            $table->timestamps();
            $table->foreign('schedule_id')
                ->references('id')
                ->on('customer_wedding_schedule')
                ->onDelete('cascade');
        });

        Schema::create('customer_wedding_schedule_ceremony', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('schedule_id');

            $table->string('ceremony_start_time')->nullable(true);
            $table->string('ceremony_end_time')->nullable(true);

            $table->string('invitation_start_time')->nullable(true);
            $table->string('invitation_end_time')->nullable(true);

            $table->string('rehearsal_start_time')->nullable(true);
            $table->string('rehearsal_end_time')->nullable(true);

            $table->string('settings')->nullable(true);
            $table->string('details')->nullable(true);
            $table->tinyInteger('ceremony_traditions')->nullable(true);
            
            $table->timestamps();
            $table->foreign('schedule_id')
                ->references('id')
                ->on('customer_wedding_schedule')
                ->onDelete('cascade');
        });

        Schema::create('customer_wedding_schedule_reception', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('schedule_id');

            $table->string('venue_coordinator_name')->nullable(true);
            $table->string('venue_coordinator_email')->nullable(true);
            $table->string('venue_coordinator_phone')->nullable(true);

            $table->string('viennese_start_time')->nullable(true);
            $table->string('viennese_end_time')->nullable(true);

            $table->string('cake_cutting_time')->nullable(true);

            $table->string('reception_start_time')->nullable(true);
            $table->string('reception_end_time')->nullable(true);

            $table->string('cocktails_start_time')->nullable(true);
            $table->string('cocktails_end_time')->nullable(true);

            $table->string('afterparty_start_time')->nullable(true);
            $table->string('afterparty_end_time')->nullable(true);

            $table->tinyInteger('number_of_toasts')->nullable(true);
            $table->text('toast_givers')->nullable(true);
            
            $table->timestamps();
            $table->foreign('schedule_id')
                ->references('id')
                ->on('customer_wedding_schedule')
                ->onDelete('cascade');
        });

        Schema::create('customer_wedding_schedule_portrait_session', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('schedule_id');

            $table->tinyInteger('when')->nullable(true);

            $table->string('portrait_start_time')->nullable(true);
            $table->string('portrait_end_time')->nullable(true);

            $table->timestamps();
            $table->foreign('schedule_id')
                ->references('id')
                ->on('customer_wedding_schedule')
                ->onDelete('cascade');
        });


        Schema::create('customer_wedding_schedule_address', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('schedule_id');

            $table->string('type')->nullable(true);
            $table->string('address_line_1')->nullable(true);
            $table->string('address_line_2')->nullable(true);
            $table->string('country')->nullable(true);
            $table->string('state')->nullable(true);
            $table->string('city')->nullable(true);
            $table->string('zip')->nullable(true);

            $table->timestamps();
            $table->foreign('schedule_id')
                ->references('id')
                ->on('customer_wedding_schedule')
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
        Schema::dropIfExists('customer_wedding_schedule');
        Schema::dropIfExists('customer_wedding_schedule_preparation_location');
        Schema::dropIfExists('customer_wedding_schedule_ceremony');
        Schema::dropIfExists('customer_wedding_schedule_reception');
        Schema::dropIfExists('customer_wedding_schedule_portrait_session');
        Schema::dropIfExists('customer_wedding_schedule_address');
    }
}
