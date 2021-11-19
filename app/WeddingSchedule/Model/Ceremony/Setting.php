<?php

namespace App\WeddingSchedule\Model\Ceremony;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    protected $table = 'wedding_schedule_ceremony_settings';

    protected $fillable = ['title', 'identifier', 'sort_order'];

}