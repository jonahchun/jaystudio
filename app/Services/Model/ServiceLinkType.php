<?php
namespace App\Services\Model;

use App\Services\Model\Source\Type;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Services\Model\Service\Link;
use App\Services\Model\Service\OnlineGallery;
use App\Services\Model\Service\EngagementSessionDetail;

class ServiceLinkType extends Model
{

    protected $table = 'service_link_type';

    protected $fillable = ['name', 'active'];


}
