<?php
namespace App\Core\Model;

use Illuminate\Database\Eloquent\Model;

class OnlineGalleryLink extends Model
{

    protected $table = 'online_gallery_link';

    protected $fillable = ['url'];

}