<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Model\Source\Status;
use App\Services\Model\Source\Type;

class SendNotificationEmails extends Command
{

    protected $signature = 'customer:send_notification_emails';

    protected $description = 'Send notification emails';

    public function handle()
    {
        $historyComments = \App\Services\Model\Service\StatusHistory::where('is_customer_notified', 0)
                            ->orderBy('id','DESC')->get()->unique('service_id');
        foreach($historyComments as $historyComment) {
            try {
                switch($historyComment->status) {
                    case Status::COMPLETE:
                        $this->_sendCompleteEmail($historyComment);
                        break;
                    case Status::EDITING:
                        $this->_sendEditingEmail($historyComment);
                        break;
                    case Status::EDITS_COMPLETE:
                        $this->_sendEditsCompleteEmail($historyComment);
                        break;
                    case Status::DRAFT_PROTOTYPING:
                        $this->_sendPrototypingStartedEmail($historyComment);
                        break;
                    case Status::DRAFT_EDITS_APPROVED:
                        $this->_sendPrototypeApprovedEmail($historyComment);
                        break;
                    case Status::EDIT_REQUEST_SUBMITTED:
                        $this->_sendNewEditRequestEmail($historyComment);
                        break;
                    case Status::DRAFT_EDITS_PROCESSING:
                        $this->_sendEditRequestProcessingEmail($historyComment);
                        break;
                    case Status::PENDING_DRAFT_APPROVAL:
                        $this->_sendPendingApprovalEmail($historyComment);
                        break;
                    case Status::PROCESSING:
                        $this->_sendStartPrintingEmail($historyComment);
                        break;
                    case Status::ORDER_FORM_SUBMITTED:
                        $this->_sendOrderFormSubmittedEmail($historyComment);
                        break;
                }
                $historyComment->update(['is_customer_notified' => 1]);
            } catch (\Exception $e) {
                //pass
            }
        }
    }

    protected function _sendCompleteEmail($historyComment)
    {
        if(!$historyComment->service->pickup_location) {
            $this->_sendShippedEmail($historyComment);
            return $this;
        }
        switch($historyComment->service->type) {
            case Type::PHOTO:
                $this->_sendPhotoCompleteEmail($historyComment);
                break;
            case Type::VIDEO:
                $this->_sendVideoCompleteEmail($historyComment);
                break;
            case Type::TYC:
            case Type::STDC:
            case Type::PHOTO_ALBUM:
                $this->_sendReadyToPickupEmail($historyComment);
                break;
        }
    }

    protected function _sendPhotoCompleteEmail($historyComment)
    {
        $this->_sendEmailWithDueBalance($historyComment, 'photography-complete');
    }

    protected function _sendVideoCompleteEmail($historyComment)
    {
        $this->_sendEmailWithDueBalance($historyComment, 'videography-complete');
    }

    protected function _sendReadyToPickupEmail($historyComment)
    {
        $this->_sendEmailWithDueBalance($historyComment, 'ready-to-pickup');
    }

    protected function _sendEditingEmail($historyComment)
    {
        switch($historyComment->service->type) {
            case Type::PHOTO:
                $this->_sendPhotoEditingEmail($historyComment);
                break;
            case Type::VIDEO:
                $this->_sendVideoEditingEmail($historyComment);
                break;
        }
    }

    protected function _sendPhotoEditingEmail($historyComment)
    {
        $this->_sendSimpleEmail($historyComment, 'photography-edit-request-processing');
    }

    protected function _sendVideoEditingEmail($historyComment)
    {
        $this->_sendSimpleEmail($historyComment, 'videography-edit-request-processing');
    }

    protected function _sendEditsCompleteEmail($historyComment)
    {
        switch($historyComment->service->type) {
            case Type::PHOTO:
                $this->_sendPhotoEditsCompleteEmail($historyComment);
                break;
            case Type::VIDEO:
                $this->_sendVideoEditsCompleteEmail($historyComment);
                break;
        }
    }

    protected function _sendEditRequestProcessingEmail($historyComment)
    {
        $this->_sendEmailWithProductName($historyComment, 'edit-request-processing');
    }

    protected function _sendPhotoEditsCompleteEmail($historyComment)
    {
        $this->_sendSimpleEmail($historyComment, 'photography-edit-request-completed');
    }

    protected function _sendVideoEditsCompleteEmail($historyComment)
    {
        $this->_sendSimpleEmail($historyComment, 'videography-edit-request-completed');
    }

    protected function _sendPrototypingStartedEmail($historyComment)
    {
        $this->_sendEmailWithProductName($historyComment, 'prototyping-started');
    }

