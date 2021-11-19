<?php
namespace App\Services\Http\Controllers\Admin\Service;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\Model\Service\EditRequest;
use App\Services\Model\Source\EditRequest\Status;
use App\Services\Model\Source\Status as ServiceStatus;
use App\Services\Model\Source\Type as ServiceType;

class EditRequestsController extends \WFN\Admin\Http\Controllers\Crud\Controller
{

    protected function _init(Request $request)
    {
        $this->gridBlock   = new \App\Services\Block\Admin\Service\EditRequests\Grid($request);
        $this->formBlock   = new \App\Services\Block\Admin\Service\EditRequests\Form();
        $this->entity      = new EditRequest();
        $this->entityTitle = 'Edit Requests';
        $this->adminRoute  = 'admin.customer.service.edit_request';
        return $this;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, []);
    }

    public function startWork(EditRequest $edit_request)
    {
        $edit_request->update(['status' => Status::PROCESSING]);
        
        if(in_array($edit_request->service->type, [ServiceType::PHOTO, ServiceType::VIDEO])) {
            $status = ServiceStatus::EDITING;
        } else {
            $status = ServiceStatus::DRAFT_EDITS_PROCESSING;
        }
        
        $edit_request->service->update(['status' => $status]);
        $edit_request->service->addStatusHistoryComment();
        return redirect()->route($this->adminRoute . '.edit', ['id' => $edit_request->id]);
    }

    public function print(EditRequest $edit_request)
    {
        $customer = $edit_request->service->customer;
        return view('admin.service.print.edit_request', compact('edit_request', 'customer'));
    }

    public function save(Request $request)
    {
        return abort(404);
    }

}
