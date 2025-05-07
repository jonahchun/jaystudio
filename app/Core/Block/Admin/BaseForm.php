<?php
namespace App\Core\Block\Admin;

use App\Customer\Model\Source\OnlineGalleryLinkSource;
use App\Services\Model\Source\LinkTypeSource;
use App\Services\Model\Source\Status;
use App\Services\Model\Source\Type;
use App\Services\Model\Source\Gallery;
use App\Services\Model\Source\EngagementSessionGallery;

class BaseForm extends \WFN\Admin\Block\Widget\AbstractForm
{
    public function getButtons()
    {
        array_unshift($this->buttons, [
            'label'    => 'Back',
            'action'   => url()->previous(),
            'type'     => 'back',
            'route'    => $this->adminRoute,
        ]);

        if($this->getInstance()->id) {
            $this->buttons[] = [
                'label'        => 'Delete',
                'type'         => 'delete',
                'action'       => route($this->adminRoute . '.delete', ['id' => $this->getInstance()->id]),
                'class'        => 'danger',
                'confirmation' => true,
                'route'        => $this->adminRoute . '.delete',
            ];
        }

        $this->buttons[] = [
            'label'    => 'Save',
            'jsaction' => '$("#edit-form").submit()',
            'type'     => 'save',
            'class'    => 'success',
            'route'    => $this->adminRoute . '.save',
        ];
        return $this->buttons;
    }

}
