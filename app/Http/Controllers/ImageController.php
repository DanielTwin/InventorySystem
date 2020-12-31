<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use App\Models\Product;


class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['images'=>Product::find($product_id)->images()->get()]);
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
            'product_id'=>'required|exists:products,id',
            'main'=>'required|boolean|in:0',
            'name' => 'required|max:10000|mimes:png,jpg,jpeg',
        ]);

        $storage = request()->file('name')->store('products','s3');

        $response = Image::create([
            'product_id'=>$request->input('product_id'),
            'main'=>$request->input('main'),
            'name'=>$storage
        ]);

        $message = $response ? 'The Image was uploaded successfully' : 'the image could not be uploaded';

        return response(['message'=>$message],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(['images'=>Image::with('product')->whereIn('id',[$id])->get()]);
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
        $Image = Image::find($id);
        $product_id = $Image->product()->get()->first()->id;
        $main = $Image->main;

        $this->validate($request,[
            'main'=>'required|boolean|in:' . $main,
            'name' => 'required|max:10000|mimes:png,jpg,jpeg',
        ]);

        $storage = request()->file('name')->store('products','s3');

        $response = Image::find($id)->update([
            'product_id'=>$product_id,
            'main'=>$request->input('main'),
            'name'=>$storage
        ]);

        $message = $response ? 'The Image was updated successfully' : 'the image could not be updated';

        return response(['message'=>$message],201);
    }


    // public function promote($id)
    // {
    //     $ImageMain = Image::where('main',1)->get()->first();
    //     if ($ImageMain != null) { $ImageMain->update(['main'=>0]); }

    //     $Image = Image::find($id);
    //     $response = Image::find($id)->update(['main'=>1]);

    //     $message = $response ? 'The Image was promoted successfully' : 'the image could not be promoted';

    //     return response(['message'=>$message],201);
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = Image::findOrFail($id)->delete();
        $message = $response ? 'The Image was deleted successfully' : 'The Image could not be deleted successfully';

        return response(['message'=>$message], 200);
    }
}
