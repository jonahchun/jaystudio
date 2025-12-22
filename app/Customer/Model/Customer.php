<?php

namespace App\Customer\Model;

use App\Core\Model\OnlineGalleryLink;
use App\Customer\Model\Newlywed;
use App\Customer\Model\Address;
use App\Customer\Model\Contact;
use App\Customer\Model\Newlywed\Detail as NewlywedDetail;
use App\Customer\Model\Wedding\Checklist as WeddingChecklist;
use App\Customer\Model\Wedding\Schedule as WeddingSchedule;
use App\Customer\Model\Source\NewlywedType;
use App\Customer\Model\Source\AddressType;
use App\Payments\Model\Invoice;
use App\Payments\Model\Source\Status;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use App\Core\Model\Traits\HasUploads;
use App\Notification\Model\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Services\Model\Service\Link;
use App\Services\Model\Service\Image;
use App\Services\Model\Service\OnlineGallery;

class Customer extends \WFN\Customer\Model\Customer
{
    use HasUploads;
    use SoftDeletes;

    const MEDIA_PATH = 'insurance_certificate' . DIRECTORY_SEPARATOR;

    protected $fillable = [
        'id', 'email', 'password', 'api_token', 'account_id','is_disable_update','insurance_certificate_file', 'online_gallery_link_id'
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
        if (!isset($this->first_newlywed->first_name)){
            return '-';
        }
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
        return $this->hasMany(Invoice::class)->orderBy('due_date', 'asc');
    }

    public function upcoming_invoices()
    {
        return $this->invoices()->whereIn('status', [Status::DUE, Status::OVERDUE]);
    }

    public function newlywed_detail()
    {
        return $this->hasOne(NewlywedDetail::class);
    }

