<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Plaint;
use Validator;


class PlaintController extends Controller
{
    public function send(Request $request){
        $rules = [
            'plaint' => "required",
            "userId" => "required"
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $plaint = Plaint::create([
            'plaint' => $request->plaint,
            'userId' => $request->userId
        ]);
        return response()->json([
            'data' => $plaint
        ], 200);
    }
}
