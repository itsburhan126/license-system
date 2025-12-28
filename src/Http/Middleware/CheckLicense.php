<?php

namespace CodeLab\LicenseSystem\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Http;
use CodeLab\LicenseSystem\LicenseHelper;

class CheckLicense
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip check for license verification routes to avoid infinite loop
        if ($request->is('install/license*')) {
            return $next($request);
        }

        // Use config/env
        $licenseKey = config('license.license_key') ?? env('LICENSE_KEY');

        if (!$licenseKey) {
            return redirect()->route('license.show');
        }

        // REMOTE SECURITY CHECK - DIRECT CONNECTION
        $isValid = false;

        try {
            // Use Helper
            $ownerPanelUrl = LicenseHelper::getVerificationApiUrl();
            
            $response = Http::timeout(10)->post($ownerPanelUrl, [
                'license_key' => $licenseKey,
                'domain' => $request->getHost(),
            ]);

            if ($response->successful() && $response->json('valid') === true) {
                $isValid = true;
            }
        } catch (\Exception $e) {
            // If Burhan Labs Pvt. Ltd is down or unreachable, we BLOCK access for security.
            // This ensures unauthorized users cannot use the system if verification fails.
            $isValid = false;
        }

        if (!$isValid) {
            // Redirect to license page with error
            return redirect()->route('license.show')->withErrors(['license' => 'License verification failed. Your license may be invalid, expired, or used on another domain.']);
        }

        return $next($request);
    }
}