    public function wedding_checklist()
    {
        return $this->hasOne(WeddingChecklist::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
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
    public function online_gallery()
    {
        return $this->hasMany(OnlineGallery::class, 'customer_id');
    }

    public function onlineGalleryLink()
    {
        return $this->hasOne(OnlineGalleryLink::class, 'id','online_gallery_link_id');
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
            case 'newlywed_detail':
                return $this->newlywed_detail()->create(['initially_complete' => 0]);
            case 'wedding_schedule':
                return $this->wedding_schedule()->create(['initially_complete' => 0]);
            case 'wedding_checklist':
                return $this->wedding_checklist()->create(['initially_complete' => 0]);
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

    protected static function boot()
    {
        parent::boot();

        \Log::info('Customer boot method executed');


        static::deleting(function($customer) {
            if (isset($customer->mediaFields) && is_array($customer->mediaFields)) {
                foreach ($customer->mediaFields as $field) {
                    if (!empty($customer->$field)) {
                        Storage::delete(static::MEDIA_PATH . $customer->$field);
                    }
                }
            }

            if (method_exists($customer, 'services') && $customer->services()->exists()) {
                foreach ($customer->services as $service) {
                    if ($service->detail) {
                        $detail = $service->detail;

                        if ($detail instanceof \App\Services\Model\Service\EngagementSessionDetail) {
                            if (!empty($detail->upload)) {
                                Storage::delete($detail::MEDIA_PATH . $detail->upload);
                            }
                        } elseif ($detail instanceof \App\Services\Model\Service\PhotoDetail) {
                            if (!empty($detail->upload)) {
                                Storage::delete($detail::MEDIA_PATH . $detail->upload);
                            }
                        } elseif ($detail instanceof \App\Services\Model\Service\PhotoAlbumDetail) {
                            if (!empty($detail->file)) {
                                Storage::delete($detail::MEDIA_PATH . $detail->file);
                            }
                            if (!empty($detail->art_deco_cover_image)) {
                                Storage::delete($detail::MEDIA_PATH . $detail->art_deco_cover_image);
                            }
                            if (!empty($detail->acrylic_cover_image)) {
                                Storage::delete($detail::MEDIA_PATH . $detail->acrylic_cover_image);
                            }
                            if (!empty($detail->images) && is_array($detail->images)) {
                                foreach ($detail->images as $image) {
                                    if (!empty($image['file'])) {
                                        Storage::delete($detail::MEDIA_PATH . $image['file']);
                                    }
                                }
                            }
                        } elseif ($detail instanceof \App\Services\Model\Service\StdcDetail) {
                            if (!empty($detail->file)) {
                                Storage::delete($detail::MEDIA_PATH . $detail->file);
                            }
                            if (!empty($detail->front_side_images) && is_array($detail->front_side_images)) {
                                foreach ($detail->front_side_images as $image) {
                                    if (!empty($image['file'])) {
                                        Storage::delete($detail::MEDIA_PATH . $image['file']);
                                    }
                                }
                            }
                            if (!empty($detail->back_side_images) && is_array($detail->back_side_images)) {
                                foreach ($detail->back_side_images as $image) {
                                    if (!empty($image['file'])) {
                                        Storage::delete($detail::MEDIA_PATH . $image['file']);
                                    }
                                }
                            }
                        } elseif ($detail instanceof \App\Services\Model\Service\TycDetail) {
                            if (!empty($detail->file)) {
                                Storage::delete($detail::MEDIA_PATH . $detail->file);
                            }
                            if (!empty($detail->front_side_images) && is_array($detail->front_side_images)) {
                                foreach ($detail->front_side_images as $image) {
                                    if (!empty($image['file'])) {
                                        Storage::delete($detail::MEDIA_PATH . $image['file']);
                                    }
                                }
                            }
                            if (!empty($detail->inside_images) && is_array($detail->inside_images)) {
                                foreach ($detail->inside_images as $image) {
                                    if (!empty($image['file'])) {
                                        Storage::delete($detail::MEDIA_PATH . $image['file']);
                                    }
                                }
                            }
                            if (!empty($detail->back_side_images) && is_array($detail->back_side_images)) {
                                foreach ($detail->back_side_images as $image) {
                                    if (!empty($image['file'])) {
                                        Storage::delete($detail::MEDIA_PATH . $image['file']);
                                    }
                                }
                            }
                        } elseif ($detail instanceof \App\Services\Model\Service\VideoDetail) {
                            if (!empty($detail->upload)) {
                                Storage::delete($detail::MEDIA_PATH . $detail->upload);
                            }
                        }
                    }

                    if (method_exists($service, 'uploads')) {
                        foreach ($service->uploads as $upload) {
                            if (!empty($upload->file)) {
                                Storage::delete($upload::MEDIA_PATH . $upload->file);
                            }
                        }
                    }

                    if (method_exists($service, 'teaser_photos')) {
                        foreach ($service->teaser_photos as $teaserPhoto) {
                            if (!empty($teaserPhoto->image)) {
                                Storage::delete($teaserPhoto::MEDIA_PATH . $teaserPhoto->image);
                            }
                        }
                    }
                }

                $customer->services()->delete();
            }

            if (method_exists($customer, 'invoices')) {
                $customer->invoices()->delete();
            }

            if (method_exists($customer, 'contacts') && $customer->contacts()->exists()) {
                foreach ($customer->contacts as $contact) {
                    if (isset($contact->mediaFields) && is_array($contact->mediaFields)) {
                        foreach ($contact->mediaFields as $field) {
                            if (!empty($contact->$field)) {
                                Storage::delete($contact::MEDIA_PATH . $contact->$field);
                            }
                        }
                    }
                }
                $customer->contacts()->delete();
            }

            if (method_exists($customer, 'notifications')) {
                $customer->notifications()->delete();
            }

            if (method_exists($customer, 'first_newlywed') && $customer->first_newlywed) {
                if (isset($customer->first_newlywed->mediaFields) && is_array($customer->first_newlywed->mediaFields)) {
                    foreach ($customer->first_newlywed->mediaFields as $field) {
                        if (!empty($customer->first_newlywed->$field)) {
                            Storage::delete($customer->first_newlywed::MEDIA_PATH . $customer->first_newlywed->$field);
                        }
                    }
                }
                $customer->first_newlywed()->delete();
            }

            if (method_exists($customer, 'second_newlywed') && $customer->second_newlywed) {
                if (isset($customer->second_newlywed->mediaFields) && is_array($customer->second_newlywed->mediaFields)) {
                    foreach ($customer->second_newlywed->mediaFields as $field) {
                        if (!empty($customer->second_newlywed->$field)) {
                            Storage::delete($customer->second_newlywed::MEDIA_PATH . $customer->second_newlywed->$field);
                        }
                    }
                }
                $customer->second_newlywed()->delete();
            }

            if (method_exists($customer, 'newlywed_detail') && $customer->newlywed_detail) {
                if (isset($customer->newlywed_detail->mediaFields) && is_array($customer->newlywed_detail->mediaFields)) {
                    foreach ($customer->newlywed_detail->mediaFields as $field) {
                        if (!empty($customer->newlywed_detail->$field)) {
                            Storage::delete($customer->newlywed_detail::MEDIA_PATH . $customer->newlywed_detail->$field);
                        }
                    }
                }
                $customer->newlywed_detail()->delete();
            }

            if (method_exists($customer, 'wedding_checklist') && $customer->wedding_checklist) {
                if (isset($customer->wedding_checklist->mediaFields) && is_array($customer->wedding_checklist->mediaFields)) {
                    foreach ($customer->wedding_checklist->mediaFields as $field) {
                        if (!empty($customer->wedding_checklist->$field)) {
                            Storage::delete($customer->wedding_checklist::MEDIA_PATH . $customer->wedding_checklist->$field);
                        }
                    }
                }
                $customer->wedding_checklist()->delete();
            }

            if (method_exists($customer, 'wedding_schedule') && $customer->wedding_schedule) {
                if (isset($customer->wedding_schedule->mediaFields) && is_array($customer->wedding_schedule->mediaFields)) {
                    foreach ($customer->wedding_schedule->mediaFields as $field) {
                        if (!empty($customer->wedding_schedule->$field)) {
                            Storage::delete($customer->wedding_schedule::MEDIA_PATH . $customer->wedding_schedule->$field);
                        }
                    }
                }
                $customer->wedding_schedule()->delete();
            }

            if (method_exists($customer, 'billing_address') && $customer->billing_address) {
                if (isset($customer->billing_address->mediaFields) && is_array($customer->billing_address->mediaFields)) {
                    foreach ($customer->billing_address->mediaFields as $field) {
                        if (!empty($customer->billing_address->$field)) {
                            Storage::delete($customer->billing_address::MEDIA_PATH . $customer->billing_address->$field);
                        }
                    }
                }
                $customer->billing_address()->delete();
            }

            if (method_exists($customer, 'links')) {
                $customer->links()->delete();
            }

            if (method_exists($customer, 'online_gallery')) {
                $customer->online_gallery()->delete();
            }

            if (method_exists($customer, 'teaser_photos') && $customer->teaser_photos()->exists()) {
                foreach ($customer->teaser_photos as $teaserPhoto) {
                    if (!empty($teaserPhoto->image)) {
                        Storage::delete($teaserPhoto::MEDIA_PATH . $teaserPhoto->image);
                    }
                }
                $customer->teaser_photos()->delete();
            }

            if (method_exists($customer, 'onlineGalleryLink')) {
                $customer->onlineGalleryLink()->delete();
            }
        });

        static::restoring(function($customer) {
            \Log::info('Customer restoring started', [
                'id' => $customer->id,
                'deleted_at' => $customer->deleted_at
            ]);

            try {
                if (method_exists($customer, 'services')) {
                    \Log::info('Restoring services', ['id' => $customer->id]);
                    $customer->services()->restore();
                }
                if (method_exists($customer, 'invoices')) {
                    \Log::info('Restoring invoices', ['id' => $customer->id]);
                    $customer->invoices()->restore();
                }
                if (method_exists($customer, 'contacts')) {
                    \Log::info('Restoring contacts', ['id' => $customer->id]);
                    $customer->contacts()->restore();
                }
                if (method_exists($customer, 'notifications')) {
                    \Log::info('Restoring notifications', ['id' => $customer->id]);
                    $customer->notifications()->restore();
                }
                if (method_exists($customer, 'first_newlywed')) {
                    \Log::info('Restoring first_newlywed', ['id' => $customer->id]);
                    $customer->first_newlywed()->restore();
                }
                if (method_exists($customer, 'second_newlywed')) {
                    \Log::info('Restoring second_newlywed', ['id' => $customer->id]);
                    $customer->second_newlywed()->restore();
                }
                if (method_exists($customer, 'newlywed_detail')) {
                    \Log::info('Restoring newlywed_detail', ['id' => $customer->id]);
                    $customer->newlywed_detail()->restore();
                }
                if (method_exists($customer, 'wedding_checklist')) {
                    \Log::info('Restoring wedding_checklist', ['id' => $customer->id]);
                    $customer->wedding_checklist()->restore();
                }
                if (method_exists($customer, 'wedding_schedule')) {
                    \Log::info('Restoring wedding_schedule', ['id' => $customer->id]);
                    $customer->wedding_schedule()->restore();
                }
                if (method_exists($customer, 'billing_address')) {
                    \Log::info('Restoring billing_address', ['id' => $customer->id]);
                    $customer->billing_address()->restore();
                }
                if (method_exists($customer, 'links')) {
                    \Log::info('Restoring links', ['id' => $customer->id]);
                    $customer->links()->restore();
                }
                if (method_exists($customer, 'online_gallery')) {
                    \Log::info('Restoring online_gallery', ['id' => $customer->id]);
                    $customer->online_gallery()->restore();
                }
                if (method_exists($customer, 'teaser_photos')) {
                    \Log::info('Restoring teaser_photos', ['id' => $customer->id]);
                    $customer->teaser_photos()->restore();
                }
                if (method_exists($customer, 'onlineGalleryLink')) {
                    \Log::info('Restoring onlineGalleryLink', ['id' => $customer->id]);
                    $customer->onlineGalleryLink()->restore();
                }

                \Log::info('Customer restoring completed', ['id' => $customer->id]);

            } catch (\Exception $e) {
                \Log::error('Customer restoring error', [
                    'id' => $customer->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                throw $e;
            }
        });
    }

    public function rr()
    {
        \Log::info('=== CUSTOM RESTORE START ===', ['id' => $this->id]);

        $result = DB::table($this->getTable())
            ->where('id', $this->id)
            ->update(['deleted_at' => null]);

        \Log::info('SQL update result', ['affected_rows' => $result]);

        $this->deleted_at = null;
        $this->exists = true;

        $this->services()->restore();
        $this->invoices()->restore();
        $this->contacts()->restore();
        $this->notifications()->restore();
        $this->first_newlywed()->restore();
        $this->second_newlywed()->restore();
        $this->newlywed_detail()->restore();
        $this->wedding_checklist()->restore();
        $this->wedding_schedule()->restore();
        $this->billing_address()->restore();
        $this->links()->restore();
        $this->online_gallery()->restore();
        $this->teaser_photos()->restore();
        $this->onlineGalleryLink()->restore();

        return (bool) $result;
    }

}
