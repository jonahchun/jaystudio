<?php
namespace App\Services\Model\Service;

class TycDetail extends StdcDetail
{

    const TYPE = \App\Services\Model\Source\Type::TYC;

    const CARD_TYPE = \App\Card\Model\Source\Type::TYC;

    const MEDIA_PATH = 'service' . DIRECTORY_SEPARATOR . 'tyc' . DIRECTORY_SEPARATOR;

    protected $fillable = ['service_id', 'layout_type', 'message', 'size_id', 'format',
        'cards_amount', 'front_side_template_id', 'front_side_images', 'inside_template_id', 'inside_images',
        'back_side_template_id', 'back_side_images', 'delivery_location_id', 'comment', 'file', 'completion'];

    protected $casts = [
        'front_side_images' => 'array',
        'inside_images'     => 'array',
        'back_side_images'  => 'array',
    ];

    public function inside_template()
    {
        return $this->belongsTo(\App\Card\Model\Template::class);
    }

}