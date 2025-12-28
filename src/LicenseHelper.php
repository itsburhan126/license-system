<?php

namespace CodeLab\LicenseSystem;

class LicenseHelper
{
    /**
     * Get the Burhan Labs Pvt. Ltd URL.
     * 
     * @return string
     */
    public static function getOwnerPanelUrl()
    {
        return config('license.server_url', env('LICENSE_SERVER_URL', 'https://burhanlabs.xyz'));
    }

    /**
     * Get the API Endpoint for verification.
     * 
     * @return string
     */
    public static function getVerificationApiUrl()
    {
        return self::getOwnerPanelUrl() . '/api/verify-license';
    }
}