    protected function _sendPrototypeApprovedEmail($historyComment)
    {
        $this->_sendEmailWithProductName($historyComment, 'prototype-approved');
    }

    protected function _sendNewEditRequestEmail($historyComment)
    {
        switch($historyComment->service->type) {
            case Type::PHOTO:
                $this->_sendPhotoNewEditRequestEmail($historyComment);
                break;
            case Type::VIDEO:
                $this->_sendVideoNewEditRequestEmail($historyComment);
                break;
            case Type::TYC:
            case Type::STDC:
            case Type::PHOTO_ALBUM:
                $this->_sendEmailWithProductName($historyComment, 'new-edit-request');
                break;
        }
    }

    protected function _sendPhotoNewEditRequestEmail($historyComment)
    {
        $this->_sendSimpleEmail($historyComment, 'photography-new-edit-request');
    }

    protected function _sendVideoNewEditRequestEmail($historyComment)
    {
        $this->_sendSimpleEmail($historyComment, 'videography-new-edit-request');
    }

    protected function _sendPendingApprovalEmail($historyComment)
    {
        if($historyComment->service->edit_requests->count()) {
            $this->_sendEmailWithProductName($historyComment, 'edit-request-completed');
        } else {
            $this->_sendEmailWithProductName($historyComment, 'prototyping-completed');
        }
    }

    protected function _sendStartPrintingEmail($historyComment)
    {
        if(in_array($historyComment->service->type, [Type::PHOTO, Type::VIDEO])) {
            return false;
        }
        $this->_sendEmailWithProductName($historyComment, 'print-processing');
    }

    protected function _sendOrderFormSubmittedEmail($historyComment)
    {
        if(in_array($historyComment->service->type, [Type::PHOTO, Type::VIDEO])) {
            return false;
        }
        $this->_sendEmailWithProductName($historyComment, 'order-form-submitted');
    }

    protected function _sendShippedEmail($historyComment)
    {
        $service = $historyComment->service;
        $customer = $service->customer;
        \MandrillMail::send('shipped', $customer->email, [
            'first_newlywed_name'  => $customer->first_newlywed->first_name,
            'second_newlywed_name' => $customer->second_newlywed->first_name,
            'tracking_number'      => $service->tracking_link,
            'service_detail_link'  => url(route('service.view', ['service' => $service])),
            'comment'              => $historyComment->comment ?: ' ',
        ], \Settings::getConfigValue('email/shipped_email_recipients'));
    }

    protected function _sendEmailWithDueBalance($historyComment, $template)
    {
        $service = $historyComment->service;
        $customer = $service->customer;
        $query = $customer->invoices()->where('status', '!=', \App\Payments\Model\Source\Status::PAID);
        $totalDue = $query->sum('amount') + $query->sum('tax_amount');
        \MandrillMail::send($template, $customer->email, [
            'first_newlywed_name'  => $customer->first_newlywed->first_name,
            'second_newlywed_name' => $customer->second_newlywed->first_name,
            'location_name'        => optional($service->pickup_location)->title,
            'balance_amount'       => '$' . number_format($totalDue, 2),
            'service_detail_link'  => url(route('service.view', ['service' => $service])),
            'comment'              => $historyComment->comment ?: ' ',
        ], \Settings::getConfigValue('email/' . $template . '_email_recipients'));
    }

    protected function _sendEmailWithProductName($historyComment, $template)
    {
        $service = $historyComment->service;
        $customer = $service->customer;
        $serviceName = \App\Services\Model\Source\Type::getInstance()->getOptionLabel($service->type);
        \MandrillMail::send($template, $customer->email, [
            'first_newlywed_name'  => $customer->first_newlywed->first_name,
            'second_newlywed_name' => $customer->second_newlywed->first_name,
            'product_name'         => $serviceName,
            'service_detail_link'  => url(route('service.view', ['service' => $service])),
            'comment'              => $historyComment->comment ?: ' ',
        ], \Settings::getConfigValue('email/' . $template . '_email_recipients'));
    }

    protected function _sendSimpleEmail($historyComment, $template)
    {
        $service = $historyComment->service;
        $customer = $service->customer;
        \MandrillMail::send($template, $customer->email, [
            'first_newlywed_name'  => $customer->first_newlywed->first_name,
            'second_newlywed_name' => $customer->second_newlywed->first_name,
            'service_detail_link'  => url(route('service.view', ['service' => $service])),
            'comment'              => $historyComment->comment ?: ' ',
        ], \Settings::getConfigValue('email/' . $template . '_email_recipients'));
    }

}
