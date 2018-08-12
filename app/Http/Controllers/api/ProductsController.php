<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Products;
use Illuminate\Support\Facades\Log;
use Validator;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Products::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
   
    try {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric|min:0'
        ]);
        if($validator->fails()){
            return response()->json(['code' => 500, 'message' => $validator->errors()]);
        }

        $product = app(Products::class)->create($request->all());
        Log::info('- Product saved');
        return response()->json(['code' => 200, 'message' => 'Succesfully Saved']);
    
    } catch (Exception $e) {
        Log::error('- ERROR' . $e->getMessage());
        return response()->json(['code' => 403, 'message' => 'Something went wrong']);
    }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $product = app(Products::class)->findOrFail($id);
            return response()->json($product);

        } catch (Exception $e) {
        Log::error('- ERROR' . $e->getMessage());
        return response()->json(['code' => 403, 'message' => 'Something went wrong']);
        }

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
        try{
            $product = app(Products::class)->findOrFail($id);
            $product->update($request->all());
            Log::info('- Product updated');
           return response()->json(['code' => 200, 'message' => 'Succesfully Updated']);

        } catch (Exception $e) {
            Log::error('- ERROR' . $e->getMessage());
        return response()->json(['code' => 403, 'message' => 'Something went wrong']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $product = app(Products::class)->findOrFail($id);
            $product->delete();
            Log::info('- Product deleted');
           return response()->json(['code' => 200, 'message' => 'Succesfully deleted']);

        } catch (Exception $e) {
            Log::error('- ERROR' . $e->getMessage());
        return response()->json(['code' => 403, 'message' => 'Something went wrong']);
        }
    }
}
