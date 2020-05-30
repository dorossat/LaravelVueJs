<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api');
    }

   
    public function index(){
        $user = new User();
        return $user::all();
    }

   
    public function store(UserRequest $request){
       
        return User::create([
            'name'     => $request['name'],
            'email'    => $request['email'],
            'role'     => $request['role'],
            'password' => Hash::make($request['password'])
        ]);
    }
    
    public function update(Request $request, $id){
        $user = User::findOrFail($id);

        $this->validate($request, [
            'name'     => 'required|string|max:20',
            'email'    =>  'required|unique:users,email,'.$user->id,
            'role'     => 'required',
            'password' => 'sometimes|string|min:8'
        ]);
        

        $user->update($request->all());
    }

    
    public function destroy($id){
        User::destroy([$id]);
        
    }

}
