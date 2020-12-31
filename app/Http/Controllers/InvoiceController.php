<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Product;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['invoices'=>Invoice::with('products','user')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'user_id' => 'required|exists:users,id'
        ]);

        $response = Invoice::create(['user_id'=>$request->input('user_id')]);

        if ($response) {

            $products = $request->input('product');

            foreach ($products as $product_id) {
                if (!Product::find($product_id)) {
                    return response(['message'=>'the product id dont exists']);
                }
            }
            foreach ($products as $product_id) {

                Invoice::find($response->id)->products()->attach($product_id);
            }
        }
        else{
            return response(['message'=>'the invoice could not be created']);
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
        return response()->json(['invoices'=>Invoice::with('products','user')->whereIn('id',[$id])->get()]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
