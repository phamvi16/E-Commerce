<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category_model;
use App\Products_model;

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
        $keywords = $request->keywords_submit;

        $all_category = Category_model::All();
        $search_product = Products_model::where('p_name', 'like', '%' .$keywords. '%')->get();

        return view('frontEnd.search')->with('search_product',$search_product)->with('all_category', $all_category);

   }
}
