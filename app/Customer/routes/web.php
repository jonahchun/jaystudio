<?php

Route::get('register', function() {
    abort(404);
})->name('register');
Route::post('register', function() {
    abort(404);
});

Route::get('dashboard', '\\' . App\Customer\Http\Controllers\IndexController::class . '@dashboard')->name('customer.account');
Route::get('insurance/download/file/{id}', '\\' . App\Customer\Http\Controllers\IndexController::class . '@downloadInsuranceFile')->name('downloadInsuranceFile');

Route::prefix('customer')->group(function() {

    Route::post('auto-save','\\' . App\Customer\Http\Controllers\CustomerController::class . '@autoSave')->name('customer.autosave');
    Route::get('complete-profile/{token}', '\\' . App\Customer\Http\Controllers\CustomerController::class . '@completeProfile')->name('customer.complete.profile');
    Route::post('complete-profile/save', '\\' . App\Customer\Http\Controllers\CustomerController::class . '@completeProfileSave')->name('customer.complete.profile.save');

    Route::get('information', '\\' . App\Customer\Http\Controllers\IndexController::class . '@info')->name('customer.information');

    Route::prefix('contacts')->group(function() {
        Route::get('/', '\\' . App\Customer\Http\Controllers\ContactsController::class . '@index')->name('customer.contacts');
        Route::post('save', '\\' . App\Customer\Http\Controllers\ContactsController::class . '@save')->name('customer.contacts.save');
        Route::get('delete/{id}', '\\' . App\Customer\Http\Controllers\ContactsController::class . '@delete')->name('customer.contacts.delete');
    });

    Route::prefix('wedding')->group(function() {
        Route::get('info', '\\' . App\Customer\Http\Controllers\Wedding\InfoController::class . '@index')->name('customer.wedding.info');

        Route::prefix('checklist')->group(function() {
            Route::get('/', '\\' . App\Customer\Http\Controllers\Wedding\ChecklistController::class . '@index')->name('customer.wedding.checklist');
            Route::post('save', '\\' . App\Customer\Http\Controllers\Wedding\ChecklistController::class . '@save')->name('customer.wedding.checklist.save');
        });
;;
        Route::prefix('schedule')->group(function() {
            Route::get('/', '\\' . App\Customer\Http\Controllers\Wedding\ScheduleController::class . '@index')->name('customer.wedding.schedule');
            Route::post('save', '\\' . App\Customer\Http\Controllers\Wedding\ScheduleController::class . '@save')->name('customer.wedding.schedule.save');

        });

        Route::prefix('details')->group(function() {
            Route::get('/', '\\' . App\Customer\Http\Controllers\Wedding\DetailsController::class . '@index')->name('customer.details.form');
            Route::post('save', '\\' . App\Customer\Http\Controllers\Wedding\DetailsController::class . '@save')->name('customer.details.save');
        });

        Route::prefix('cinematography')->group(function() {
            Route::get('/', '\\' . App\Customer\Http\Controllers\Wedding\CinematographyController::class . '@index')->name('customer.cinematography.form');
        });

        Route::prefix('teaser-photo')->group(function() {
            Route::get('/', '\\' . App\Customer\Http\Controllers\Wedding\TeaserPhotoController::class . '@index')->name('customer.teaser_photo.index');
            Route::get('/zip/file/download/{file}/{form}','\\'. App\Customer\Http\Controllers\Wedding\TeaserPhotoController::class . '@zipFileDownload')->name('customer.teaser_photo.zip-file-download');
        });

        Route::prefix('online-gallery')->group(function() {
            Route::get('/{gallery_name}', '\\' . App\Customer\Http\Controllers\Wedding\OnlineGalleryController::class . '@index')->name('customer.online-gallery.index');
        });
    });
});

Route::prefix(env('ADMIN_PATH', 'admin'))->group(function() {
    Route::get('downloadfile/{key}/{id}', '\App\Customer\Http\Controllers\Admin\CustomerController@downloadFile')->name('admin.downloadfile');

    Route::prefix('notification')->group(function() {
        Route::get('/', '\\' . '\App\Notification\Http\Controllers\Admin\NotificationController@index')->name('admin.notification');
        Route::get('new/{customer_id?}', '\App\Notification\Http\Controllers\Admin\NotificationController@new')->name('admin.notification.new');
        Route::get('edit/{id}', '\App\Notification\Http\Controllers\Admin\NotificationController@edit')->name('admin.notification.edit');
        Route::get('delete/{id}', '\App\Notification\Http\Controllers\Admin\NotificationController@delete')->name('admin.notification.delete');
    });

    Route::prefix('customer')->group(function() {
        Route::prefix('contact')->group(function() {
            Route::get('/', '\App\Customer\Http\Controllers\Admin\ContactController@index')->name('admin.customer.contact');
            Route::get('/edit/{id}', '\App\Customer\Http\Controllers\Admin\ContactController@edit')->name('admin.customer.contact.edit');
            Route::get('/new', '\App\Customer\Http\Controllers\Admin\ContactController@new')->name('admin.customer.contact.new');
            Route::post('/save', '\App\Customer\Http\Controllers\Admin\ContactController@save')->name('admin.customer.contact.save');
            Route::get('/delete/{id}', '\App\Customer\Http\Controllers\Admin\ContactController@delete')->name('admin.customer.contact.delete');

            Route::prefix('role')->group(function() {
                Route::get('/', '\App\Customer\Http\Controllers\Admin\Contact\RoleController@index')->name('admin.customer.contact.role');
                Route::get('/edit/{id}', '\App\Customer\Http\Controllers\Admin\Contact\RoleController@edit')->name('admin.customer.contact.role.edit');
                Route::get('/new', '\App\Customer\Http\Controllers\Admin\Contact\RoleController@new')->name('admin.customer.contact.role.new');
                Route::post('/save', '\App\Customer\Http\Controllers\Admin\Contact\RoleController@save')->name('admin.customer.contact.role.save');
                Route::get('/delete/{id}', '\App\Customer\Http\Controllers\Admin\Contact\RoleController@delete')->name('admin.customer.contact.role.delete');
            });
        });

        Route::get('send-invite-email/{customer}', '\App\Customer\Http\Controllers\Admin\CustomerController@sendInviteEmail')->name('admin.customer.send.invite.email');

        Route::prefix('print')->group(function() {
            Route::get('/contacts/{customer}', '\App\Customer\Http\Controllers\Admin\PrintController@printContacts')->name('admin.customer.print.contacts');
            Route::get('/wedding-checklist/{customer}', '\App\Customer\Http\Controllers\Admin\PrintController@printWeddingChecklist')->name('admin.customer.print.wedding-checklist');
            Route::get('/wedding-schedule/{customer}', '\App\Customer\Http\Controllers\Admin\PrintController@printWeddingSchedule')->name('admin.customer.print.wedding-schedule');
            Route::get('/newlywed-details/{customer}', '\App\Customer\Http\Controllers\Admin\PrintController@printNewlywedDetails')->name('admin.customer.print.newlywed-details');
            Route::get('/file/download/{file}', '\App\Customer\Http\Controllers\Admin\PrintController@printFileDownload')->name('admin.customer.print.file-download');
        });
    });
});
