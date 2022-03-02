<?php

namespace App\Customer\Model;

use App\Customer\Model\Newlywed;
use App\Customer\Model\Address;
use App\Customer\Model\Contact;
use App\Customer\Model\Newlywed\Detail as NewlywedDetail;
use App\Customer\Model\Wedding\Checklist as WeddingChecklist;
use App\Customer\Model\Wedding\Schedule as WeddingSchedule;
use App\Customer\Model\Source\NewlywedType;
use App\Customer\Model\Source\AddressType;
use App\Payments\Model\Invoice;
use Illuminate\Support\Carbon;
use App\Core\Model\Traits\HasUploads;
use Storage;
use App\Services\Model\Service\Link;
use App\Services\Model\Service\Image;

class Customer extends \WFN\Customer\Model\Customer
{
    use HasUploads;
    
    const MEDIA_PATH = 'insurance_certificate' . DIRECTORY_SEPARATOR;

    protected $fillable = [
        'id', 'email', 'password', 'api_token', 'account_id','is_disable_update','insurance_certificate_file'
    ];
    protected $mediaFields = ['insurance_certificate_file'];
    public static function getAvailableRelations()
    {
        $relations = parent::getAvailableRelations();

        $relations['first_newlywed'] = Newlywed::class;
        $relations['second_newlywed'] = Newlywed::class;
        $relations['billing_address'] = Address::class;
        $relations['newlywed_detail'] = NewlywedDetail::class;
        $relations['wedding_checklist'] = WeddingChecklist::class;
        $relations['wedding_schedule'] = WeddingSchedule::class;

        return $relations;
    }
    public function getAttributeUrl($key)
    {
        $value = $this->getAttribute($key);
        if($key == "contract"){
            return $value ? Storage::url('customer/'. $value) : false;
        }else{
            return $value ? Storage::url(static::MEDIA_PATH . $value) : false;
        }
    }

    public function getNewlywedNamesAttribute()
    {
        return $this->first_newlywed->first_name . ' ' . $this->first_newlywed->last_name . ' / '
            . $this->second_newlywed->first_name . ' ' . $this->second_newlywed->last_name;
    }

    public function services()
    {
        return $this->hasMany(\App\Services\Model\Service::class);
    }

    public function first_newlywed()
    {
        return $this->hasOne(Newlywed::class)->where('type', NewlywedType::FIRST);
    }

    public function second_newlywed()
    {
        return $this->hasOne(Newlywed::class)->where('type', NewlywedType::SECOND);
    }

    public function billing_address()
    {
        return $this->hasOne(Address::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class)->orderBy('due_date', 'desc');
    }

    public function upcoming_invoices()
    {
        return $this->invoices()->where('due_date', '<', Carbon::now()->addMonth());
    }

    public function newlywed_detail()
    {
        return $this->hasOne(NewlywedDetail::class);
    }

    public function wedding_checklist()
    {
        return $this->hasOne(WeddingChecklist::class);
    }

    public function wedding_schedule()
    {
        return $this->hasOne(WeddingSchedule::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'customer_id');
    }

    public function links()
    {
        return $this->hasMany(Link::class, 'customer_id');
    }

    public function teaser_photos()
    {
        return $this->hasMany(Image::class, 'customer_id');
    }

    public function getNewlywedAttribute($type, $key)
    {
        return $this->{$type . '_newlywed'}->$key;
    }

    protected function _createRelation($relation)
    {
        switch($relation) {
            case 'first_newlywed':
                return $this->first_newlywed()->create(['type' => NewlywedType::FIRST]);
            case 'second_newlywed':
                return $this->second_newlywed()->create(['type' => NewlywedType::SECOND]);
            case 'billing_address':
                return $this->billing_address()->create();
            default:
                return parent::_createRelation($relation);
        }
    }

    public function createWeddingSchedule()
    {
        if(!$this->wedding_schedule) {
            $this->wedding_schedule()->create([
                'current_step' => 0,
            ]);
            $this->load('wedding_schedule');
            $this->wedding_schedule->createRelations();
        }
        return $this;
    }

    public function sendPasswordResetNotification($token)
    {
        return \MandrillMail::send('password-reset', $this->email, [
            'first_newlywed_name'   => $this->first_newlywed->first_name,
            'second_newlywed_name'  => $this->second_newlywed->first_name,
            'reset_password_link'   => url(route('password.reset', $token, false)),
        ], \Settings::getConfigValue('email/password-reset_email_recipients'));
    }

}