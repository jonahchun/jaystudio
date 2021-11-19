<?php
namespace App\WeddingChecklist\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;

class VendorsController extends PreparationController
{

    protected $_entity = 'Vendor';

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title'      => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);
    }
}
