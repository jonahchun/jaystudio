<?php

use App\Services\Model\Source\Type as ServiceType;
use App\Services\Model\Source\Status as ServiceStatus;
use App\Card\Model\Source\LayoutType;
use App\Album\Model\Source\Type as AlbumType;
use App\Album\Model\Source\Collection as AlbumCollection;

$services = [
    ServiceType::PHOTO => [
        ServiceStatus::PENDING, ServiceStatus::PROCESSING, ServiceStatus::COMPLETE, ServiceStatus::EDITING, 
        ServiceStatus::EDITS_COMPLETE, ServiceStatus::ON_HOLD
    ],
    ServiceType::ENGAGEMENT_SESSION => [
        ServiceStatus::PENDING, ServiceStatus::PROCESSING, ServiceStatus::COMPLETE, ServiceStatus::EDITING, 
        ServiceStatus::EDITS_COMPLETE, ServiceStatus::ON_HOLD
    ],
    ServiceType::VIDEO => [
        ServiceStatus::PENDING, ServiceStatus::PROCESSING, ServiceStatus::COMPLETE, ServiceStatus::EDITING, 
        ServiceStatus::EDITS_COMPLETE, ServiceStatus::ON_HOLD
    ],
    ServiceType::TYC => [
        ServiceStatus::AWAITING_ORDER_FORM, ServiceStatus::ORDER_FORM_SUBMITTED, ServiceStatus::DRAFT_PROTOTYPING,
        ServiceStatus::PENDING_DRAFT_APPROVAL, ServiceStatus::EDIT_REQUEST_SUBMITTED, ServiceStatus::DRAFT_EDITS_PROCESSING,
        ServiceStatus::DRAFT_EDITS_APPROVED, ServiceStatus::PROCESSING, ServiceStatus::COMPLETE, ServiceStatus::ON_HOLD,
    ],
    ServiceType::STDC => [
        ServiceStatus::AWAITING_ORDER_FORM, ServiceStatus::ORDER_FORM_SUBMITTED, ServiceStatus::DRAFT_PROTOTYPING,
        ServiceStatus::PENDING_DRAFT_APPROVAL, ServiceStatus::EDIT_REQUEST_SUBMITTED, ServiceStatus::DRAFT_EDITS_PROCESSING,
        ServiceStatus::DRAFT_EDITS_APPROVED, ServiceStatus::PROCESSING, ServiceStatus::COMPLETE, ServiceStatus::ON_HOLD,
    ],
    ServiceType::PHOTO_ALBUM => [
        ServiceStatus::AWAITING_ORDER_FORM, ServiceStatus::ORDER_FORM_SUBMITTED, ServiceStatus::DRAFT_PROTOTYPING,
        ServiceStatus::PENDING_DRAFT_APPROVAL, ServiceStatus::EDIT_REQUEST_SUBMITTED, ServiceStatus::DRAFT_EDITS_PROCESSING,
        ServiceStatus::DRAFT_EDITS_APPROVED, ServiceStatus::PROCESSING, ServiceStatus::COMPLETE, ServiceStatus::ON_HOLD,
    ],
];

$servicesConfig = [];
foreach($services as $service => $statuses) {
    $fields = [];
    foreach($statuses as $status) {
        $fields['short_note_status_' . $status] = [
            'label' => ServiceStatus::getInstance()->getOptionLabel($status) . ' - Status Short Note',
            'type'  => 'textarea',
        ];
        $fields['long_note_status_' . $status] = [
            'label' => ServiceStatus::getInstance()->getOptionLabel($status) . ' - Status Long Note',
            'type'  => 'textarea',
        ];
        $fields['uploads_note_status_' . $status] = [
            'label' => ServiceStatus::getInstance()->getOptionLabel($status) . ' - Status Uploads Note',
            'type'  => 'textarea',
        ];
        $fields['edit_requests_note_status_' . $status] = [
            'label' => ServiceStatus::getInstance()->getOptionLabel($status) . ' - Status Edit Requests Note',
            'type'  => 'textarea',
        ];
    }
    $servicesConfig['service_' . $service] = [
        'label'  => ServiceType::getInstance()->getOptionLabel($service) . ' Service - Status Notes',
        'fields' => $fields,
    ];
}

$fields = [];
foreach(LayoutType::getInstance()->getOptions() as $key => $label) {
    $fields['card_type_' . $key . '_image'] = [
        'label' => $label . ' Card Type Image',
        'type'  => 'image',
    ];
}
$cardsConfig = [
    'card_type' => [
        'label'  => 'Card Type Images',
        'fields' => $fields,
    ],
];

