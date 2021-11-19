<?php

namespace App\Services\Helper;

class Status
{

    public static function getShortStatus($service)
    {
        $content = \Settings::getConfigValue('service_' . $service->type . '/short_note_status_' . $service->status);
        return self::_getConditionalContent($content, $service);
    }

    public static function getLongStatus($service)
    {
        $content = \Settings::getConfigValue('service_' . $service->type . '/long_note_status_' . $service->status);
        return self::_getConditionalContent($content, $service);
    }

    public static function getUploadsStatus($service)
    {
        $content = \Settings::getConfigValue('service_' . $service->type . '/uploads_note_status_' . $service->status);
        return self::_getConditionalContent($content, $service);
    }

    public static function getEditRequestsStatus($service)
    {
        $content = \Settings::getConfigValue('service_' . $service->type . '/edit_requests_note_status_' . $service->status);
        return self::_getConditionalContent($content, $service);
    }

    protected static function _getConditionalContent($content, $service)
    {
        ob_start();
        
        $location = optional($service->pickup_location);
        eval('?>' . \Blade::compileString($content));

        return ob_get_clean();
    }
}