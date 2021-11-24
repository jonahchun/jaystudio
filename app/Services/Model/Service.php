<?php
namespace App\Services\Model;

use App\Services\Model\Source\Type;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    protected $table = 'services';

    protected $fillable = ['customer_id', 'type' , 'status', 'pickup_location_id', 'tracking_link'];

    public function getAttribute($key)
    {
        if($key != 'detail'){
            // dd($key);
            $value = parent::getAttribute($key);
            if($key == 'type') {
                $values = [
                    'videography',
                    'thank_you_card'
                ];

                return $values;
            }else{
                if(!$value) {
                    $value = !empty($this->type) && !empty($this->detail) ? $this->detail->$key : null;
                }
                return $value;
            }
        }
        // $value = parent::getAttribute($key);
        // if(!$value) {
        //     $value = !empty($this->type) && !empty($this->detail) ? $this->detail->$key : null;
        // }
        // return $value;
    }

    public function getAttributeUrl($key)
    {
        return optional($this->detail)->getAttributeUrl($key);
    }

    public function customer()
    {
        return $this->belongsTo(\Customer::class);
    }

    public function pickup_location()
    {
        return $this->belongsTo(\App\Core\Model\PickupLocation::class);
    }

    public function status_history()
    {
        return $this->hasMany(Service\StatusHistory::class)->orderBy('created_at', 'desc');
    }

    public function uploads()
    {
        return $this->hasMany(Service\Upload::class);
    }

    public function edit_requests()
    {
        return $this->hasMany(Service\EditRequest::class);
    }

    public function addStatusHistoryComment($comment = '')
    {
        $this->status_history()->create([
            'status'  => $this->status,
            'comment' => $comment
        ]);
        return $this;
    }

    public function detail()
    {
        if(!$this->type) {
            return false;
        }
        $relation = '_' . $this->type . '_detail';
        return $this->$relation();
    }

    public function canCreateEditRequest()
    {
        if(in_array($this->type, [Type::PHOTO, Type::VIDEO]) && $this->customer->wedding_date->gt(Carbon::now())) {
            return false;
        }
        $lastUpload = $this->uploads()->orderBy('created_at', 'desc')->first();
        return $this->status != Source\Status::PROCESSING &&
            !$this->edit_requests()
            ->where('status', '!=', \App\Services\Model\Source\EditRequest\Status::COMPLETE)
            ->count();
    }

    protected function _photography_detail()
    {
        return $this->hasOne(Service\PhotoDetail::class);
    }

    protected function _videography_detail()
    {
        return $this->hasOne(Service\VideoDetail::class);
    }

    protected function _thank_you_card_detail()
    {
        return $this->hasOne(Service\TycDetail::class);
    }

    protected function _save_the_date_card_detail()
    {
        return $this->hasOne(Service\StdcDetail::class);
    }

    protected function _photo_album_detail()
    {
        return $this->hasOne(Service\PhotoAlbumDetail::class);
    }

}