$fields = [
    'directions' => [
        'label' => 'Directions',
        'type'  => 'wysiwyg',
    ],
    'acrylic_sizes' => [
        'label'   => 'Acrylic Sizes',
        'type'    => 'text',
    ],
];
foreach(AlbumType::getInstance()->getOptions() as $key => $label) {
    $fields['album_' . $key . '_image'] = [
        'label' => $label . ' Album Image',
        'type'  => 'image',
    ];
}
foreach(AlbumCollection::getInstance()->getOptions() as $key => $label) {
    $fields['collection_' . $key . '_id'] = [
        'label' => $label . ' Collection ID',
        'type'  => 'text',
    ];
}
$albumConfig = [
    'photo_album' => [
        'label'  => 'Photo Album',
        'fields' => $fields,
    ],
];

$filePath = realpath(dirname(__DIR__ . '/../.')) . '/storage/framework/cache/email_templates.json';
if(file_exists($filePath) && (time() - filemtime($filePath) < 60*60*4)) { // 4 hours cache
    $resource = fopen($filePath, 'r+');
    $templates = fgets($resource);
    $templates = json_decode($templates, true);
} else {
    $mailApi = new \WFN\Emails\Model\Api();
    $templates = $mailApi->getTemplatesList();
    $resource = fopen($filePath, 'w+');
    fputs($resource, json_encode($templates));
}
fclose($resource);
$emailFields = [
    'wedding_information_reminder_first' => [
        'label' => 'Wedding Information Reminder First (X days)',
        'type'  => 'text',
    ],
    'wedding_information_reminder_second' => [
        'label' => 'Wedding Information Reminder Second (Y days)',
        'type'  => 'text',
    ],
];
foreach($templates as $template) {
    $emailFields[$template['slug'] . '_email_recipients'] = [
        'label' => $template['name'] . ' Email Recipients',
        'type'  => 'text',
    ];
}

$emailFields = array_merge($emailFields, [
    'footer_image' => [
        'label' => 'Footer Image',
        'type'  => 'image',
    ],
    'support_email' => [
        'label' => 'Support Email',
        'type'  => 'text',
    ],
    'faq_link' => [
        'label' => 'FAQ Link',
        'type'  => 'text',
    ],
]);

$mainConfig = [
    'contacts' => [
        'label'  => 'Contatcs',
        'fields' => [
            'description' => [
                'label' => 'Description',
                'type'  => 'textarea',
            ],
            'per_page' => [
                'label' => 'Per Page',
                'type'  => 'text',
            ],
        ],
    ],
    'wedding_info' => [
        'label'  => 'Wedding Information',
        'fields' => [
            'description' => [
                'label' => 'Description',
                'type'  => 'textarea',
            ],
            'schedule_description' => [
                'label' => 'Schedule Description',
                'type'  => 'textarea',
            ],
            'checklist_description' => [
                'label' => 'Checklist Description',
                'type'  => 'textarea',
            ],
            'personal_details_description' => [
                'label' => 'Personal Details Description',
                'type'  => 'textarea',
            ],
            'newlywed_details_form_description' => [
                'label' => 'Newlywed Details Form Description',
                'type'  => 'textarea',
            ],
        ],
    ],
    'songs_list' => [
        'label'  => 'Songs List Content',
        'fields' => [
            'song_list_content' => [
                'label' => 'Content',
                'type'  => 'wysiwyg',
            ],
        ],
    ],
    'services' => [
        'label'  => 'Services',
        'fields' => [
            'popup_content' => [
                'label' => 'Popup Content',
                'type'  => 'wysiwyg',
            ],
        ],
    ],
    'paypal' => [
        'label'  => 'PayPal',
        'fields' => [
            'mode' => [
                'label' => 'Mode',
                'type'  => 'text',
            ],
            'merchant_email' => [
                'label' => 'Merchant Email',
                'type'  => 'text',
            ],
            'client_id' => [
                'label' => 'Client ID',
                'type'  => 'text',
            ],
            'client_secret' => [
                'label' => 'Client Secret',
                'type'  => 'text',
            ],
            'first_name' => [
                'label' => 'First Name',
                'type'  => 'text',
            ],
            'last_name' => [
                'label' => 'Last Name',
                'type'  => 'text',
            ],
            'business_name' => [
                'label' => 'Business Name',
                'type'  => 'text',
            ],
            'phone_country_code' => [
                'label' => 'Phone Country Code',
                'type'  => 'text',
            ],
            'phone_number' => [
                'label' => 'Phone Number',
                'type'  => 'text',
            ],
            'address_line_1' => [
                'label' => 'Address Line 1',
                'type'  => 'text',
            ],
            'address_line_2' => [
                'label' => 'Address Line 2',
                'type'  => 'text',
            ],
            'city' => [
                'label' => 'City',
                'type'  => 'text',
            ],
            'state' => [
                'label' => 'State',
                'type'  => 'text',
            ],
            'postal_code' => [
                'label' => 'Postal Code',
                'type'  => 'text',
            ],
            'country_code' => [
                'label' => 'Country Code',
                'type'  => 'text',
            ],
        ],
    ],
    'email' => [
        'fields' => $emailFields,
    ],
];

return array_merge($mainConfig, $servicesConfig, $cardsConfig, $albumConfig);