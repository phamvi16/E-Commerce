<?php

namespace App\Http\Controllers;

use App\Cart_model;
use App\Orders_model;
use App\Slider_model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrdersController extends Controller
{
    public function index(Request $request){
        $session_id=Session::get('session_id');
        $cart_datas=Cart_model::where('session_id',$session_id)->get();
        $sliders = Slider_model::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();

        $total_price=0;
        foreach ($cart_datas as $cart_data){
            $total_price+=$cart_data->price*$cart_data->quantity;
        }
        $shipping_address=DB::table('delivery_address')->where('users_id',Auth::id())->first();
        $meta_desc = 'Order Review';
        $meta_title ='';
        $meta_keywords = "áo ,quần,đầm ,váy,quần jean,nón";
        $url_canonical = $request->url();
        return view('checkout.review_order',compact('sliders','shipping_address','cart_datas','total_price','meta_desc','meta_title','meta_keywords','url_canonical'));
    }
    public function order(Request $request){
        $input_data=$request->all();
        $payment_method=$input_data['payment_method'];
        Orders_model::create($input_data);
        if($payment_method=="COD"){
            return redirect('/cod');
        }else{
            return redirect('/paypal');
        }
    }
    public function cod(Request $request){
        $user_order=Orders_model::where('users_id',Auth::id())->first();
        $sliders = Slider_model::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();

        $meta_desc = 'COD';
        $meta_title ='';
        $meta_keywords = "áo ,quần,đầm ,váy,quần jean,nón";
        $url_canonical = $request->url();
        return view('payment.cod',compact('sliders','user_order','meta_desc','meta_title','meta_keywords','url_canonical'));
    }
    public function paypal(Request $request){
        $who_buying=Orders_model::where('users_id',Auth::id())->first();
        $sliders = Slider_model::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();

        $meta_desc = 'Paypal';
        $meta_title ='';
        $meta_keywords = "áo ,quần,đầm ,váy,quần jean,nón";
        $url_canonical = $request->url();
        return view('payment.paypal',compact('sliders','who_buying','meta_desc','meta_title','meta_keywords','url_canonical'));
    }
}
