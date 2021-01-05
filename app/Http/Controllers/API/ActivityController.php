<?php

namespace App\Http\Controllers\API;

use App\Activity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    
    public function index(){
        //
    }

    public function store(Request $request){
        //
    }

    public function show($id){
        return Activity::where("user_id" , "=" ,$id)->get();
    }

    public function update(Request $request, $id){
        //
    }

    public function destroy($id){
        Activity::destroy([$id]);
    }
}
