<?php
namespace App\Services\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\Model\Source\Type as ServiceType;
use App\Services\Model\Source\Status;
use Alert;
use App\Services\Model\Service\Link;
use App\Services\Model\Service\OnlineGallery;
use App\Services\Model\Service\Image;

class ServiceController extends \WFN\Admin\Http\Controllers\Crud\Controller
{

    protected $oldStatus;

    protected function _init(Request $request)
    {
        $this->gridBlock   = new \App\Services\Block\Admin\Service\Grid($request);
        $this->formBlock   = new \App\Services\Block\Admin\Service\Form();
        $this->formMultiBlock   = new \App\Services\Block\Admin\Service\multiForm();
        $this->entity      = new \App\Services\Model\Service();
        $this->entityTitle = 'Services';
        $this->adminRoute  = 'admin.customer.service';
        return $this;
    }

    protected function validator(array $data)
    {
        $this->oldStatus = $this->entity->status;
        return Validator::make($data, $this->_getValidationRules($data));
    }

    protected function _getValidationRules($data)
    {
        $types = ServiceType::getInstance()->getOptions();
        $rules = [];
        if(empty($data['id'])) {
            $rules['type'] = 'required|in:' . implode(',', array_keys($types));
        }
        return $rules;
    }

    public function create(\Customer $customer)
    {
        $this->entity->customer_id = $customer->id;
        return $this->formBlock->setInstance($this->entity)->render();
    }
    
    public function delete($id)
    {
        $customerId = $this->entity->findOrFail($id)->customer->id;
        parent::delete($id);
        return redirect()->route('admin.customer.edit', ['id' => $customerId]);
    }

    public function hold(Request $request)
    {
        try {
            $service = $this->entity->findOrFail($request->input('id'));
            $service->update(['status' => Status::ON_HOLD]);
            $service->addStatusHistoryComment($request->input('reason'));
            Alert::addSuccess('Service has been putted on hold');
        } catch (\Exception $e) {
            Alert::addError('Something went wrong. Please, try again later');
            return redirect()->route('admin.customer.service');
        }
        return redirect()->route('admin.customer.service.edit', ['id' => $service->id]);
    }

    public function unhold($id)
    {
        try {
            $service = $this->entity->findOrFail($id);
            $status = optional($service->status_history()->where('status', '!=', Status::ON_HOLD)->first())->status;
            $service->update(['status' => $status ?: Status::PROCESSING]);
            $service->addStatusHistoryComment();
        } catch (\Exception $e) {
            Alert::addError('Something went wrong. Please, try again later');
            return redirect()->route('admin.customer.service');
        }
        return redirect()->route('admin.customer.service.edit', ['id' => $service->id]);
    }

    public function startDraft($id)
    {
        return $this->_checkAndUpdateStatus($id, Status::DRAFT_PROTOTYPING);
    }

    public function process($id)
    {
        return $this->_checkAndUpdateStatus($id, Status::PROCESSING);
    }

    public function print(\App\Services\Model\Service $service)
    {
        $customer = $service->customer;
        return view('admin.service.print.' . $service->type, compact('service', 'customer'));
    }

    public function sendTeaserEmail($id, Request $request)
    {
        try {
            $service = $this->entity->findOrFail($id);
            $customer = $service->customer;
            \MandrillMail::send('photography-teasers', $customer->email, [
                'first_newlywed_name'  => $customer->first_newlywed->first_name,
                'second_newlywed_name' => $customer->second_newlywed->first_name,
                'download_link'        => $request->input('teaser.download_link'),
                'service_detail_link'  => url(route('service.view', ['service' => $service])),
            ], \Settings::getConfigValue('email/photography-teasers_email_recipients'));

            Alert::addSuccess('Teaser email has been sent');
        } catch (\Exception $e) {
            Alert::addError('Something went wrong. Please, try again later');
        }
        return redirect()->route('admin.customer.service.edit', ['id' => $service->id]);
    }

