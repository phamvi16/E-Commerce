<?php

namespace App\Http\Controllers;
use Session;
use App\Category_model;
use App\ImageGallery_model;
use App\ProductAtrr_model;
use App\Products_model;
use Illuminate\Http\Request;
session_start();

class IndexController extends Controller
{
    public function index(Request $request){
        $products=Products_model::all();
        $meta_desc="Mieu shop";
        $meta_title ='';
        $meta_keywords = "áo ,quần,đầm ,váy,quần jean,nón";
        $url_canonical = $request->url();

        return view('frontEnd.index',compact('products','meta_desc','meta_title','meta_keywords','url_canonical'));
    }
    public function shop(Request $request){
        $products=Products_model::all();
        $byCate="";

        $meta_desc = 'Mieu shop';
        $meta_title ='';
        $meta_keywords = "áo ,quần,đầm ,váy,quần jean,nón";
        $url_canonical = $request->url();
        return view('frontEnd.products',compact('products','byCate','meta_desc','meta_title','meta_keywords','url_canonical'));
    }
    public function listByCat(Request $request,$id){

        $list_product=Products_model::where('categories_id',$id)->get();
        $byCate=Category_model::select('name')->where('id',$id)->first();
        foreach($list_product as $key => $value){
            $meta_desc = $value->description;
            $meta_title =' | '. $value->p_name;
            $meta_keywords = "áo ,quần,đầm ,váy,quần jean,nón";
            $url_canonical = $request->url();
        }
        return view('frontEnd.products',compact('list_product','byCate','meta_desc','meta_title','meta_keywords','url_canonical'));
    }
    // public function detialpro(Request $request,$id){

    //     $detail_product=Products_model::findOrFail($id);
    //     $imagesGalleries=ImageGallery_model::where('products_id',$id)->get();
    //     $totalStock=ProductAtrr_model::where('products_id',$id)->sum('stock');
    //     $relateProducts=Products_model::where([['id',$id],['categories_id',$detail_product->categories_id]])->get();
    //     foreach($relateProducts as $key => $value){
    //             $meta_desc = $value->description;
    //             $meta_title =' | '. $value->p_name;
    //             $meta_keywords = "áo ,quần,đầm ,váy,quần jean,nón";
    //             $url_canonical = $request->url();
    //         }
    //     return view('frontEnd.product_details',compact('detail_product','imagesGalleries','totalStock','relateProducts','meta_desc','meta_title','meta_keywords','url_canonical'));
    // }
    public function getBySeo(Request $request, $seo)
    {
        $detail_product = Products_model::where('seo', $seo)->firstOrFail();
        $imagesGalleries=ImageGallery_model::where('products_id',$detail_product->id)->get();
        $relateProducts=Products_model::where([['seo',$seo],['categories_id',$detail_product->categories_id]])->get();
        $totalStock=ProductAtrr_model::where('products_id',$detail_product->id)->sum('stock');

        foreach($relateProducts as $key => $value){
            $meta_desc = $value->description;
            $meta_title =' | '. $value->p_name;
            $meta_keywords = "áo ,quần,đầm ,váy,quần jean,nón";
            $url_canonical = $request->url();
        }

        return view('frontEnd.product_details', compact('detail_product','imagesGalleries', 'totalStock', 'relateProducts', 'meta_desc','meta_title','meta_keywords','url_canonical'));
    }
    public function getAttrs(Request $request){
        $all_attrs=$request->all();
        //print_r($all_attrs);die();
        $attr=explode('-',$all_attrs['size']);
        //echo $attr[0].' <=> '. $attr[1];
        $result_select=ProductAtrr_model::where(['products_id'=>$attr[0],'size'=>$attr[1]])->first();
        echo $result_select->price."#".$result_select->stock;
    }
}
