<?php

namespace App\Services\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Model\Service;
use Alert,Auth;
use App\Services\Model\Service\EditRequest;
use App\Services\Model\Service\Upload;
use App\Services\Model\Source\Type as ServiceType;
use App\Services\Model\Source\Status as ServiceStatus;
use App\Services\Model\Source\Gallery;
use App\Services\Model\Source\EngagementSessionGallery;
use App\Services\Model\Source\Upload\Status as UploadStatus;
use App\Services\Model\Service\Link;
use App\Core\Model\OnlineGalleryLink;
use App\Services\Model\Service\OnlineGallery;
use App\Services\Model\Service\Image;

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

        // LINKS
        $old_links = Link::with('services')->where('service_id',$service->id)->get()->toArray();
        
        $links = [];

        foreach ($old_links as $link_key => $link_value) {
            if($link_value['services']['status'] == ServiceStatus::COMPLETE){
                $links[] = $link_value; 
            }
        }
        
        // Online Gallery Detail
        $link_count = OnlineGalleryLink::count();

        $online_gallery_link = '';
        
        if($link_count > 0){
            $gallery_links = OnlineGalleryLink::first();
            $online_gallery_link = $gallery_links->url; 
        }
        
        $online_gallery_data = OnlineGallery::with('services')->where('service_id',$service->id)->get()->toArray();

        $online_gallery = [];

        foreach ($online_gallery_data as $link_key => $link_value) {
            if($link_value['services']['status'] == ServiceStatus::COMPLETE){
                if($link_value['services']['type'] == ServiceType::PHOTO){
                    $config_file = new Gallery;
                }else{
                    $config_file = new EngagementSessionGallery;
                }

                $online_gallery[$link_key] = $link_value; 
                $online_gallery[$link_key]['gallery_name'] = $config_file->getOptionLabel($link_value['gallery_name']); 
            }
        }
        $photos_data = Auth::user()->teaser_photos()->with('services')->take(4)->get()->toArray();
        
        $photos = [];

        foreach ($photos_data as $photo_key => $photo_value) {
            if($photo_value['services']['status'] == ServiceStatus::PROCESSING){
                $photos[] = $photo_value; 
            }
        }
        return view('service.view.' . $service->type, compact('service','links','online_gallery_link','online_gallery','photos'));
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