    public function sendEngagementSessionEmail($id, Request $request)
    {
        try {
            $service = $this->entity->findOrFail($id);
            $customer = $service->customer;
            $stdService = $customer->services()->where('type', ServiceType::STDC)->first();

            \MandrillMail::send('engagement-session-done', $customer->email, [
                'first_newlywed_name'  => $customer->first_newlywed->first_name,
                'second_newlywed_name' => $customer->second_newlywed->first_name,
                'access_code'          => $request->input('engagement_session.access_code'),
                'password'             => $request->input('engagement_session.password'),
                'save_the_date_link'   => $stdService ? url(route('service.view', ['service' => $stdService])) : '',
                'service_detail_link'  => url(route('service.view', ['service' => $service])),
            ], \Settings::getConfigValue('email/engagement-session-done_email_recipients'));

            Alert::addSuccess('Engagement Session Gallery Email has been sent');
        } catch (\Exception $e) {
            Alert::addError('Something went wrong. Please, try again later');
        }
        return redirect()->route('admin.customer.service.edit', ['id' => $service->id]);
    }

    public function complete($id, Request $request)
    {
        try {
            $data = $request->input('complete');
            $this->entity = $this->entity->findOrFail($id);
            $this->entity->fill($data)->save();
            $this->entity->detail->fill($data)->save();
            $this->_checkAndProcessPhotoVideoUploads(optional($data)['upload']);
            return $this->_checkAndUpdateStatus($id, Status::COMPLETE, optional($data)['comment']);
        } catch (\Exception $e) {
            Alert::addError('Something went wrong. Please, try again later');
            return redirect()->route('admin.customer.service');
        }
    }

    protected function _checkAndUpdateStatus($id, $status, $comment = '')
    {
        try {
            $service = $this->entity->findOrFail($id);
            $service->update(['status' => $status]);
            $service->addStatusHistoryComment($comment);
            Alert::addSuccess('Status has been updated successfully');
        } catch (\Exception $e) {
            Alert::addError('Something went wrong. Please, try again later');
            return redirect()->route('admin.customer.service');
        }
        return redirect()->route('admin.customer.service.edit', ['id' => $service->id]);
    }

    protected function _prepareData($data)
    {
        if(empty($data['id'])) {
            switch($data['type']) {
                case ServiceType::PHOTO:
                case ServiceType::VIDEO:
                    $data['status'] = Status::PENDING;
                    break;
                case ServiceType::TYC:
                case ServiceType::STDC:
                case ServiceType::PHOTO_ALBUM:
                    $data['status'] = Status::AWAITING_ORDER_FORM;
                    break;
            }
        }
        return parent::_prepareData($data);
    }

    protected function _afterSave(Request $request)
    {
        if($this->entity->detail) {
            $this->entity->detail->fill($request->all())->save();
        }

        if(!$this->entity->detail && in_array($this->entity->type, [ServiceType::PHOTO, ServiceType::VIDEO])) {
            $this->entity->detail()->create($request->all());
        }

        if($this->oldStatus != $this->entity->status) {
            $this->entity->addStatusHistoryComment();
        }
       
        return $this;
    }

    protected function _checkAndProcessPhotoVideoUploads($uploadLink)
    {
        if(!in_array($this->entity->type, [ServiceType::PHOTO, ServiceType::VIDEO])) {
            return $this;
        }
        
        if(!$uploadLink) {
            return $this;
        }

        $this->entity->uploads()->create([
            'file'   => $uploadLink,
            'status' => \App\Services\Model\Source\Upload\Status::COMPLETED
        ]);
    }

    public function serviceIndex(Request $request)
    {
        return null;
    }
    public function serviceCreate(\Customer $customer, Request $request){

        $this->entity->customer_id = $customer->id;
        return $this->formMultiBlock->setInstance($this->entity)->render();
        // dd($customer);
    }

