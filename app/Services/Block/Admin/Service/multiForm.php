<?php
namespace App\Services\Block\Admin\Service;

use App\Services\Model\Source\Status;
use App\Services\Model\Source\Type;
use App\Services\Model\Service;

class multiForm extends \WFN\Admin\Block\Widget\AbstractForm
{

    protected $adminRoute = 'admin.customer.multi-service';

    protected function _beforeRender()
    {
    	$customer_id = $this->instance->customer->id;

    	$selected_type = Service::select('type')->where('customer_id',$customer_id)->get()->toArray();
    	
    	$selected_type_arr = [];

    	foreach ($selected_type as $key => $value) {
    		$selected_type_arr[] = $value['type'];
    	}
    	
    	$this->addField('general', 'id', 'ID', 'hidden', ['required' => false]);
        $this->addField('general', 'customer_id', 'Customer ID', 'hidden', ['required' => true]);
    	$this->addField('general', 'type', 'Type', 'multiselect', [
            'required' => true,
            'source'   => Type::class,
            'value'=>$selected_type_arr,
            'readonly' => $this->getInstance()->id
        ]);
        $this->addField('general', 'status', 'Status', 'hidden', [
            'readonly' => true,
            'source'   => Status::class,
        ]);
        /* Add Form Buttons */
        $this->addButton('Back to Customer', route('admin.customer.edit', ['id' => optional($this->instance->customer)->id]), 'admin.customer.edit', 'back');
    }
}