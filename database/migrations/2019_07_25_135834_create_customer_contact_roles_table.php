<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerContactRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_contact_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->unsignedInteger('sort_order')->nullable(true);
            $table->timestamps();
        });

        Schema::table('customer_contacts', function($table) {
            $table->dropColumn('role');
            $table->unsignedBigInteger('role_id')->nullable(true)->after('email');
            $table->string('telephone')->after('email');
            $table->foreign('role_id')
                ->references('id')
                ->on('customer_contact_roles')
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
        Schema::dropIfExists('customer_contact_roles');
    }
}
