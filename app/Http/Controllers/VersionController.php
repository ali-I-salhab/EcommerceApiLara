<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VersionController extends Controller
{
    public function checkVersion(Request $request)
    {
        // Get the app version details
        $currentVersion = config('app_version.current_version');
        $latestVersion = config('app_version.latest_version');

        // Compare current version with the latest version
        $isUpdateAvailable = version_compare($currentVersion, $latestVersion, '<');

        return response()->json([
            'current_version' => $currentVersion,
            'latest_version' => $latestVersion,
            'is_update_available' => $isUpdateAvailable,
            'update_message' => $isUpdateAvailable ? 'A new version is available. Please update your app.' : 'Your app is up to date.',
        ]);
    }
}
