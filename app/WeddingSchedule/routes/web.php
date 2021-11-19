<?php

$weddingScheduleRoutes = [
    'ceremony.setting'    => '\App\WeddingSchedule\Http\Controllers\Admin\Ceremony\SettingsController',
    'ceremony.detail'     => '\App\WeddingSchedule\Http\Controllers\Admin\Ceremony\DetailsController',
    'ceremony.tradition'  => '\App\WeddingSchedule\Http\Controllers\Admin\Ceremony\TraditionsController',
    'preparation.setting' => '\App\WeddingSchedule\Http\Controllers\Admin\Preparation\SettingsController',
];

Route::prefix(env('ADMIN_PATH', 'admin'))->group(function() use ($weddingScheduleRoutes) {
    Route::prefix('wedding-schedule')->group(function() use ($weddingScheduleRoutes) {
        foreach ($weddingScheduleRoutes as $route => $controller) {
            $_route = str_replace('.', '/', $route);
            Route::prefix($_route)->group(function() use ($route, $controller) {
                Route::get('/', $controller . '@index')->name('admin.wedding.schedule.' . $route);
                Route::get('/edit/{id}', $controller . '@edit')->name('admin.wedding.schedule.' . $route . '.edit');
                Route::get('/new', $controller . '@new')->name('admin.wedding.schedule.' . $route . '.new');
                Route::post('/save', $controller . '@save')->name('admin.wedding.schedule.' . $route . '.save');
                Route::get('/delete/{id}', $controller . '@delete')->name('admin.wedding.schedule.' . $route . '.delete');
            });
        }
    });
});
