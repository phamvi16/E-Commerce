<?php

namespace App\Http\Controllers;

use App\User;
use App\Slider_model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckOutController extends Controller
{
    public function index(Request $request){
        $sliders = Slider_model::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();

        $countries=DB::table('countries')->get();
        $user_login=User::where('id',Auth::id())->first();
        $meta_desc = 'Thanh toán';
        $meta_title ='';
        $meta_keywords = "áo ,quần,đầm ,váy,quần jean,nón";
        $url_canonical = $request->url();
        return view('checkout.index',compact('sliders','countries','user_login','meta_desc','meta_title','meta_keywords','url_canonical'));
    }
    public function submitcheckout(Request $request){
       $this->validate($request,[
           'billing_name'=>'required',
           'billing_address'=>'required',
           'billing_city'=>'required',
           'billing_state'=>'required',
           'billing_pincode'=>'required',
           'billing_mobile'=>'required',
           'shipping_name'=>'required',
           'shipping_address'=>'required',
           'shipping_city'=>'required',
           'shipping_state'=>'required',
           'shipping_pincode'=>'required',
           'shipping_mobile'=>'required',
       ]);
        $input_data=$request->all();
       $count_shippingaddress=DB::table('delivery_address')->where('users_id',Auth::id())->count();
       if($count_shippingaddress==1){
           DB::table('delivery_address')->where('users_id',Auth::id())->update(['name'=>$input_data['shipping_name'],
               'address'=>$input_data['shipping_address'],
               'city'=>$input_data['shipping_city'],
               'state'=>$input_data['shipping_state'],
               'country'=>$input_data['shipping_country'],
               'pincode'=>$input_data['shipping_pincode'],
               'mobile'=>$input_data['shipping_mobile']]);
       }else{
            DB::table('delivery_address')->insert(['users_id'=>Auth::id(),
                'users_email'=>Session::get('frontSession'),
                'name'=>$input_data['shipping_name'],
                'address'=>$input_data['shipping_address'],
                'city'=>$input_data['shipping_city'],
                'state'=>$input_data['shipping_state'],
                'country'=>$input_data['shipping_country'],
                'pincode'=>$input_data['shipping_pincode'],
                'mobile'=>$input_data['shipping_mobile'],]);
       }
        DB::table('users')->where('id',Auth::id())->update(['name'=>$input_data['billing_name'],
            'address'=>$input_data['billing_address'],
            'city'=>$input_data['billing_city'],
            'state'=>$input_data['billing_state'],
            'country'=>$input_data['billing_country'],
            'pincode'=>$input_data['billing_pincode'],
            'mobile'=>$input_data['billing_mobile']]);
       return redirect('/order-review');

    }
}
