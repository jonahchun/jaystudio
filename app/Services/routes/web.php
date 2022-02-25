<?php

Route::prefix(env('ADMIN_PATH', 'admin'))->group(function() {
    Route::prefix('multi-service')->group(function() {
        Route::get('new-service/{customer}', '\App\Services\Http\Controllers\Admin\ServiceController@serviceCreate')->name('admin.customer.service.servicecreate');
        Route::get('/', '\App\Services\Http\Controllers\Admin\ServiceController@serviceIndex')->name('admin.customer.multi-service');
        Route::post('save', '\App\Services\Http\Controllers\Admin\ServiceController@serviceSave')->name('admin.customer.multi-service.save');
    });

    Route::prefix('service')->group(function() {
        Route::post('teaser-photo/delete', '\App\Services\Http\Controllers\Admin\ServiceController@teaserPhotoDelete')->name('admin.customer.service.teaser-photo.delete');

        Route::get('/', '\App\Services\Http\Controllers\Admin\ServiceController@index')->name('admin.customer.service');
        Route::get('new', '\App\Services\Http\Controllers\Admin\ServiceController@new')->name('admin.customer.service.new');
        Route::get('new/{customer}', '\App\Services\Http\Controllers\Admin\ServiceController@create')->name('admin.customer.service.create');
        Route::get('edit/{service}', '\App\Services\Http\Controllers\Admin\ServiceController@edit')->name('admin.customer.service.edit');
        Route::post('save', '\App\Services\Http\Controllers\Admin\ServiceController@save')->name('admin.customer.service.save');
        Route::get('delete/{service}', '\App\Services\Http\Controllers\Admin\ServiceController@delete')->name('admin.customer.service.delete');
        Route::get('print/{service}', '\App\Services\Http\Controllers\Admin\ServiceController@print')->name('admin.customer.service.print');
        Route::post('send-teaser-email/{id}', '\App\Services\Http\Controllers\Admin\ServiceController@sendTeaserEmail')->name('admin.customer.service.send-teaser');
        Route::post('send-engagement-session-email/{id}', '\App\Services\Http\Controllers\Admin\ServiceController@sendEngagementSessionEmail')->name('admin.customer.service.send-engagement-session');
        

        Route::post('hold/{service}', '\App\Services\Http\Controllers\Admin\ServiceController@hold')->name('admin.customer.service.hold');
        Route::get('unhold/{service}', '\App\Services\Http\Controllers\Admin\ServiceController@unhold')->name('admin.customer.service.unhold');
        Route::get('start-draft/{service}', '\App\Services\Http\Controllers\Admin\ServiceController@startDraft')->name('admin.customer.service.start-draft');
        Route::get('process/{service}', '\App\Services\Http\Controllers\Admin\ServiceController@process')->name('admin.customer.service.process');
        Route::post('complete/{service}', '\App\Services\Http\Controllers\Admin\ServiceController@complete')->name('admin.customer.service.complete');

        Route::prefix('uploads')->group(function() {
            Route::get('/', '\App\Services\Http\Controllers\Admin\Service\UploadsController@index')->name('admin.customer.service.uploads');
            Route::get('new/{service}', '\App\Services\Http\Controllers\Admin\Service\UploadsController@create')->name('admin.customer.service.uploads.create');
            Route::get('edit/{upload}', '\App\Services\Http\Controllers\Admin\Service\UploadsController@edit')->name('admin.customer.service.uploads.edit');
            Route::post('save', '\App\Services\Http\Controllers\Admin\Service\UploadsController@save')->name('admin.customer.service.uploads.save');
        });

        Route::prefix('edit-requests')->group(function() {
            Route::get('/', '\App\Services\Http\Controllers\Admin\Service\EditRequestsController@index')->name('admin.customer.service.edit_request');
            Route::get('edit/{id}', '\App\Services\Http\Controllers\Admin\Service\EditRequestsController@edit')->name('admin.customer.service.edit_request.edit');
            Route::post('save', '\App\Services\Http\Controllers\Admin\Service\EditRequestsController@save')->name('admin.customer.service.edit_request.save');
            Route::get('start/{edit_request}', '\App\Services\Http\Controllers\Admin\Service\EditRequestsController@startWork')->name('admin.customer.service.edit_request.start');
            Route::get('print/{edit_request}', '\App\Services\Http\Controllers\Admin\Service\EditRequestsController@print')->name('admin.customer.service.edit_request.print');
        });
    });
});

Route::prefix('service')->group(function() {
    Route::get('view/{service}', '\App\Services\Http\Controllers\ServiceController@view')->name('service.view');
    Route::get('order-form/new/{service}', '\App\Services\Http\Controllers\ServiceController@orderFormNew')->name('service.order-form.new');
    Route::get('order-form/view/{service}', '\App\Services\Http\Controllers\ServiceController@orderFormView')->name('service.order-form.view');
    Route::post('order-form/save/{service}', '\App\Services\Http\Controllers\ServiceController@orderFormSave')->name('service.order-form.save');
    Route::post('order-form/update/{service}', '\App\Services\Http\Controllers\ServiceController@updateOrderForm')->name('service.order-form.update');

    Route::get('edit-reqiest/new/{service}', '\App\Services\Http\Controllers\ServiceController@editRequestNew')->name('service.edit-request.new');
    Route::post('edit-reqiest/save/{service}', '\App\Services\Http\Controllers\ServiceController@editRequestSave')->name('service.edit-request.save');
    Route::get('edit-reqiest/view/{edit_request}/{service}', '\App\Services\Http\Controllers\ServiceController@editRequestView')->name('service.edit-request.view');

    Route::get('upload/approve/{upload}/{service}', '\App\Services\Http\Controllers\ServiceController@approveUpload')->name('service.upload.approve');
});
