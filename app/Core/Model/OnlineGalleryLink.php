<?php
namespace App\Core\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnlineGalleryLink extends Model
{
    use SoftDeletes;

    const PIXIESET = 'Pixieset';
    const ZENFOLIO = 'Zenfolio';


    protected $table = 'online_gallery_link';

    protected $fillable = ['url'];

}
