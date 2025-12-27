<?php

namespace CodeLab\LicenseSystem\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use CodeLab\LicenseSystem\LicenseHelper;

class LicenseVerificationController extends Controller
{
    public function show()
    {
        $serverUrl = LicenseHelper::getOwnerPanelUrl();
        return view('license-system::license', compact('serverUrl'));
    }

    public function verify(Request $request)
    {
        $request->validate([
            'license_key' => 'required',
        ]);

        $licenseKey = $request->license_key;
        $domain = $request->getHost();
        
        // Call OwnerPanel API using Helper
        $ownerPanelUrl = LicenseHelper::getVerificationApiUrl();
        
        try {
            $response = Http::post($ownerPanelUrl, [
                'license_key' => $licenseKey,
                'domain' => $domain,
            ]);

            if ($response->failed() || !$response->json('valid')) {
                return back()->withErrors(['license_key' => $response->json('message') ?? 'Invalid License Key']);
            }

            // Save to .env
            $this->updateEnvFile('LICENSE_KEY', $licenseKey);

            return redirect('/')->with('success', 'License Verified Successfully!');

        } catch (\Exception $e) {
            return back()->withErrors(['license_key' => 'Connection to licensing server failed. Please check your internet connection or contact support.']);
        }
    }

    private function updateEnvFile($key, $value)
    {
        $path = base_path('.env');

        if (File::exists($path)) {
            $content = File::get($path);
            
            if (strpos($content, "{$key}=") === false) {
                File::append($path, "\n{$key}={$value}\n");
            } else {
                File::put($path, preg_replace(
                    "/^{$key}=.*/m",
                    "{$key}={$value}",
                    $content
                ));
            }
        }
    }
}
