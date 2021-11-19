<?php
namespace App\Album\Model;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{

    protected $table = 'album_sizes';

    protected $fillable = ['title', 'sort_order'];

}