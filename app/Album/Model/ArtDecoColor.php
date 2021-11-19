<?php
namespace App\Album\Model;

use Illuminate\Database\Eloquent\Model;

class ArtDecoColor extends Model
{

    protected $table = 'album_atr_deco_colors';

    protected $fillable = ['title', 'sort_order'];

}