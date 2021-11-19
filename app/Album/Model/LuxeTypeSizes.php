<?php
namespace App\Album\Model;

use Illuminate\Database\Eloquent\Model;

class LuxeTypeSizes extends Model
{

    protected $table = 'album_luxe_type_sizes';

    protected $fillable = ['album_luxe_type_id', 'album_size_id'];

}