<?php
namespace App\Services\Model\Service;

class StdcDetail extends PhotoDetail
{

    const TYPE = \App\Services\Model\Source\Type::STDC;

    const CARD_TYPE = \App\Card\Model\Source\Type::STD;

    const MEDIA_PATH = 'service' . DIRECTORY_SEPARATOR . 'stdc' . DIRECTORY_SEPARATOR;

    protected $fillable = ['service_id', 'size_id', 'format', 'is_magnet', 'cards_amount',
        'reception_address', 'front_side_template_id', 'front_side_images', 'back_side_template_id',
        'back_side_images', 'delivery_location_id', 'comment', 'file', 'completion'];

    protected $casts = [
        'front_side_images' => 'array',
        'back_side_images'  => 'array',
    ];

    protected $mediaFields = ['file'];

    public function size()
    {
        return $this->belongsTo(\App\Card\Model\Size::class);
    }

    public function front_side_template()
    {
        return $this->belongsTo(\App\Card\Model\Template::class);
    }

    public function back_side_template()
    {
        return $this->belongsTo(\App\Card\Model\Template::class);
    }

}