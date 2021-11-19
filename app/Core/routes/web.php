<?php

Route::prefix(env('ADMIN_PATH', 'admin'))->group(function() {
    Route::prefix('general')->group(function() {
        Route::prefix('pickup-location')->group(function() {
            Route::get('/', '\App\Core\Http\Controllers\Admin\PickupLocationController@index')->name('admin.pickup-location');
            Route::get('/edit/{id}', '\App\Core\Http\Controllers\Admin\PickupLocationController@edit')->name('admin.pickup-location.edit');
            Route::get('/new', '\App\Core\Http\Controllers\Admin\PickupLocationController@new')->name('admin.pickup-location.new');
            Route::post('/save', '\App\Core\Http\Controllers\Admin\PickupLocationController@save')->name('admin.pickup-location.save');
            Route::get('/delete/{id}', '\App\Core\Http\Controllers\Admin\PickupLocationController@delete')->name('admin.pickup-location.delete');
        });

        Route::prefix('questions')->group(function() {
            Route::get('/', '\App\Core\Http\Controllers\Admin\QuestionsController@index')->name('admin.questions');
            Route::get('/edit/{id}', '\App\Core\Http\Controllers\Admin\QuestionsController@edit')->name('admin.questions.edit');
            Route::get('/new', '\App\Core\Http\Controllers\Admin\QuestionsController@new')->name('admin.questions.new');
            Route::post('/save', '\App\Core\Http\Controllers\Admin\QuestionsController@save')->name('admin.questions.save');
            Route::get('/delete/{id}', '\App\Core\Http\Controllers\Admin\QuestionsController@delete')->name('admin.questions.delete');
        });
    });
});

Route::post('/file/upload', '\App\Core\Http\Controllers\UploadController@upload');