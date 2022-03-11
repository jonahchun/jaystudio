<?php

namespace App\Customer\Helper;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
class Data
{

    public static function getCustomersWithUpcomingWedding()
    {
        return \Customer::whereHas('detail', function($query) {
            $query->where('wedding_date', '>=', Carbon::now()->format('Y-m-d'))
                ->orderBy('wedding_date', 'asc');
        })->limit(5)->get();
    }

    public static function saveNotification($notifData){
        Auth::user()->notifications()->create($notifData);
    }
}
