<?php
namespace App\Customer\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends \WFN\Admin\Http\Controllers\Crud\Controller
{

    protected function _init(Request $request)
    {
        $this->gridBlock   = new \App\Customer\Block\Admin\Contact\Grid($request);
        $this->formBlock   = new \App\Customer\Block\Admin\Contact\Form();
        $this->entity      = new \App\Customer\Model\Contact();
        $this->entityTitle = 'Customer Contact';
        $this->adminRoute  = 'admin.customer.contact';
        return $this;
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'customer_id' => 'required|exists:customer,id',
            'first_name'  => 'required|string|max:255',
            'last_name'   => 'required|string|max:255',
            'role_id'     => 'required|exists:customer_contact_roles,id',
            'email'       => 'required|string|email|max:255',
            'telephone'   => 'required|string|max:255',
        ]);
    }

}
