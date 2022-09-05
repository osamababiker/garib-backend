<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator; 
use App\Models\Bill;
use App\Models\Channel;

class BillController extends Controller
{
    public function getBill($channelId){
        $bill = Bill::where('channelId',$channelId)->with('channel')->first();
        return response()->json([
            'data' => $bill
        ], 200);
    }

    public function sendBill(Request $request){
        $rules = [
            'cost' => "required",
            'channelId' => 'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 200);
        }

        $bill = Bill::create([
            'cost' => $request->cost,
            'channelId' => $request->channelId
        ]);

        Channel::where('id',$request->channelId)->update([
            'hasBill' => 1
        ]); 

        $bill = Bill::where('id',$bill->id)->with('channel')->first();

        return response()->json([
            'data' => $bill
        ], 200);
    }
}
