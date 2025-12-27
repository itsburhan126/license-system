<?php

use Illuminate\Support\Facades\Route;
use CodeLab\LicenseSystem\Http\Controllers\LicenseVerificationController;

Route::group(['middleware' => ['web']], function () {
    Route::get('/install/license', [LicenseVerificationController::class, 'show'])->name('license.show');
    Route::post('/install/license', [LicenseVerificationController::class, 'verify'])->name('license.verify');
});
