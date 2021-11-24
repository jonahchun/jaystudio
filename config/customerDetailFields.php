<?php

use App\Customer\Model\Source\NewlywedPosition;
use App\Customer\Model\Source\NewlywedType;

function getNewlywedFields($newlywedPosition) {
    return [
        'bridegroom_' . $newlywedPosition => [
            'type'     => 'select',
            'label'    => 'Type',
            'options'  => [
                'required' => true,
                'source'   => NewlywedPosition::class,
            ],
        ],
        'avatar_' . $newlywedPosition => [
            'type'     => 'image',
            'label'    => 'Avatar',
        ],
        'first_name_' . $newlywedPosition => [
            'type'     => 'text',
            'label'    => 'First Name',
            'options'  => [
                'required' => true,
            ],
        ],
        'last_name_' . $newlywedPosition => [
            'type'     => 'text',
            'label'    => 'Last Name',
            'options'  => [
                'required' => true,
            ],
        ],
        'email_' . $newlywedPosition => [
            'type'     => 'text',
            'label'    => 'Email',
            'options'  => [
                'required' => true,
            ],
        ],
        'phone_' . $newlywedPosition => [
            'type'     => 'text',
            'label'    => 'Phone',
            'options'  => [
                'required' => true,
            ],
        ],
    ];
}

function getAddressFields() {
    return [
        'address_line_1' => [
            'type'     => 'text',
            'label'    => 'Address Line 1',
            'options'  => [
                'required' => true,
            ],
        ],
        'address_line_2' => [
            'type'     => 'text',
            'label'    => 'Address Line 2',
        ],
        'state' => [
            'type'     => 'text',
            'label'    => 'State / Province',
            'options'  => [
                'required' => true,
            ],
        ],
        'city' => [
            'type'     => 'text',
            'label'    => 'City',
            'options'  => [
                'required' => true,
            ],
        ],
        'zip' => [
            'type'     => 'text',
            'label'    => 'Postcode',
            'options'  => [
                'required' => true,
            ],
        ],
    ];
}

return [
    'general' => [
        'account_id' => [
            'type'     => 'text',
            'label'    => 'Account ID',
            'grid'     => true,
            'options'  => [
                'required' => true,
            ],
        ],
        'wedding_date' => [
            'type'     => 'date',
            'label'    => 'Wedding Date',
            'grid'     => true,
            'options'  => [
                'required' => true,
                'format'   => config('app.date_format'),
            ],
        ],
        'contract' => [
            'type'     => 'file',
            'label'    => 'Contract',
            'options'  => [
                'required' => true,
            ],
        ],
    ],
    NewlywedType::FIRST . '_newlywed'  => getNewlywedFields(NewlywedType::FIRST),
    NewlywedType::SECOND . '_newlywed' => getNewlywedFields(NewlywedType::SECOND),
    // 'billing_address'                  => getAddressFields(),
    'details_about_you' => [
        'question_answers' => [
            'type'  => 'newlywed_details',
            'label' => '',
        ],
        'comment' => [
            'type'  => 'textarea',
            'label' => 'Comment',
            'options'  => [
                'readonly' => true,
            ],
        ],
        'file' => [
            'type'  => 'file',
            'label' => 'File',
            'options'  => [
                'readonly' => true,
            ],
        ],
    ],
    'contacts' => [
        'contacts' => [
            'type'  => 'contacts',
            'label' => '',
        ],
    ],
    'wedding_checklist' => [
        'wedding_checklist' => [
            'type'  => 'wedding_checklist',
            'label' => '',
        ],
    ],
    'wedding_schedule' => [
        'wedding_schedule' => [
            'type'  => 'wedding_schedule',
            'label' => '',
        ],
    ],
    'services' => [
        'services' => [
            'type'  => 'services',
            'label' => '',
        ],
    ],
    'invoices' => [
        'invoices' => [
            'type'  => 'invoices',
            'label' => '',
        ],
    ],
];