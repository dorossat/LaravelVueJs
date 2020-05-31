<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
class ProfileController extends Controller
{
    
    public function index(){
        return auth('api')->user();
    }

    public function store(Request $request){}

    public function show($id){}

    
    public function update(Request $request, $id){
        $user = User::findOrFail($id);
        $currentPhoto = $user->photo;
        if($request->photo != $currentPhoto){
            $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
            Image::make($request->photo)->save(public_path('images/profile/').$name);
            $user->photo = $name; 
            //$request->merge(['photo' => $name]); // update the name
            $userPhoto = public_path('images/profile/').$currentPhoto;
            if(file_exists($userPhoto)){
                @unlink($userPhoto);
            }
        }

        if(!empty($request->password)){
            $request->merge(['password' => Hash::make($request['password'])]);
        }

        $user->update($request->all());
        return ['message' => 'Success ! '];
    }

    public function destroy($id){}
}
