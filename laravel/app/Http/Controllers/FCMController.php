<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class FCMController extends Controller
{
    public function saveDeviceToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $user = $request->user();
        $user->fcm_token = $request->token;
        $user->save();

        return response()->json(['message' => 'Device token saved successfully']);
    }
}
