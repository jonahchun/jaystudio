<?php

namespace App\Services\Model\Source;

class EngagementSessionGallery extends \WFN\Admin\Model\Source\AbstractSource
{

    const ENGAGEMENT_SESSION      = 'engagement_session_gallery';
    const ORIGINAL_ENGAGEMENT_SESSION    = 'original_engagement_session_gallery';
    const REEDITED_ENGAGEMENT_SESSION    = 're-edited_engagement_session_gallery';

    public function _getOptions()
    {
        return [
            self::ENGAGEMENT_SESSION     => 'Engagement Session Gallery',
            self::ORIGINAL_ENGAGEMENT_SESSION   => 'Original Engagement Session Gallery',
            self::REEDITED_ENGAGEMENT_SESSION   => 'Re-edited Engagement Session Gallery'
        ];
    }

}