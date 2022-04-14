<?php
namespace App\Services\Http\Controllers\Admin\Service;

use Illuminate\Http\Request;
use App\Services\Model\Service;
use Illuminate\Support\Facades\Validator;
use App\Services\Model\Source\Status as ServiceStatus;
use App\Services\Model\Source\Type as ServiceType;
use App\Services\Model\Source\EditRequest\Status as EditRequestStatus;
use Illuminate\Validation\ValidationException;
use Alert;

class UploadsController extends \WFN\Admin\Http\Controllers\Crud\Controller
{

    protected function _init(Request $request)
    {
        $this->gridBlock   = new \App\Services\Block\Admin\Service\Uploads\Grid($request);
        $this->formBlock   = new \App\Services\Block\Admin\Service\Uploads\Form();
        $this->entity      = new \App\Services\Model\Service\Upload();
        $this->entityTitle = 'Uploads';
        $this->adminRoute  = 'admin.customer.service.uploads';
        return $this;
    }

    public function create(Service $service)
    {
        $this->entity->service_id = $service->id;
        return $this->formBlock->setInstance($this->entity)->render();
    }

    protected function _afterSave(Request $request)
    {
        if(in_array($this->entity->service->type, [ServiceType::PHOTO, ServiceType::VIDEO])) {
            $status = ServiceStatus::EDITS_COMPLETE;
        } else {
            $status = ServiceStatus::PENDING_DRAFT_APPROVAL;
        }
        $this->entity->service->update(['status' => $status]);
        $this->entity->service->edit_requests()
            ->where('status', '!=', EditRequestStatus::COMPLETE)
            ->update(['status' => EditRequestStatus::COMPLETE]);
        $this->entity->service->addStatusHistoryComment($this->entity->comment);
        return $this;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, []);
    }

    public function delete($upload){
        try {
            $this->entity = $this->entity->findOrFail($upload);
            
            $this->_beforeDelete();
            $this->entity->delete();
            
            Alert::addSuccess($this->entityTitle . ' has been deleted');
        } catch (\Exception $e) {
            Alert::addError('Something went wrong. Please, try again');
        }
        return redirect()->route('admin.customer.service.edit',$this->entity->service_id);
    }
}
