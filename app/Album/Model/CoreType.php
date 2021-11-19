<?php
namespace App\Album\Model;

use Illuminate\Database\Eloquent\Model;

class CoreType extends Model
{

    protected $table = 'album_core_types';

    protected $fillable = ['title', 'photos_count', 'sort_order'];

}