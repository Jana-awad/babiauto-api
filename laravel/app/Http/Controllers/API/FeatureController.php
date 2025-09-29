<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feature;
use Illuminate\Support\Facades\Validator;
class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $features=Feature::all();
        return response()->json($features,200);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:features,name',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $feature = Feature::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Feature created successfully',
            'feature' => $feature
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $feature = Feature::find($id);
        if (!$feature) {
            return response()->json(['error' => 'Feature not found'], 404);
        }
        return response()->json($feature, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
          $feature = Feature::find($id);
        if (!$feature) {
            return response()->json(['error' => 'Feature not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:features,name,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $feature->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Feature updated successfully',
            'feature' => $feature
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $feature = Feature::find($id);
        if (!$feature) {
            return response()->json(['error' => 'Feature not found'], 404);
        }

        $feature->delete();

        return response()->json([
            'message' => 'Feature deleted successfully'
        ], 200);
    
    }
}
