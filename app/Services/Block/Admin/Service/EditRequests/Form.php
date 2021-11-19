<?php
namespace App\Services\Block\Admin\Service\EditRequests;

use App\Services\Model\Source\EditRequest\Status;

class Form extends \WFN\Admin\Block\Widget\AbstractForm
{

    protected $adminRoute = 'admin.customer.service.edit_request';

    protected function _beforeRender()
    {
        $this->addField('general', 'status', 'Status', 'select', [
            'readonly' => true,
            'source'   => Status::class,
        ]);

        $this->addField('details', 'details', 'Details', 'service_edit_request_details');

        return parent::_beforeRender();
    }

    public function getButtons()
    {
        $this->buttons = [
            [
                'label'  => 'Back to Grid',
                'action' => route($this->adminRoute),
                'type'   => 'back',
                'route'  => $this->adminRoute
            ],
            [
                'label'  => 'Back to Service',
                'action' => route('admin.customer.service.edit', ['id' => $this->instance->service_id]),
                'type'   => 'back',
                'route'  => 'admin.customer.service.edit'
            ],
            [
                'label'    => 'Print',
                'jsaction' => 'window.open("' . route('admin.customer.service.edit_request.print', ['id' => $this->instance]) . '")',
                'route'    => 'admin.customer.service.edit_request.print'
            ]
        ];
        if($this->instance->status == Status::SUBMITTED) {
            $this->buttons[] = [
                'label'        => 'Start',
                'action'       => route('admin.customer.service.edit_request.start', ['edit_request' => $this->instance]),
                'class'        => 'warning',
                'confirmation' => true,
                'route'        => 'admin.customer.service.edit_request.start'
            ];
        }

        return $this->buttons;
    }

}