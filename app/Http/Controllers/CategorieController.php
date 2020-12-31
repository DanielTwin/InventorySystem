<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return response()->json(['categories'=>Categorie::all()]);

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
            'name'=>'required|string|min:3'
        ]);

        $response = Categorie::create($request->all());
        $message = $response ? 'The categorie was created successfully' : 'The categorie could not be created';
        return response(['message'=>$message], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        return response()->json(['categories'=>Categorie::find($id)]);

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
        $this->validate($request,[
            'name'=>'required|string|min:3'
        ]);

        $response = Categorie::find($id)->update($request->all());
        $message = $response ? 'The categorie was updated successfully' : 'The categorie could not be updated';
        return response(['message'=>$message], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = Categorie::findOrFail($id)->delete();
        $message = $response ? 'The categorie was deleted successfully' : 'The categorie could not be deleted successfully';

        return response(['message'=>$message], 200);
    }
}
