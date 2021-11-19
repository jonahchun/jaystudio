<?php

Route::get('/', function () {
    return redirect()->route('customer.account');
})->name('dashboard');

Route::get('/cms/page/view/{page}', '\WFN\CMS\Http\Controllers\PageController@view')->middleware('auth');

Route::group([], base_path('app/Core/routes/web.php'));
Route::group([], base_path('app/Customer/routes/web.php'));
Route::group([], base_path('app/Payments/routes/web.php'));
Route::group([], base_path('app/WeddingChecklist/routes/web.php'));
Route::group([], base_path('app/WeddingSchedule/routes/web.php'));
Route::group([], base_path('app/Album/routes/web.php'));
Route::group([], base_path('app/Card/routes/web.php'));
Route::group([], base_path('app/Services/routes/web.php'));