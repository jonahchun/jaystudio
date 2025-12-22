<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeletesToAllRelatedModels extends Migration
{
    public function up()
    {
        Schema::table('customer_newlywed', function (Blueprint $table) {
            if (!Schema::hasColumn('customer_newlywed', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('customer_newlywed_details', function (Blueprint $table) {
            if (!Schema::hasColumn('customer_newlywed_details', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('customer_wedding_checklist', function (Blueprint $table) {
            if (!Schema::hasColumn('customer_wedding_checklist', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('customer_wedding_schedule', function (Blueprint $table) {
            if (!Schema::hasColumn('customer_wedding_schedule', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('customer_address', function (Blueprint $table) {
            if (!Schema::hasColumn('customer_address', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('service_links', function (Blueprint $table) {
            if (!Schema::hasColumn('service_links', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('service_online_gallery', function (Blueprint $table) {
            if (!Schema::hasColumn('service_online_gallery', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('service_teaser_photos', function (Blueprint $table) {
            if (!Schema::hasColumn('service_teaser_photos', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('online_gallery_link', function (Blueprint $table) {
            if (!Schema::hasColumn('online_gallery_link', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    public function down()
    {
        Schema::table('customer_newlywed', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('customer_newlywed_details', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('customer_wedding_checklist', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('customer_wedding_schedule', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('customer_address', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('service_links', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('service_online_gallery', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('service_teaser_photos', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('online_gallery_link', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
