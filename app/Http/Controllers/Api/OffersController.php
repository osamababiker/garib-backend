<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Offer;
use App\Models\Order;
use App\Models\Channel;
use App\Models\Notification;
use App\Models\User;
use Validator;

class OffersController extends Controller
{
    public function getOffers($userId){
        $offers = Offer::where('isDeleted',0)
            ->where('status',0)
            ->with('customer')->with('driver')->with('order')->get();
        return response()->json([
            'data' => $offers
        ], 200);
    }

    public function send(Request $request){
        $rules = [
            'customerId'=> 'required',
            'driverId'  => 'required',
            'orderId'   => 'required',
            'offer'     => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 200);
        }
        $offer = Offer::create([
            'customerId' => $request->customerId,
            'driverId' => $request->driverId,
            'orderId' => $request->orderId,
            'offer' => $request->offer,
        ]);
        $offer = Offer::where('id',$offer->id)
            ->with('customer')->with('driver')->first();
        return response()->json([
            'data' => $offer
        ], 201);
    }

    public function acceptOffer(Request $request){
        $rules = [
            'offerId'=> 'required',
            'status'=> 'required',
            'orderId' => 'required',
            'customerId' => 'required',
            'driverId' => 'required',
            'storeId' => 'required',
            'productPrice' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 200);
        }
        $offer = Offer::where('id',$request->offerId)->with('customer')->with('driver')->first();
        // to handel accept offer btn
        $offer->status = $request->status;
        // if the customer accept one offer we need to delete other offers
        Offer::where('id','<>',$offer->id)->where('orderId',$offer->order->id)->update([
            'isDeleted' => 1
        ]);

        // to create new channel
        $channel = Channel::create([
            'storeId' => $request->storeId,
            'orderId' => $request->orderId,
            'customerId' => $request->customerId,
            'driverId' => $request->driverId,
            'productPrice' => $request->productPrice,
            'hasBill' => 0,
            'hasCompleted' => 0,
            'confirmCompleted' => 0
        ]);
        // to update the order status
        /*
            order status
            0 => receiving offers
            1 => in progress
            2 => is done
            3 => is canceled
        */
        Order::where('id',$offer->order->id)->update([
            'status' => 1
        ]);

        $offer->save();

        // to send new notification to driver using firebase
        try {
            $SERVER_API_KEY = 'AAAA9_ZfqQw:APA91bE6MQ2pTDTUCYCJCDvaYVK0dM7-1TIkphs3ZIpKBsDsqZrZ2RV3qxG0xXWRkcrGMvZhbKmn9ZyeXe7Arzg-QDrFlAn_xhQkW5GoulbH2PqBcJ6KXE3WJaTZ7nm0dSJgy1J8Z70o';
            $customer = User::find($request->customerId);
            $driver = User::find($request->driverId);
            $token_1 = $driver->notificationToken;
            $data = [
                "registration_ids" => [
                    $token_1
                ],
                "notification" => [
                    "title" => " لقد تم قبول عرضك للتوصيل من قبل " . $customer->name,
                    "sound"=> "default"
                ],
                "data" => [
                    "channel" => $channel
                ]
            ];
            $dataString = json_encode($data);
            $headers = [
                'Authorization: key=' . $SERVER_API_KEY,
                'Content-Type: application/json',
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
            $response = curl_exec($ch);

            // to create new notification record
            Notification::create([
                'channelId' => $channel->id,
                'receiverId' => $driver->id,
                'title' => " لقد تم قبول عرضك للتوصيل من قبل " . $customer->name,
                'body' => 'بامكانك التواصل مع العميل الان لتسليم الطلب'
            ]);

        } catch (\Throwable $th) {
            print($th);
        }

        return response()->json([
            'data' => $channel
        ], 200);

    }


    public function rejectOffer(Request $request){
        $rules = [
            'offerId'=> 'required',
            'status'=> 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 200);
        }
        $offer = Offer::where('id',$request->offerId)->with('customer')->with('driver')->first();
        // to handel accept offer btn
        $offer->isDeleted = $request->status;
        $offer->isDeleted = 1;

        $offer->save();
        return response()->json([
            'data' => $offer
        ], 200);

    }

    public function delete($offerId){
        $offer = Offer::find($offerId);
        $offer->isDeleted = 1;
        return response()->json([
            'message' => 'offer has been deleted'
        ], 200);
    }

}
