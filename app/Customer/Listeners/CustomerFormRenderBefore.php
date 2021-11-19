<?php

namespace App\Customer\Listeners;

class CustomerFormRenderBefore
{

    public function handle(\WFN\Admin\Events\FormRenderBefore $event)
    {
        $form = $event->getForm();
        if(!$form->getInstance() instanceof \Customer) {
            return;
        }

        $form->updateField('general', 'password', [
            'note' => 'Min length 8 symbols'
        ]);

        if($form ->getInstance()->id && !$form->getInstance()->password) {
            $form->addButton('Send Invite Email', route('admin.customer.send.invite.email', ['customer' => $form ->getInstance()->id]), 'admin.customer.send.invite.email', 'button');
        }
   }

}