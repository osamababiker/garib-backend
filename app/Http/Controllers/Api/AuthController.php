<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;

class AuthController extends Controller
{
    public $smsUrl = "https://smss.nilogy.com/app/gateway/gateway.php";
    public $username = "gareebapi";
    public $password = "gareeb@api**";

    public function register(Request $request){
        $rules = [
            'name'      => 'required|string',
            'email'     => 'required|email|unique:users',
            'phone'     => 'required|unique:users',
            'address'   => 'required|string',
            'lng'       => 'required',
            'lat'       => 'required',
            'password'  => 'required|confirmed',
            'notificationToken'       => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 200);
        }
        $digits = mt_rand(1000,9999);
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'address'   => $request->address,
            'lng'       => $request->lng,
            'lat'       => $request->lat,
            'password'  => bcrypt($request->password),
            'notificationToken' => $request->notificationToken,
            'verification_code' => $digits
        ]);
        $text = "رمز التأكيد من تطبيق قريب \n $digits";
        $response = Http::get("$this->smsUrl?sendmessage=1&username=$this->username&password=$this->password&text=$text&numbers=$user->phone&sender=GAREEB");
        $api_result = json_decode($response->getBody());

        $user = User::find($user->id);
        return response()->json([
            'errors' => '',
            'user' => $user
        ], 200);

    }

    public function verifyUser(Request $request){
        $user = User::find($request->userId);
        if($request->verification_code == $user->verification_code){
            $user->verification_code = null;
            $user->isVerify = true;
            $user->save();
            $token = $user->createToken($request->device_name)->plainTextToken;
            return response()->json([
                'token' => $token
            ], 200);
        }
        return response()->json([
            'token' => ''
        ], 404);
    }

    public function resendOtp(Request $request){
        $digits = mt_rand(1000,9999);
        $user = User::find($request->userId);
        $user->verification_code = $digits;
        $user->save();
        try {
            $text = "رمز التأكيد من تطبيق قريب \n $digits";
            $response = Http::get("$this->smsUrl?sendmessage=1&username=$this->username&password=$this->password&text=$text&numbers=$user->phone&sender=GAREEB");
            $api_result = json_decode($response->getBody());
            return  response()->json([
                'message' => json_decode($response->getBody())
            ], 200);
        } catch (\Throwable $th) {
            print($th);
        }
        return  response()->json([
            'message' => 'message sent',
        ], 200);
    }


    public function resetPassword(Request $request){

        $user = User::where('phone',$request->phone)->first();

        if($user){
            $digits = mt_rand(1000,9999);
            $user->password_reset_code = $digits;
            $user->save();

            try {
                // send reset password code via sms
                $text = "رمز استعادة كلمة المرور من قريب \n $digits";
                $response = Http::get("$this->smsUrl?sendmessage=1&username=$this->username&password=$this->password&text=$text&numbers=$user->phone&sender=GAREEB");
            } catch (\Throwable $th) {
                print($th);
            }

            return response()->json([
                'user' => $user
            ], 200);
        }
    }

    public function confirmPhoneToResetPassword(Request $request){
        $user = User::find($request->userId);
        if($user->password_reset_code == $request->confirmationCode){
            $user->password = Hash::make($request->password);
            $user->password_reset_code = null;
            $user->save();
            return response()->json([
                'data' => $user
            ],200);
        }
        return response()->json([
            'data' => $user
        ],400);
    }

    public function login(Request $request){
        $rules = [
            'phone' => "required",
            'password' => 'required',
            'device_name' => 'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 200);
        }
        $user = User::where('phone', $request->phone)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return $user->createToken($request->device_name)->plainTextToken;
    }

    public function update(Request $request){
        $rules = [
            'name' => "required|string",
            'phone' => 'required',
            'address' => 'required|string'
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 200);
        }
        $user = User::find($request->userId);
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();

        $user = User::where('id',$user->id)->first();
        return response()->json([
            'user'   => $user,
        ], 200);
    }

    public function updatePassword(Request $request){
        $rules = [
            'password' => "required",
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 200);
        }
        $user = User::find($request->userId);
        $user->password = bcrypt($request->password);
        $user->save();

        $user = User::where('id',$user->id)->first();
        return response()->json([
            'user'   => $user,
        ], 200);
    }

    public function user(Request $request){
        $userId = auth()->user()->id;
        return User::where('id',$userId)->first();
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
