<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return response()->json(['users'=>User::with('role')->get()]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {

        return response()->json(['user'=>User::with('role')->whereIn($user)->get()]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
        
        $role = \Auth::user()->role()->first()->id;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'  . \Auth::id(),
            'role_id' => 'required|in:'. $role,
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        $request['password']=Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $response = User::find(\Auth::id())->update($request->toArray());

        $message = $response ? 'The user was updated successfully' : 'The user could not be updated';

        return response(['message'=>$message], 200);

    }

    public function promote($id)
    {
        $user = Auth::user();
        $role =  $user->role()->get()->first();

        if ($role->name == 'admin') {
            $response = User::find($id)->update(['role_id'=>1]);
            $message = $response ? 'The user was promoted successfully' : 'The user could not be promoted ';
            return response()->json(['message'=>$message],200);
        }
        return response()->json(['message'=>'You don\'t have the role that allows to upgrade users'],401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        
        $response = User::findOrFail($user)->delete();
        $message = $response ? 'The user was deleted successfully' : 'The user could not be deleted successfully';

        return response(['message'=>$message], 200);

    }
}
