<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    //List all vehicles
    public function index()
    {
        $vehicles = Vehicle::all();
        return response()->json($vehicles);
    }
    //Show a specific vehicle
    public function show($id)
    {
        $vehicle = Vehicle::find($id);
        if (!$vehicle) {
            return response()->json(['error' => 'Vehicle not found'], 404);
        }
        return response()->json($vehicle);
    }
    //Create a new vehicle
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'type' => 'required|string|max:255',
            'price_per_day' => 'required|numeric|min:0',
            'status' => 'required|string|in:available,rented,maintenance',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('public/vehicle_images');
            $imageUrl = Storage::url($path);
        } else {
            $imageUrl = null;
        }
        $vehicle = Vehicle::create([
            'make' => $request->make,
            'model' => $request->model,
            'year' => $request->year,
            'type' => $request->type,
            'price_per_day' => $request->price_per_day,
            'status' => $request->status ?? 'available',
            'image_url' => $request->image_url ?? $imageUrl,
            //  'features' => $request->features ?? [],
        ]);
        // if ($request->has('features')) {
        //     $vehicle->features()->sync($request->features);
        // }
        return response()->json([
            'message' => 'Vehicle created successfully',
            'vehicle' => $vehicle
        ], 201);
    }
    //Update a vehicle
    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::find($id);
        if (!$vehicle) {
            return response()->json(['error' => 'Vehicle not found'], 404);
        }
        $validator = Validator::make($request->all(), [
            'make' => 'sometimes|required|string|max:255',
            'model' => 'sometimes|required|string|max:255',
            'year' => 'sometimes|required|integer|min:1900|max:' . (date('Y') + 1),
            'type' => 'sometimes|required|string|max:255',
            'price_per_day' => 'sometimes|required|numeric|min:0',
            'status' => 'sometimes|required|string|in:available,rented,maintenance',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $vehicle->update($request->only([
            'make',
            'model',
            'year',
            'type',
            'price_per_day',
            'status',
        ]));
        return response()->json([
            'message' => 'Vehicle updated successfully',
            'vehicle' => $vehicle
        ]);
    }
    //Delete a vehicle
    public function destroy($id)
    {

        $vehicle = Vehicle::find($id);
        if (!$vehicle) {
            return response()->json(['error' => 'Vehicle not found'], 404);
        }
        $vehicle->delete();
        return response()->json([
            'message' => 'Vehicle deleted successfully'
        ]);
    }
}
