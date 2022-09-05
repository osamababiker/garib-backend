<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Http\Resources\api\storesResource;
use Validator;
use DB;
use App\Models\User;

class storesController extends Controller
{
    // to get all near stores
    public function getAll($lat,$lng,$distance){
        $stores = DB::select(DB::raw('SELECT *, ( 6371 * acos( cos( radians(' . $lat . ') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(' . $lng . ') ) + sin( radians(' . $lat .') ) * sin( radians(lat) ) ) ) AS distance FROM stores HAVING distance < ' . $distance . ' ORDER BY distance') );
        return response()->json(['data' => $stores],200);
    } 

    // to get stores by category id
    public function getByCategory($categoryId){
        $stores = Store::where('categoryId',$categoryId)
                ->where('isDeleted',0)->with('category')->get();
        return response()->json(['data' => $stores],200);
    }

    // to get store by id
    public function getById($id){
        $store = Store::where('id',$id)->where('isDeleted',0)
            ->with('category')->first();
        if($store == null){
            return response()->json(['message' => 'store not found'],404);
        }
        return response()->json(['data' => $store],200);
    }

    // search stores by name
    public function getByName($query){
        $stores = Store::search($query)
            ->where('isDeleted',0)->with('category')->get();
        return response()->json(['data' => $stores],200);
    }


}
