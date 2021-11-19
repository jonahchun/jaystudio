<?php

namespace App\WeddingSchedule\Model\Ceremony;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{

    protected $table = 'wedding_schedule_ceremony_details';

    protected $fillable = ['title', 'identifier', 'sort_order'];

}