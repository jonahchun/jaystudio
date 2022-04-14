<?php
return [
    'customer' => [
        'label' => 'Customers',
        'icon'  => 'icon-user',
        'childrens' => [
            'customers' => [
                'route' => 'admin.customer',
                'label' => 'Manage Customers',
            ],
            'customer-contatcs' => [
                'route' => 'admin.customer.contact',
                'label' => 'Customer Contacts',
            ],
            'customer-contatc-roless' => [
                'route' => 'admin.customer.contact.role',
                'label' => 'Customer Contact Roles',
            ],
            'invoices' => [
                'route' => 'admin.payments.invoices',
                'label' => 'Invoices',
            ],
            'services' => [
                'route' => 'admin.customer.service',
                'label' => 'Services',
            ],
            'edit-requests' => [
                'route' => 'admin.customer.service.edit_request',
                'label' => 'Edit Requests',
            ],
        ],
    ],
    'album' => [
        'label' => 'Album Order Form',
        'icon'  => 'icon-notebook',
        'childrens' => [
            'sizes' => [
                'route' => 'admin.album.size',
                'label' => 'Sizes',
            ],
            'core-types' => [
                'route' => 'admin.album.core-type',
                'label' => 'Core Types',
            ],
            'luxe-types' => [
                'route' => 'admin.album.luxe-type',
                'label' => 'Luxe Types',
            ],
            'vintage-covers' => [
                'route' => 'admin.album.vintage-cover',
                'label' => 'Vintage Covers',
            ],
            'black-matte-covers' => [
                'route' => 'admin.album.black-matte-cover',
                'label' => 'Black Matte Covers',
            ],
            'art-deco-colors' => [
                'route' => 'admin.album.art-deco-color',
                'label' => 'Art Deco Colors',
            ],
            'art-deco-patterns' => [
                'route' => 'admin.album.art-deco-pattern',
                'label' => 'Art Deco Patterns',
            ],
            'acrylic-images' => [
                'route' => 'admin.album.acrylic-images',
                'label' => 'Acrylic Images',
            ],
        ],
    ],
    'cards' => [
        'label' => 'Cards Order Form',
        'icon'  => 'icon-book-open',
        'childrens' => [
            'sizes' => [
                'route' => 'admin.card.size',
                'label' => 'Sizes',
            ],
            'core-types' => [
                'route' => 'admin.card.template',
                'label' => 'Templates',
            ],
        ],
    ],
    'wedding_checklist' => [
        'label' => 'Wedding Checklist',
        'icon'  => 'icon-list',
        'childrens' => [
            'preparations' => [
                'route' => 'admin.wedding.checklist.preparation',
                'label' => 'Preparations',
            ],
            'ceremonies' => [
                'route' => 'admin.wedding.checklist.ceremony',
                'label' => 'Ceremonies'
            ],
            'receptions' => [
                'route' => 'admin.wedding.checklist.reception',
                'label' => 'Receptions'
            ],
            'first-looks' => [
                'route' => 'admin.wedding.checklist.first-look',
                'label' => 'Portrait Sessions / First Looks'
            ],
            'vendors' => [
                'route' => 'admin.wedding.checklist.vendor',
                'label' => 'Vendors'
            ],
        ],
    ],
    'wedding_schedule' => [
        'label' => 'Wedding Schedule',
        'icon'  => 'icon-note',
        'childrens' => [
            'settings' => [
                'route' => 'admin.wedding.schedule.ceremony.setting',
                'label' => 'Ceremony Settings',
            ],
            'details' => [
                'route' => 'admin.wedding.schedule.ceremony.detail',
                'label' => 'Ceremony Details'
            ],
            'traditions' => [
                'route' => 'admin.wedding.schedule.ceremony.tradition',
                'label' => 'Ceremony Traditions'
            ],
            'preparation_settings' => [
                'route' => 'admin.wedding.schedule.preparation.setting',
                'label' => 'Preparation Settings',
            ],
        ],
    ],
    'general' => [
        'label' => 'General',
        'icon'  => 'icon-info',
        'childrens' => [
            'pickup-location' => [
                'route' => 'admin.pickup-location',
                'label' => 'Pickup Locations',
            ],
            'questions' => [
                'route' => 'admin.questions',
                'label' => 'Details about you - Questions',
            ],
            'gallery_link' => [
                'route' => 'admin.gallery-link',
                'label' => 'Online Gallery Link',
            ],
        ],
    ],
];