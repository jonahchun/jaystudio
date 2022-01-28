<?php
namespace App\Services\Model\Service;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Link extends Model
{

    protected $table = 'service_links';

    protected $fillable = ['service_id', 'link', 'type'];
}

?>