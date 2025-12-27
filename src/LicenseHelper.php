<?php

namespace CodeLab\LicenseSystem;

class LicenseHelper
{
    // Server URL
    private const SERVER_URL = 'http://127.0.0.1:8000'; 

    /**
     * Get the OwnerPanel URL.
     * 
     * @return string
     */
    public static function getOwnerPanelUrl()
    {
        return self::SERVER_URL;
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
