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
        //$user = auth('api')->user();
        $currentPhoto = $user->photo;


        if($request->photo != $currentPhoto){
            $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];

            Image::make($request->photo)->save(public_path('images/').$name);
            $request->merge(['photo' => $name]);
            $request->photo = $name;

            $userPhoto = public_path('images/').$currentPhoto;
            if(file_exists($userPhoto)){
                @unlink($userPhoto);
            }

        }


        if(!empty($request->password)){
            $request->merge(['password' => Hash::make($request['password'])]);
        }


        $user->update($request->all());
        return ['message' => $request->photo];
    }

    public function destroy($id){}
}
