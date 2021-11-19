<?php

Route::prefix('payments/invoice')->group(function() {
    Route::get('list', '\App\Payments\Http\Controllers\InvoiceController@index')->name('paymets.invoice.list');
    Route::get('view/{invoice}', '\App\Payments\Http\Controllers\InvoiceController@view')->name('paymets.invoice.view');
});

Route::prefix(env('ADMIN_PATH', 'admin'))->group(function() {
    Route::prefix('paypal')->group(function() {
        Route::prefix('invoices')->group(function() {
            Route::get('/', '\App\Payments\Http\Controllers\Admin\IndexController@index')->name('admin.payments.invoices');
            Route::get('new/{customer_id?}', '\App\Payments\Http\Controllers\Admin\IndexController@new')->name('admin.payments.invoices.new');
            Route::get('edit/{id}', '\App\Payments\Http\Controllers\Admin\IndexController@edit')->name('admin.payments.invoices.edit');
            Route::get('delete/{id}', '\App\Payments\Http\Controllers\Admin\IndexController@delete')->name('admin.payments.invoices.delete');
            Route::post('save', '\App\Payments\Http\Controllers\Admin\IndexController@save')->name('admin.payments.invoices.save');
            Route::get('mark-as-paid/{id}', '\App\Payments\Http\Controllers\Admin\IndexController@markAsPaid')->name('admin.payments.invoices.mark_as_paid');
            Route::get('payers/{customer}', '\App\Payments\Http\Controllers\Admin\IndexController@payersListByCustomer')->name('admin.payments.invoices.payers');
        });
    });
});