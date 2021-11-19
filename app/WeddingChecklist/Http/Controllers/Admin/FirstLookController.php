<?php
namespace App\WeddingChecklist\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FirstLookController extends PreparationController
{

    protected $_entity = 'FirstLook';

    protected function _init(Request $request)
    {
        parent::_init($request);

        $this->adminRoute  = 'admin.wedding.checklist.first-look';

        return $this;
    }

}