    public function serviceSave(Request $request){
        try {
            $all_data = $request->all();
            $service_data = $this->entity->where('customer_id',$all_data['customer_id'])->get();

            $old_type_arr = [];

            foreach ($service_data as $key => $value) {
                $old_type_arr[] = $value['type'];
            }

            $new_type_arr = $all_data['type'];

            $delete_arr = array_diff($old_type_arr,$new_type_arr);
            foreach ($delete_arr as $key => $value) {
                $this->entity->where('customer_id',$all_data['customer_id'])->where('type',$value)->delete();
            }

            $new_arr_type = array_diff($new_type_arr,$old_type_arr);
            if(!empty($new_arr_type)){
                foreach ($new_arr_type as $t_key => $t_value) {
                    $this->arr[$t_key] = $all_data;
                    $this->arr[$t_key]['type'] = $t_value; 
                }

                foreach ($this->arr as $key => $value) {
                    if($value['id']) {
                        $this->entity = $this->entity->findOrFail($value['id']);
                    }else{
                        $this->entity = new \App\Services\Model\Service();      
                    }

                    $this->validator($value)->validate();

                    $data = $this->_prepareData($value);
                    // dd($data);
                    $this->entity->fill($data)->save();
                }
                
            }

            Alert::addSuccess($this->entityTitle . ' has been saved');

        } catch (ValidationException $e) {
            foreach($e->errors() as $messages) {
                foreach ($messages as $message) {
                    Alert::addError($message);
                }
            }
        } catch (\Exception $e) {
            Alert::addError('Something went wrong. Please, try again');
        }

        return redirect()->route('admin.customer.edit', ['id' => $request->customer_id]);

    }

    public function save(Request $request)
    {
        try {
            if($request->input('id')) {
                $this->entity = $this->entity->findOrFail($request->input('id'));

                Link::whereIn('service_id', [$request->input('id')])->delete();
                if(!empty($request->input('links'))){
                    foreach($request->input('links') as $link_data){
                        $link = new Link();

                        $link->service_id = $request->input('id');
                        $link->customer_id = $request->input('customer_id');
                        $link->type = $link_data['type'];
                        $link->link = $link_data['link'];
                        
                        $link->save();
                    }
                }
                OnlineGallery::whereIn('service_id', [$request->input('id')])->delete();
                if(!empty($request->input('online_gallery'))){
                    foreach($request->input('online_gallery') as $gallery_data){
                        $gallery = new OnlineGallery();

                        $gallery->service_id = $request->input('id');
                        $gallery->customer_id = $request->input('customer_id');
                        $gallery->gallery_name = $gallery_data['gallery_name'];
                        $gallery->access_code = $gallery_data['access_code'];
                        $gallery->password = $gallery_data['password'];
                        
                        $gallery->save();
                    }
                }
            }

            $this->validator($request->all())->validate();

            $data = $this->_prepareData($request->all());
            // dd($data);
            $this->entity->fill($data)->save();

            $this->_afterSave($request);

            Alert::addSuccess($this->entityTitle . ' has been saved');

        } catch (ValidationException $e) {
            foreach($e->errors() as $messages) {
                foreach ($messages as $message) {
                    Alert::addError($message);
                }
            }
        } catch (\Exception $e) {
            dd($e);
            Alert::addError('Something went wrong. Please, try again');
        }
        return !$this->entity->id ? redirect()->route($this->adminRoute . '.new') : redirect()->route($this->adminRoute . '.edit', ['id' => $this->entity->id]);
    }

    public function teaserPhotoDelete(Request $request){
        $data = $request->all();
        
        $count_img = Image::find($data['id']);

        if(!empty($count_img)){
            Image::find($data['id'])->delete();
        }

        return response()->json(['succes'=>true]);
    }

    public function edit($id = false)
    {
        $this->entity = $this->entity->with('teaser_photos')->findOrFail($id);
        
        return $this->formBlock->setInstance($this->entity)->render();
    }
}
