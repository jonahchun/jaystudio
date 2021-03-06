<?php

namespace App\Services\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Model\Service;
use Alert;
use App\Services\Model\Service\EditRequest;
use App\Services\Model\Service\Upload;
use App\Services\Model\Source\Type as ServiceType;
use App\Services\Model\Source\Status as ServiceStatus;
use App\Services\Model\Source\Upload\Status as UploadStatus;

class ServiceController extends \WFN\Customer\Http\Controllers\Controller
{

    public function __construct()
    {
        $this->middleware(\App\Services\Http\Middleware\ServiceAvailability::class);
        return parent::__construct();
    }

    public function view(Service $service)
    {
        if(!$service->detail) {
            return redirect()->route('service.order-form.new', ['service' => $service]);
        }

        return view('service.view.' . $service->type, compact('service'));
    }

    public function orderFormNew(Service $service)
    {
        if(in_array($service->type, [ServiceType::PHOTO, ServiceType::VIDEO])) {
            return abort(404);
        }

        return view('service.order-form.form.' . $service->type, compact('service'));
    }

    public function orderFormView(Service $service)
    {
        if(in_array($service->type, [ServiceType::PHOTO, ServiceType::VIDEO])) {
            return abort(404);
        }

        if(!$service->detail) {
            return redirect()->route('service.order-form.new', ['service' => $service]);
        }
        
        return view('service.order-form.view.' . $service->type, compact('service'));
    }

    public function orderFormSave(Service $service, Request $request)
    {
        try {
            $data = $request->all();

            if(!$service->detail) {
                $service->detail()->create($data);
            } else {
                $service->detail->fill($data)->save();
            }
            
            $service->setAttribute('status', ServiceStatus::ORDER_FORM_SUBMITTED)->save();
            $service->addStatusHistoryComment();
        } catch (\Exception $e) {
            Alert::addError('Something went wrong. Please try again later');
            return redirect()->route('service.order-form.view', ['service' => $service]);
        }
        return redirect()->route('service.view', ['service' => $service]);
    }

    public function updateOrderForm(Service $service, Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        foreach($data as $key => $value) {
            $_value = $service->detail->getAttribute($key);
            if(is_array($_value)) {
                foreach($value as $_key => $_val) {
                    $_value[$_key] = $_val;
                }
            } else {
                $_value = $value;
            }
            $service->detail->setAttribute($key, $_value);
        }
        $service->detail->save();

        return $service->detail;
    }

    public function editRequestNew(Service $service)
    {
        return view('service.edit-request.form.' . $service->type, compact('service'));
    }

    public function editRequestView(EditRequest $edit_request, Service $service)
    {
        return view('service.edit-request.view.' . $service->type, compact('edit_request'));
    }

    public function editRequestSave(Service $service, Request $request)
    {
        try {
            $editRequest = $service->edit_requests()->create($request->all());
            $service->uploads()->where('status', UploadStatus::PENDING_APPROVAL)
                ->update(['status' => UploadStatus::REJECTED]);

            $status = ServiceStatus::EDIT_REQUEST_SUBMITTED;
            $service->uploads()->update(['status' => UploadStatus::REJECTED]);

            $service->update(['status' => $status]);
            $service->addStatusHistoryComment();
        } catch (\Exception $e) {
            // Alert::addError('Something went wrong. Please try again later');
        }
        return redirect()->route('service.view', ['service' => $service->id]);
    }

    public function approveUpload(Upload $upload, Service $service)
    {
        $upload->update(['status' => \App\Services\Model\Source\Upload\Status::APPROVED]);
        if(!in_array($service->type, [ServiceType::PHOTO, ServiceType::VIDEO])) {
            $service->update(['status' => ServiceStatus::DRAFT_EDITS_APPROVED]);
            $service->addStatusHistoryComment();
        }
        return redirect()->route('service.view', ['service' => $upload->service->id]);
    }

}
