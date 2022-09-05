<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Store;
use App\Models\User;

class HomeController extends Controller
{
    public function index(){
        $orders_count = Order::count();
        $users_count = User::count();
        $stores_count = Store::count();
        return view('dashboard/index',compact(['orders_count','users_count','stores_count']));
    }
}
