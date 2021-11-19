<?php

$weddingChecklistRoutes = [
    'preparation' => '\App\WeddingChecklist\Http\Controllers\Admin\PreparationController',
    'ceremony'    => '\App\WeddingChecklist\Http\Controllers\Admin\CeremonyController',
    'reception'   => '\App\WeddingChecklist\Http\Controllers\Admin\ReceptionController',
    'first-look'  => '\App\WeddingChecklist\Http\Controllers\Admin\FirstLookController',
    'vendor'      => '\App\WeddingChecklist\Http\Controllers\Admin\VendorsController',
];

Route::prefix(env('ADMIN_PATH', 'admin'))->group(function() use ($weddingChecklistRoutes) {
    Route::prefix('wedding-ckecklist')->group(function() use ($weddingChecklistRoutes) {
        foreach ($weddingChecklistRoutes as $route => $controller) {
            Route::prefix($route)->group(function() use ($route, $controller) {
                Route::get('/', $controller . '@index')->name('admin.wedding.checklist.' . $route);
                Route::get('/edit/{id}', $controller . '@edit')->name('admin.wedding.checklist.' . $route . '.edit');
                Route::get('/new', $controller . '@new')->name('admin.wedding.checklist.' . $route . '.new');
                Route::post('/save', $controller . '@save')->name('admin.wedding.checklist.' . $route . '.save');
                Route::get('/delete/{id}', $controller . '@delete')->name('admin.wedding.checklist.' . $route . '.delete');
            });
        }
    });
});