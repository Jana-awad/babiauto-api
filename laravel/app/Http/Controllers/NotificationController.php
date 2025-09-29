<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeviceToken;

class NotificationController extends Controller
{
    public function saveDeviceToken(Request $request)
    {
        $request->validate(['token' => 'required|string']);

        DeviceToken::updateOrCreate(
            ['user_id' => auth()->id()],
            ['token' => $request->token]
        );

        return response()->json(['message' => 'Token saved successfully']);
    }
}
