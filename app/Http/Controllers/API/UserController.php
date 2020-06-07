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
        return User::paginate(10);
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
        $user->password = Hash::make($request['password']);
        

        $user->update(['name'     => $request['name'],
        'email'    => $request['email'],
        'role'     => $request['role'],
        'password' => Hash::make($request['password'])]);
    }

    
    public function destroy($id){
        $this->authorize('isAdmin');
        User::destroy([$id]);
        
    }

}
