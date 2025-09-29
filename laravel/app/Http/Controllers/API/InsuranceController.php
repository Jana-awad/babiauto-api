<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Insurance;
use Illuminate\Support\Facades\Validator;
class InsuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Insurance::all(),200);
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
            'booking_id' => 'required|exists:bookings,id',
            'type' => 'required|string|in:basic,premium,full',
            'coverage' => 'required|numeric',
            'status' => 'required|string|in:active,cancelled,expired',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $insurance = Insurance::create($request->all());

        return response()->json([
            'message' => 'Insurance created successfully',
            'insurance' => $insurance
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
         $insurance = Insurance::findOrFail($id);
        return response()->json($insurance);
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
    $insurance = Insurance::findOrFail($id);

    $validator = Validator::make($request->all(), [
        'booking_id' => 'sometimes|exists:bookings,id',
        'type' => 'sometimes|string|in:basic,premium,full',
        'coverage' => 'sometimes|numeric',
        'status' => 'sometimes|string|in:active,cancelled,expired',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $insurance->update($request->all());

    return response()->json([
        'message' => 'Insurance updated successfully',
        'insurance' => $insurance
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
         $insurance = Insurance::findOrFail($id);
        $insurance->delete();

        return response()->json([
            'message' => 'Insurance deleted successfully'
        ]);
    }
}
