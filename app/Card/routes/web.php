<?php

$cardRoutes = [
    'size'     => '\App\Card\Http\Controllers\Admin\SizesController',
    'template' => '\App\Card\Http\Controllers\Admin\TemplateController',
];

Route::prefix(env('ADMIN_PATH', 'admin'))->group(function() use ($cardRoutes) {
    Route::prefix('card')->group(function() use ($cardRoutes) {
        foreach($cardRoutes as $route => $controller) {
            Route::prefix($route)->group(function() use ($route, $controller) {
                Route::get('/', $controller . '@index')->name('admin.card.' . $route);
                Route::get('/edit/{id}', $controller . '@edit')->name('admin.card.' . $route . '.edit');
                Route::get('/new', $controller . '@new')->name('admin.card.' . $route . '.new');
                Route::post('/save', $controller . '@save')->name('admin.card.' . $route . '.save');
                Route::get('/delete/{id}', $controller . '@delete')->name('admin.card.' . $route . '.delete');
            });
        }
    });
});