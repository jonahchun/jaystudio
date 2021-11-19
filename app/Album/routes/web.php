<?php

$albumRoutes = [
    'size'              => '\App\Album\Http\Controllers\Admin\SizesController',
    'core-type'         => '\App\Album\Http\Controllers\Admin\CoreTypeController',
    'luxe-type'         => '\App\Album\Http\Controllers\Admin\LuxeTypeController',
    'vintage-cover'     => '\App\Album\Http\Controllers\Admin\VintageCoverController',
    'black-matte-cover' => '\App\Album\Http\Controllers\Admin\BlackMatteCoverController',
    'art-deco-color'    => '\App\Album\Http\Controllers\Admin\ArtDecoColorController',
    'art-deco-pattern'  => '\App\Album\Http\Controllers\Admin\ArtDecoPatternController',
    'acrylic-images'    => '\App\Album\Http\Controllers\Admin\AcrylicImagesController',
];

Route::prefix(env('ADMIN_PATH', 'admin'))->group(function() use ($albumRoutes) {
    Route::prefix('album')->group(function() use ($albumRoutes) {
        foreach($albumRoutes as $route => $controller) {
            Route::prefix($route)->group(function() use ($route, $controller) {
                Route::get('/', $controller . '@index')->name('admin.album.' . $route);
                Route::get('/edit/{id}', $controller . '@edit')->name('admin.album.' . $route . '.edit');
                Route::get('/new', $controller . '@new')->name('admin.album.' . $route . '.new');
                Route::post('/save', $controller . '@save')->name('admin.album.' . $route . '.save');
                Route::get('/delete/{id}', $controller . '@delete')->name('admin.album.' . $route . '.delete');
            });
        }
    });
});