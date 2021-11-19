<?php

namespace App\WeddingSchedule\Model\Ceremony;

use Illuminate\Database\Eloquent\Model;

class Tradition extends Model
{

    protected $table = 'wedding_schedule_ceremony_traditions';

    protected $fillable = ['title', 'identifier', 'sort_order'];

}