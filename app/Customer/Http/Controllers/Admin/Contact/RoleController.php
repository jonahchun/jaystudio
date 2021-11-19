<?php
namespace App\Customer\Http\Controllers\Admin\Contact;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends \WFN\Admin\Http\Controllers\Crud\Controller
{

    protected function _init(Request $request)
    {
        $this->gridBlock   = new \App\Customer\Block\Admin\Contact\Role\Grid($request);
        $this->formBlock   = new \App\Customer\Block\Admin\Contact\Role\Form();
        $this->entity      = new \App\Customer\Model\Contact\Role();
        $this->entityTitle = 'Customer Contact Role';
        $this->adminRoute  = 'admin.customer.contact.role';
        return $this;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title' => 'required|string|max:255',
        ]);
    }
}
