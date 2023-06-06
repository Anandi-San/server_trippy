<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = product::with('type', 'user')->get();

    return response()->json([
        'message' => 'success',
        'data' => $products
    ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $datavalid = $request->validate([
        'name_product' => 'required|max:255',
        'types_id' => 'required',
        'user_id' => 'required',
        'description' => 'required'
    ]);

    $product = product::create($datavalid);

    if (auth()->user()->role_id == 15) {
        return response()->json([
            'message' => 'success',
            'redirect' => '/pengaturan_hotel_pesawat',
            'data' => $product
        ], 200);
    } elseif (auth()->user()->role_id == 14) {
        return response()->json([
            'message' => 'success',
            'redirect' => '/halaman_mitra',
            'data' => $product
        ], 200);
    }
}



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);

    if (!$product) {
        return response()->json([
            'message' => 'Product not found',
            'data' => null
        ], 404);
    }

    return response()->json([
        'message' => 'success',
        'data' => $product
    ], 200);
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
    $produk = product::find($id);

    $datavalid = $request->validate([
        'name_product' => 'required|max:255',
        'types_id' => 'required|numeric',
        'user_id' => 'required|numeric',
        'description' => 'required'
    ]);

    $produk->name_product = $datavalid['name_product'];
    $produk->description = $datavalid['description'];
    $produk->user_id = $datavalid['user_id'];
    $produk->types_id = $datavalid['types_id'];

    $produk->save();

    if (auth()->user()->role_id == 15) {
        return response()->json([
            'message' => 'success',
            'redirect' => '/pengaturan_hotel_pesawat',
            'data' => $produk
        ], 200);
    } elseif (auth()->user()->role_id == 14) {
        return response()->json([
            'message' => 'success',
            'redirect' => '/halaman_mitra',
            'data' => $produk
        ], 200);
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
    $produk = product::find($id);
    $produk->delete();

    if (auth()->user()->role_id == 15) {
        return response()->json([
            'message' => 'success',
            'redirect' => '/pengaturan_hotel_pesawat',
        ], 200);
    } elseif (auth()->user()->role_id == 14) {
        return response()->json([
            'message' => 'success',
            'redirect' => '/halaman_mitra',
        ], 200);
    }
}

}

