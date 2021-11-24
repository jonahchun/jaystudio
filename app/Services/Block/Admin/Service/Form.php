<?php
namespace App\Services\Block\Admin\Service;

use App\Services\Model\Source\Status;
use App\Services\Model\Source\Type;

class Form extends \WFN\Admin\Block\Widget\AbstractForm
{

    protected $adminRoute = 'admin.customer.service';

    protected function _beforeRender()
    {
        /* Add Form Fields */
        $this->addField('general', 'id', 'ID', 'hidden', ['required' => false]);
        $this->addField('general', 'customer_id', 'Customer ID', 'hidden', ['required' => true]);
        
        $this->addField('general', 'type', 'Type', 'multiselect', [
            'required' => true,
            'source'   => Type::class,
            'readonly' => $this->getInstance()->id
        ]);
        
        $this->addField('general', 'status', 'Status', 'select', [
            'readonly' => true,
            'source'   => Status::class,
        ]);

        if($this->instance->type && $this->instance->detail) {
            $this->addField('general', 'completion', 'Completion', 'date');
            $additionalFieldsCallback = '_add_' . $this->instance->type . '_fields';
            $this->$additionalFieldsCallback();

            $this->addField('uploads', 'uploads', 'Uploads', 'service_uploads');
            $this->addField('edit_requests', 'edit_requests', 'Edit Requests', 'service_edit_requests');
        }
        
        $this->addField('comments_history', 'service_comments', 'Comments', 'service_comments');

        /* Add Form Buttons */
        $this->addButton('Back to Customer', route('admin.customer.edit', ['id' => optional($this->instance->customer)->id]), 'admin.customer.edit', 'back');

        if($this->getInstance()->status == Status::ON_HOLD) {
            $this->buttons[] = [
                'label'        => 'Unhold',
                'action'       => route('admin.customer.service.unhold', ['id' => $this->getInstance()->id]),
                'class'        => 'info',
                'confirmation' => true,
                'route'        => 'admin.customer.service.unhold'
            ];
        }

        if($this->getInstance()->status != Status::ON_HOLD) {
            $this->buttons[] = [
                'label'    => 'Hold',
                'jsaction' => 'serviceHoldPopup(\'' . route('admin.customer.service.hold', ['id' => $this->getInstance()->id]) . '\')',
                'class'    => 'warning',
                'route'    => 'admin.customer.service.hold'
            ];
        }

        if($this->getInstance()->type == Type::PHOTO) {
            $this->buttons[] = [
                'label'    => 'Send Teaser',
                'jsaction' => 'teaserEmailPopup(\'' . route('admin.customer.service.send-teaser', ['id' => $this->getInstance()->id]) . '\')',
                'class'    => 'info',
                'route'    => 'admin.customer.service.send-teaser'
            ];
            $this->buttons[] = [
                'label'    => 'Send Engagement Session Gallery',
                'jsaction' => 'engagementSessionEmailPopup(\'' . route('admin.customer.service.send-engagement-session', ['id' => $this->getInstance()->id]) . '\')',
                'class'    => 'info',
                'route'    => 'admin.customer.service.send-engagement-session'
            ];
        }

        if(!in_array($this->getInstance()->type, [Type::PHOTO, Type::VIDEO])) {
            switch($this->getInstance()->status) {
                case Status::ORDER_FORM_SUBMITTED:
                    $this->buttons[] = [
                        'label'        => 'Start Draft Prototype',
                        'action'       => route('admin.customer.service.start-draft', ['id' => $this->instance->id]),
                        'class'        => 'info',
                        'confirmation' => true,
                        'route'        => 'admin.customer.service.start-draft'
                    ];
                    break;
                case Status::DRAFT_EDITS_APPROVED:
                    $this->buttons[] = [
                        'label'        => 'Process',
                        'action'       => route('admin.customer.service.process', ['id' => $this->instance->id]),
                        'class'        => 'info',
                        'confirmation' => true,
                        'route'        => 'admin.customer.service.process'
                    ];
                    break;
                case Status::PROCESSING:
                    $this->buttons[] = [
                        'label'    => 'Complete',
                        'jsaction' => 'serviceCompletePopup(\'' . route('admin.customer.service.complete', ['id' => $this->getInstance()->id]) . '\')',
                        'class'    => 'success',
                        'route'    => 'admin.customer.service.complete'
                    ];
                    break;
            }
            if($this->getInstance()->status != Status::AWAITING_ORDER_FORM) {
                $this->buttons[] = [
                    'label'    => 'Print',
                    'jsaction' => 'window.open(\'' . route('admin.customer.service.print', ['service' => $this->getInstance()->id]) . '\')',
                    'route'    => 'admin.customer.service.print'
                ];
            }
        } else {
            switch($this->getInstance()->status) {
                case Status::PROCESSING:
                case Status::EDITS_COMPLETE:
                    $this->buttons[] = [
                        'label'    => 'Complete',
                        'jsaction' => 'serviceCompletePopup(\'' . route('admin.customer.service.complete', ['id' => $this->getInstance()->id]) . '\')',
                        'class'    => 'success',
                        'route'    => 'admin.customer.service.complete'
                    ];
                    break;
                case Status::PENDING:
                    $this->buttons[] = [
                        'label'        => 'Process',
                        'action'       => route('admin.customer.service.process', ['id' => $this->instance->id]),
                        'class'        => 'info',
                        'confirmation' => true,
                        'route'        => 'admin.customer.service.process'
                    ];
                    break;
            }
        }

        return parent::_beforeRender();
    }

