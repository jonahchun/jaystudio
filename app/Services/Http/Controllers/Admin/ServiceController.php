<?php
namespace App\Services\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\Model\Source\Type as ServiceType;
use App\Services\Model\Source\Status;
use Alert;

class ServiceController extends \WFN\Admin\Http\Controllers\Crud\Controller
{

    protected $oldStatus;

    protected function _init(Request $request)
    {
        $this->gridBlock   = new \App\Services\Block\Admin\Service\Grid($request);
        $this->formBlock   = new \App\Services\Block\Admin\Service\Form();
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

}
