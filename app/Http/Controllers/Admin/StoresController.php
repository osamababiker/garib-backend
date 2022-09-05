<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Store;

class StoresController extends Controller
{
    public $mapUri = "https://maps.googleapis.com/maps/api/geocode/json";
    public $mapKey = "AIzaSyAf437n2BxD-hg2NdOYrxvSn7ohQRFYelI";

    public function getForm(){
        $categories = Category::get();
        $key = $this->mapKey;
        return view('dashboard/stores/form',compact(['categories','key']));
    }

    public function postForm(Request $request){

        if($request->has('saveStoreBtn')){
            $this->validate($request,[
                'name' => 'required|string',
                'offer' => 'required',
                'categoryId' => 'required',
                'description' => 'required|string',
                'logo' => 'required|image',
                'rating' => 'required',
                'address' => 'required|string'
            ]);
            try {
                $response = Http::get("$this->mapUri?address=$request->address&key=$this->mapKey");
                $api_result = json_decode($response->getBody());
                $lng = $api_result->results[0]->geometry->location->lng;
                $lat = $api_result->results[0]->geometry->location->lat;
                if($request->has('logo')){
                    $image = $request->file('logo');
                    $image_name = time().'_'. rand(1000, 9999). '.' .$image->extension();
                    $image->move(public_path('upload/stores'),$image_name);
                }
                // to get category name so on the app we don't need to make another call
                $categoryName = Category::find($request->categoryId)->name;
                $store = Store::create([
                    'name' => $request->name,
                    'categoryId' => $request->categoryId,
                    'categoryName' => $categoryName,
                    'description' => $request->description,
                    'rating' => $request->rating,
                    'offer' => $request->offer,
                    'logo' => $image_name,
                    'lng' => $lng,
                    'lat' => $lat
                ]);
                session()->flash('storeCreated','تم انشاء المتجر بنجاح');
                return redirect()->back();
            } catch (\Throwable $e) {
                print(e);
                session()->flash('errors','حصلت مشكلة اثناء الاضافة , الرجاء المحاولة في وقت لاحق');
                return redirect()->back();
            }
        }

    }

    public function getTable(){
        $stores = Store::where('isDeleted',0)->get();
        $categories = Category::get();
        return view('dashboard/stores/table',compact(['stores','categories']));
    }

    public function postTable(Request $request){

        if($request->has('editStoreBtn')){
        
            $this->validate($request,[
                'name' => 'required|string',
                'offer' => 'required',
                'description' => 'required|string',
                'logo' => 'nullable',
                'rating' => 'required',
                'address' => 'nullable'
            ]);
           
            $store = Store::find($request->storeId);
            if($request->address != ''){
                try {
                    $response = Http::get("$this->mapUri?address=$request->address&key=$this->mapKey");
                    $api_result = json_decode($response->getBody());
                    $lng = $api_result->results[0]->geometry->location->lng;
                    $lat = $api_result->results[0]->geometry->location->lat;
                    $store->lng = $lng;
                    $store->lat = $lat;
                } catch (\Throwable $e) {
                    print($e);
                    session()->flash('errors','حصلت مشكلة في تحديد الموقع , الرجاء المحاولة في وقت لاحق');
                    return redirect()->back();
                }
            }
            if($request->has('logo')){
                if(file_exists(public_path('upload/stores/'.$store->logo))){
                    unlink(public_path('upload/stores/'.$store->logo));
                }
                $image = $request->file('logo');
                $image_name = time().'_'. rand(1000, 9999). '.' .$image->extension();
                $image->move(public_path('upload/stores'),$image_name);
                $store->logo = $image_name;
            }
            
            $store->name = $request->name;
            $store->offer = $request->offer;
            if($request->categoryId){
                $store->categoryId = $request->categoryId;
                // to get category name so on the app we don't need to make another call
                $categoryName = Category::find($request->categoryId)->name;
                $store->categoryName = $categoryName;
            }
            
            
            $store->rating = $request->rating;
            $store->description = $request->description;
            $store->save();
            session()->flash('storeUpdated','تم تحديث بيانات المتجر بنجاح');
            return redirect()->back();
        }

        if($request->has('deleteStoreBtn')){
            $store = Store::find($request->storeId);
            $store->isDeleted = 1;
            $store->save();
            session()->flash('storeDeleted','تم حذف  المتجر بنجاح');
            return redirect()->back();
        }
    }
}
