<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Message;
use App\Models\Notification;
use App\Models\User;
use Validator;

class ChatController extends Controller
{
    public function getMessagesFor($senderId,$receiverId){
        // mark all messages with the selected contact as read
        $messages = Message::where(function($query) use ($senderId,$receiverId){
            $query->where('receiverId',$receiverId);
            $query->where('senderId',$senderId);
        })->orWhere(function($query) use ($senderId,$receiverId){
            $query->where('receiverId',$senderId);
            $query->where('senderId',$receiverId);
        })->with('channel')->get();
        return response()->json($messages,200);
    }

    public function send(Request $request){
        $rules = [
            'senderId' => "required",
            'receiverId' => 'required',
            'message' => 'required',
            'channelId' => 'required', 
            'file' => 'nullable'
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 200);
        }

        if($request->file != null){
            $file_name = time().'_'. rand(1000, 9999).$_FILES['file']['name'];
            $file_size =$_FILES['file']['size'];
            $file_tmp =$_FILES['file']['tmp_name'];
            $file_type=$_FILES['file']['type'];
            move_uploaded_file($file_tmp,public_path('upload/messaging/').$file_name);
        }else $file_name = '';

        $newMessage = Message::create([
            'senderId' => $request->senderId,
            'receiverId' => $request->receiverId,
            'message' => $request->message ,
            'channelId' => $request->channelId ,
            'image' => $file_name,
            'isRead' => false
        ]);

        $message = Message::where('id',$newMessage->id)->with('channel')->first();

       // to send new notification to receiver
       Notification::create([
           'receiverId' => $request->receiverId,
           'channelId' => $message->channel->id,
           'title' => " لديك رسالة جديدة من " . User::find($request->senderId)->name,
           'body' => $message->message,
       ]);
       // to send new notification to receiver using firebase
        try {
            $SERVER_API_KEY = 'AAAA9_ZfqQw:APA91bE6MQ2pTDTUCYCJCDvaYVK0dM7-1TIkphs3ZIpKBsDsqZrZ2RV3qxG0xXWRkcrGMvZhbKmn9ZyeXe7Arzg-QDrFlAn_xhQkW5GoulbH2PqBcJ6KXE3WJaTZ7nm0dSJgy1J8Z70o';
            $token_1 = User::find($request->receiverId)->notificationToken;
            $data = [
                "registration_ids" => [
                    $token_1
                ],
                "notification" => [
                    "title" => " لديك رسالة جديدة من " . User::find($request->senderId)->name,
                    "body" => $message->message,
                    "sound"=> "default"
                ],
                "data" => [
                    "channel" => $message->channel
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

        } catch (\Throwable $th) {
            print($th);
        }

        return response()->json([
            'data' => $message
        ], 201);
    }
}
