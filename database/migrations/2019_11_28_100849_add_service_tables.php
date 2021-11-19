<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Services\Model\Source\Type as ServiceType;
use App\Album\Model\Source\Type as AlbumType;

class AddServiceTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $types = ServiceType::getInstance()->getOptions();

            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id');
            $table->enum('type', array_keys($types));

            $table->timestamps();
            $table->foreign('customer_id')
                ->references('id')
                ->on('customer')
                ->onDelete('cascade');
        });

        Schema::create('service_' . ServiceType::PHOTO . '_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('service_id');

            $table->string('status');
            $table->date('completion');

            $table->timestamps();
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onDelete('cascade');
        });

        Schema::create('service_' . ServiceType::VIDEO . '_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('service_id');

            $table->string('status');
            $table->date('completion');

            $table->timestamps();
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onDelete('cascade');
        });

        Schema::create('service_' . ServiceType::TYC . '_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('service_id');

            $table->unsignedTinyInteger('layout_type');
            $table->text('message')->nullable(true);
            
            $table->unsignedBigInteger('size_id')->nullable(true);
            $table->unsignedTinyInteger('format')->nullable(true);
            $table->unsignedTinyInteger('cards_amount')->nullable(true);
            
            $table->unsignedBigInteger('front_side_template_id')->nullable(true);
            $table->text('front_side_images')->nullable(true);
            
            $table->unsignedBigInteger('inside_template_id')->nullable(true);
            $table->text('inside_images')->nullable(true);
            
            $table->unsignedBigInteger('back_side_template_id')->nullable(true);
            $table->text('back_side_images')->nullable(true);
            
            $table->text('comment')->nullable(true);
            $table->string('file')->nullable(true);

            $table->timestamps();
            
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onDelete('cascade');

            $table->foreign('size_id')
                ->references('id')
                ->on('card_sizes')
                ->onDelete('set null');

            $table->foreign('front_side_template_id')
                ->references('id')
                ->on('card_templates')
                ->onDelete('set null');

            $table->foreign('inside_template_id')
                ->references('id')
                ->on('card_templates')
                ->onDelete('set null');

            $table->foreign('back_side_template_id')
                ->references('id')
                ->on('card_templates')
                ->onDelete('set null');
        });

        Schema::create('service_' . ServiceType::STDC . '_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('service_id');

            $table->unsignedBigInteger('size_id')->nullable(true);
            $table->unsignedTinyInteger('format')->nullable(true);
            $table->unsignedTinyInteger('cards_amount')->nullable(true);
            $table->text('reception_address')->nullable(true);

            $table->unsignedBigInteger('front_side_template_id')->nullable(true);
            $table->text('front_side_images')->nullable(true);

            $table->unsignedBigInteger('back_side_template_id')->nullable(true);
            $table->text('back_side_images')->nullable(true);

            $table->text('comment')->nullable(true);
            $table->string('file')->nullable(true);

            $table->timestamps();
            
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onDelete('cascade');

            $table->foreign('size_id')
                ->references('id')
                ->on('card_sizes')
                ->onDelete('set null');

            $table->foreign('front_side_template_id')
                ->references('id')
                ->on('card_templates')
                ->onDelete('set null');

            $table->foreign('back_side_template_id')
                ->references('id')
                ->on('card_templates')
                ->onDelete('set null');
        });

        Schema::create('service_' . ServiceType::PHOTO_ALBUM . '_detail', function (Blueprint $table) {
            $types = AlbumType::getInstance()->getOptions();

            $table->bigIncrements('id');
            $table->unsignedBigInteger('service_id');

            $table->enum('type', array_keys($types));
            
            $table->unsignedBigInteger('delivery_location_id')->nullable(true);
            $table->text('comment')->nullable(true);
            $table->string('file')->nullable(true);

            $table->timestamps();
            
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onDelete('cascade');

            $table->foreign('delivery_location_id')
                ->references('id')
                ->on('general_pickup_locations')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
        Schema::dropIfExists('service_' . ServiceType::PHOTO . '_detail');
        Schema::dropIfExists('service_' . ServiceType::VIDEO . '_detail');
        Schema::dropIfExists('service_' . ServiceType::TYC . '_detail');
        Schema::dropIfExists('service_' . ServiceType::STDC . '_detail');
        Schema::dropIfExists('service_' . ServiceType::PHOTO_ALBUM . '_detail');
    }

}
