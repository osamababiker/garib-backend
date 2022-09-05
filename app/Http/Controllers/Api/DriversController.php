<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Driver;
use Validator;

class DriversController extends Controller
{
    public function register(Request $request){
        $rules = [
            'userId' => "required",
            'name' => "required|string",
            'phone' => 'required',
            'address' => 'required',
            'transportType' => 'required',
            'licenseImage' => 'required',
            'transportImage' => 'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 200);
        }

        if($request->licenseImage != null){
            $licenseImage = time().'_'. rand(1000, 9999).$_FILES['licenseImage']['name'];
            $file_size =$_FILES['licenseImage']['size'];
            $file_tmp =$_FILES['licenseImage']['tmp_name'];
            $file_type=$_FILES['licenseImage']['type'];
            move_uploaded_file($file_tmp,public_path('upload/drivers/license/').$licenseImage);
        }

        if($request->transportImage != null){
            $transportImage = time().'_'. rand(1000, 9999).$_FILES['transportImage']['name'];
            $file_size =$_FILES['transportImage']['size'];
            $file_tmp =$_FILES['transportImage']['tmp_name'];
            $file_type=$_FILES['transportImage']['type'];
            move_uploaded_file($file_tmp,public_path('upload/drivers/transport/').$transportImage);
        }

        $driver = Driver::create([
            "userId" => $request->userId,
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'transportType' => $request->transportType,
            'licenseImage' => $licenseImage,
            'transportImage' => $transportImage,
        ]);

        return response()->json([
            'data' => $driver
        ], 201);
    }
}