    public function getAfterFormHtml()
    {
        $form = $this;
        return view('admin.widget.form.service_form_additional_html', compact('form'));
    }

    protected function _add_photography_fields()
    {
        $this->addField('details', 'upload', 'Upload', 'text', [
            'readonly' => true
        ]);
    }

    protected function _add_videography_fields()
    {
        $this->_add_photography_fields();
    }

    protected function _add_thank_you_card_fields()
    {
        $this->_add_save_the_date_card_fields(['front_side', 'inside', 'back_side'], \App\Card\Model\Source\TycTemplates::class);
    }

    protected function _add_save_the_date_card_fields($sides = ['front_side', 'back_side'], $templatesSource = \App\Card\Model\Source\StdTemplates::class)
    {
        /* Card Information Tab */
        if($this->getInstance()->type == Type::TYC) {
            $this->addField('card_information', 'layout_type', 'Layout Type', 'select', [
                'required' => true,
                'source'   => \App\Card\Model\Source\LayoutType::class,
            ]);
        }

        $this->addField('card_information', 'message', 'Message', 'textarea');
        $this->addField('card_information', 'size_id', 'Size', 'select', [
            'required' => true,
            'source'   => \App\Card\Model\Source\Sizes::class,
        ]);
        $this->addField('card_information', 'format', 'Format', 'select', [
            'required' => true,
            'source'   => \App\Card\Model\Source\Format::class,
        ]);
        $this->addField('card_information', 'is_magnet', 'Is Magnet', 'select', [
            'required' => true,
            'source'   => \App\Core\Model\Source\Yesno::class,
        ]);

        $this->addField('card_information', 'cards_amount', 'Cards Amount', 'text', ['required' => true]);

        /* Side Information Tabs */
        foreach($sides as $side) {
            $this->addField($side . '_information', $side . '_template_id', 'Template', 'select', [
                'source'   => $templatesSource,
            ]);
            $templateSideRelation = $side . '_template';
            $imagesCount = optional($this->getInstance()->$templateSideRelation)->images_count;
            $this->addField($side . '_information', $side . '_images', 'Images', 'service_card_images', [
                'images_count' => intval($imagesCount),
                'side'         => $side,
            ]);
        }

        /* Additional Information Tab */
        $this->_add_additional_information_fields();
    }

    protected function _add_photo_album_fields()
    {
        /* Album Main Information */
        $this->addField('album_information', 'album_type', 'Type', 'select', [
            'required' => true,
            'source'   => \App\Album\Model\Source\Type::class,
        ]);
        $this->addField('album_information', 'luxe_type_id', 'Luxe Type', 'select', [
            'required' => false,
            'source'   => \App\Album\Model\Source\LuxeTypes::class,
        ]);
        $this->addField('album_information', 'core_type_id', 'Core Type', 'select', [
            'required' => true,
            'source'   => \App\Album\Model\Source\CoreTypes::class,
        ]);
        $this->addField('album_information', 'size_id', 'Size', 'select', [
            'required' => false,
            'source'   => \App\Album\Model\Source\Sizes::class,
        ]);
        $this->addField('album_information', 'other_size', 'Other Size', 'text');
        
        /* Luxe - Leather Tab */
        $this->addField('leather_luxe_type', 'leather_text', 'Text', 'textarea');

        /* Luxe - Vintage Tab */
        $this->addField('vintage_luxe_type', 'vintage_cover_id', 'Cover', 'select', [
            'required' => false,
            'source'   => \App\Album\Model\Source\VintageCovers::class,
        ]);

        /* Luxe - Black Matte Tab */
        $this->addField('black_matte_luxe_type', 'black_matte_cover_id', 'Cover', 'select', [
            'required' => false,
            'source'   => \App\Album\Model\Source\BlackMatteCovers::class,
        ]);

        /* Luxe - Art Deco Tab */
        $this->addField('art_deco_luxe_type', 'art_deco_color_id', 'Color', 'select', [
            'required' => false,
            'source'   => \App\Album\Model\Source\ArtDecoColors::class,
        ]);
        $this->addField('art_deco_luxe_type', 'art_deco_pattern_id', 'Pattern', 'select', [
            'required' => false,
            'source'   => \App\Album\Model\Source\ArtDecoPatterns::class,
        ]);
        $this->addField('art_deco_luxe_type', 'art_deco_cover_image', 'Cover Image', 'text');

        /* Acrylic Tab */
        $this->addField('acrylic_type', 'acrylic_cover_image', 'Cover Image', 'text');

        /* Images Tab */
        $this->addField('images', 'images', 'Images', 'service_album_images', [
            'images_count' => intval(optional($this->getInstance()->core_type)->photos_count),
        ]);

        /* Additional Information Tab */
        $this->_add_additional_information_fields();
    }

    protected function _add_additional_information_fields()
    {
        $this->addField('additional_information', 'delivery_location_id', 'Delivery Location', 'select', [
            'required' => false,
            'source'   => \App\Core\Model\Source\Locations::class,
        ]);
        $this->addField('additional_information', 'comment', 'Comment', 'textarea');
        $this->addField('additional_information', 'file', 'File', 'file');
    }

}