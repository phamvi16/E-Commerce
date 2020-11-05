<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category_model;
use App\Products_model;
use App\Slider_model;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    public function search(Request $request){
        $sliders = Slider_model::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();

        $meta_desc = 'Tìm kiếm';
        $meta_title ='';
        $meta_keywords = "áo ,quần,đầm ,váy,quần jean,nón";
        $url_canonical = $request->url();
        $keywords = $request->keywords_submit;

        $all_category = Category_model::All();
        $search_product = Products_model::where('p_name', 'like', '%' .$keywords. '%')->get();

        return view('frontEnd.search',compact('search_product','sliders','all_category','meta_desc','meta_title','meta_keywords','url_canonical'));

   }
}
