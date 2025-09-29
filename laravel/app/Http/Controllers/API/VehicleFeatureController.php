<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Feature;

class VehicleFeatureController extends Controller
{
    // List features of a vehicle
    public function index($vehicleId)
    {
        $vehicle = Vehicle::with('features')->findOrFail($vehicleId);
        return response()->json($vehicle->features, 200);
    }

    // Attach feature(s) to a vehicle
    public function attach(Request $request, $vehicleId)
    {
        $request->validate([
            'feature_ids' => 'required|array',
            'feature_ids.*' => 'exists:features,id',
        ]);

        $vehicle = Vehicle::findOrFail($vehicleId);
        $vehicle->features()->attach($request->feature_ids);

        return response()->json(['message' => 'Features attached successfully']);
    }

    // Detach feature(s) from a vehicle
    public function detach(Request $request, $vehicleId)
    {
        $request->validate([
            'feature_ids' => 'required|array',
            'feature_ids.*' => 'exists:features,id',
        ]);

        $vehicle = Vehicle::findOrFail($vehicleId);
        $vehicle->features()->detach($request->feature_ids);

        return response()->json(['message' => 'Features detached successfully']);
    }

    // Sync (replace all vehicle features)
    public function sync(Request $request, $vehicleId)
    {
        $request->validate([
            'feature_ids' => 'required|array',
            'feature_ids.*' => 'exists:features,id',
        ]);

        $vehicle = Vehicle::findOrFail($vehicleId);
        $vehicle->features()->sync($request->feature_ids);

        return response()->json(['message' => 'Features synced successfully']);
    }
}
