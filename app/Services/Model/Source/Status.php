<?php

namespace App\Services\Model\Source;

class Status extends \WFN\Admin\Model\Source\AbstractSource
{

    const PENDING                = 1;
    const PROCESSING             = 2;
    const COMPLETE               = 3;
    const EDITING                = 4;
    const EDITS_COMPLETE         = 5;
    const ON_HOLD                = 6;
    const IN_EDITS               = 7;
    const AWAITING_ORDER_FORM    = 8;
    const DRAFT_PROTOTYPING      = 9;
    const ORDER_FORM_SUBMITTED   = 10;
    const DRAFT_EDITS_PROCESSING = 11;
    const PENDING_DRAFT_APPROVAL = 12;
    const EDIT_REQUEST_SUBMITTED = 13;
    const DRAFT_EDITS_APPROVED   = 14;

    protected function _getOptions()
    {
        return [
            self::PENDING                => 'Pending',
            self::PROCESSING             => 'Processing',
            self::COMPLETE               => 'Complete',
            self::EDITING                => 'Editing',
            self::EDITS_COMPLETE         => 'Edits Complete',
            self::ON_HOLD                => 'On Hold',
            self::IN_EDITS               => 'In Edits',
            self::AWAITING_ORDER_FORM    => 'Awaiting Order Form Submission',
            self::DRAFT_PROTOTYPING      => 'Draft Prototyping',
            self::ORDER_FORM_SUBMITTED   => 'Order Form Submitted',
            self::DRAFT_EDITS_PROCESSING => 'Draft Edits Processing',
            self::PENDING_DRAFT_APPROVAL => 'Pending Draft Approval',
            self::EDIT_REQUEST_SUBMITTED => 'Edit Request Submitted',
            self::DRAFT_EDITS_APPROVED   => 'Draft Edits Approved',
        ];
    }

}