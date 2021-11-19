<?php
namespace App\Services\Block\Admin\Service\Uploads;

use App\Services\Model\Source\Upload\Status;

class Form extends \WFN\Admin\Block\Widget\AbstractForm
{

    protected $adminRoute = 'admin.customer.service.uploads';

    protected function _beforeRender()
    {
        $this->addField('general', 'id', 'ID', 'hidden', ['required' => false]);
        $this->addField('general', 'service_id', 'Service ID', 'hidden', ['required' => true]);
        
        $this->addField('general', 'file', 'File', 'file');
        $this->addField('general', 'url_link', 'URL Link', 'text');
        
        $this->addField('general', 'status', 'Status', 'select', [
            'readonly' => true,
            'source'   => Status::class,
        ]);

        $this->addField('general', 'comment', 'Comment', 'textarea');

        return parent::_beforeRender();
    }

    public function getButtons()
    {
        $this->buttons = [
            [
                'label'  => 'Back',
                'action' => route('admin.customer.service.edit', ['id' => $this->instance->service_id]),
                'type'   => 'back',
                'route'  => 'admin.customer.service.edit',
            ],
            [
                'label'    => 'Save',
                'jsaction' => '$("#edit-form").submit()',
                'type'     => 'save',
                'class'    => 'success',
                'route'    => 'admin.customer.service',
            ]
        ];

        return $this->buttons;
    }

}