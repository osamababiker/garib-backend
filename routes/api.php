<?php

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrdersController;
use App\Http\Controllers\Api\StoresController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\OffersController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\BillController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\DriversController;
use App\Http\Controllers\Api\PlaintController;
use App\Http\Controllers\Api\SettingsController;
use Illuminate\Support\Facades\Hash;

// Routes for auth users only
Route::middleware('auth:sanctum')->group(function () {
    // Route to get user
    Route::get('/user', [AuthController::class, 'user']);
    // Route to update user info
    Route::post('/user/update', [AuthController::class, 'update']);
    // Route to change user password
    Route::post('/user/changePassword', [AuthController::class, 'updatePassword']);
    // Route to log user out
    Route::get('/user/revoke', function (Request $request) {
        $user =  $request->user();
        $user->tokens()->delete();
        return 'token are deleted';
    });
    // Route to get all orders
    Route::get('/orders/all/{userId}', [OrdersController::class, 'getAllOrders']);
    // Route to get user all orders
    Route::get('/orders/{userId}', [OrdersController::class, 'getOrders']);
    // Route to get single order
    Route::get('/orders/single/{orderId}', [OrdersController::class, 'getSingleOrder']);
    // Route to create new order
    Route::post('/orders/send', [OrdersController::class, 'store']);
    // Route to delete user order
    Route::get('/orders/delete/{orderId}', [OrdersController::class, 'deleteOrder']);
    // Route to update order status
    Route::post('/order/update', [OrdersController::class, 'updateOrder']);
    // Route to get user chat messages
    Route::get('/chat/messages/{senderId}/{receiverId}',[ChatController::class, 'getMessagesFor']);
    // Route to send new message
    Route::post('/chat/messages/send',[ChatController::class, 'send']);
    // Route to fetch user notification
    Route::get('/notifications/{receiverId}',[NotificationController::class, 'getNotifications']);
    // Route to delete notification
    Route::get('/notifications/getCount/{receiverId}',[NotificationController::class, 'getCount']);
    // Route to get notification count
    Route::get('/notifications/delete/{notificationId}',[NotificationController::class, 'deleteNotification']);
    // Route to fetch single bill
    Route::get('/bills/{channelId}',[BillController::class, 'getBill']);
    // Route to send new bill
    Route::post('/bill/send',[BillController::class, 'sendBill']);
    // Route to fetch user rating
    Route::get('/evaluation/{userId}',[RatingController::class, 'getUserRating']);
    // Route to make new rating
    Route::post('/evaluation/save',[RatingController::class, 'saveRating']);
    // Route to get offers for user
    Route::get('/offers/{userId}',[OffersController::class, 'getOffers']);
    // Route to delete offer
    Route::get('/offers/delete/{offerId}',[OffersController::class, 'delete']);
    // Route to accept  offer
    Route::post('/offers/accept',[OffersController::class, 'acceptOffer']);
    // Route to  reject offer
    Route::post('/offers/reject',[OffersController::class, 'rejectOffer']);
    // Route to send new offer
    Route::post('/offers/send',[OffersController::class, 'send']);
    // Route to register new driver
    Route::post('/drivers/register',[DriversController::class, 'register']);
    // Route to send new plaint
    Route::post('/plaint/send',[PlaintController::class, 'send']);
});

// Route to get app info
Route::get('/settings',[SettingsController::class, 'getInfo']);

// Route to get token
Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'phone' => 'required',
        'password' => 'required',
        'device_name' => 'required',
    ]);
    $user = User::where('phone', $request->phone)->first();
    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }
    return $user->createToken($request->device_name)->plainTextToken;
});

// Route to login user in
Route::post('/login', [AuthController::class, 'login']);
// Route to register new user
Route::post('/register', [AuthController::class, 'register']);
// Route to verify user phone
Route::post('/otp/verify', [AuthController::class, 'verifyUser']);
// Route to resend otp code
Route::post('/otp/resend', [AuthController::class, 'resendOtp']);
// Route to reset the password (send the confirmation code)
Route::post('/user/resetPassword', [AuthController::class, 'resetPassword']);
// Route to reset the password (confirm the phone and update the password)
Route::post('/user/confirmPhone/resetPassword', [AuthController::class, 'confirmPhoneToResetPassword']);


// Route to get all stores
Route::get('/stores/{lat}/{lng}/{distance}', [StoresController::class, 'getAll']);

// Route to get store by id
Route::get('/stores/{id}', [StoresController::class, 'getById']);

// Route for searching stores by name
Route::get('/stores/search/{query}', [StoresController::class, 'getByName']);

// Route for searching stores by category
Route::get('/stores/categories/{categoryId}', [StoresController::class, 'getByCategory']);

// Route to get all categories
Route::get('/categories', [CategoriesController::class, 'getAll']);



