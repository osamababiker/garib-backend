<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Channel;
use App\Models\Setting;
use Validator;

class OrdersController extends Controller
{

    /*
        order status
        0 => receiving offers
        1 => in progress
        2 => is done
        3 => is canceled
    */

    public function getOrders($userId){
        $orders = Order::where('isDeleted',0)->where('userId',$userId)
            ->with('user')->with('store')->with('offers')->get();
        return response()->json(['data' => $orders],200);
    }

    public function getAllOrders($userId){
        $orders = Order::where('isDeleted',0)->where('status',0)
            ->where('userId','<>',$userId)
            ->with('user')->with('store')->with('offers')->get();
        return response()->json(['data' => $orders],200);
    }

    public function getSingleOrder($orderId){
        $order = Order::where('id',$orderId)->where('isDeleted',0)
            ->with('user')->with('store')->with('offers')->first();
        return response()->json(['data' => $order],200);
    }

    public function store(Request $request){
        $rules = [
            'userId'       => 'required',
            'storeId'      => 'required',
            'order'        => 'required',
            'storeLat'     => 'required',
            'storeLng'     => 'required',
            'customerLat'  => 'required',
            'customerLng'  => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 200);
        }

        $info = Setting::first();
        $distance = floatval($request->distance);
        $max_price = $info->max_price_for_k * $distance;
        $min_price = $info->min_price_for_k * $distance;
        
        $order = Order::create([
            'userId' => $request->userId,
            'storeId' => $request->storeId,
            'order' => $request->order,
            'storeLat' => $request->storeLat,
            'storeLng' => $request->storeLng,
            'customerLat' => $request->customerLat,
            'customerLng' => $request->customerLng,
            'max_price' => $max_price,
            'min_price' => $min_price
        ]);

        $order = Order::where('id',$order->id)
            ->with('user')->with('store')->with('offers')->first();

        return response()->json([
            'data' => $order
        ], 201);
    }

    public function deleteOrder($orderId){
        $order = Order::find($orderId);
        if(!$order){
            return response()->json(['message' => 'no order match this id'], 404);
        }
        $order->isDeleted = 1;
        $order->save();
        return response()->json(['message' => 'order has been deleted'],200);
    }

    public function updateOrder(Request $request){
        $order = Order::find($request->orderId);
        $channel = Channel::find($request->channelId);

        $order->status = $request->status;
        $order->save();

        $channel->hasCompleted = 1;
        if($request->confirmCompleted){
            $channel->confirmCompleted = 1;
        }
        $channel->save();
        return response()->json(['message' => 'order has been updated'],200);
    }
}
