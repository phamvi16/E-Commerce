<?php

namespace App\Http\Controllers;

use App\Slider_model;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;
use App\Http\Controllers\Controller;


class SliderController extends Controller
{
    public function index(){
        $menu_active = 5;
        $i = 0;
        $sliders = Slider_model::orderBy('slider_id','DESC')->get();;
        return view('backEnd.slider.index', compact('menu_active', 'sliders', 'i'));
    }
    public function create()
    {
        $menu_active = 5;
        $sliders = Slider_model::where('slider_id',0)->pluck('slider_name')->all();
        return view('backEnd.slider.create', compact('menu_active','sliders'));
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'slider_name'=>'required|min:5',
            'slider_image'=>'required|image|mimes:png,jpg,jpeg|max:1000',
            'slider_status'=>'required',
            'slider_desc'=>'required',
        ]);
        $formInput=$request->all();
        if($request->file('slider_image')){
            $image=$request->file('slider_image');
            if($image->isValid()){
                $fileName=time().'-'.str_slug($formInput['slider_name'],"-").'.'.$image->getClientOriginalExtension();
                $image_path=public_path('sliders/imgs/'.$fileName);
                //Resize Image
                Image::make($image)->save($image_path);
                $formInput['slider_image']=$fileName;
            }
        }
        Slider_model::create($formInput);
        return redirect()->route('slider.create')->with('message','Add Sliders Successfully!');
    }
    public function edit($slider_id)
    {
        $menu_active = 5;
        $sliders = Slider_model::where('slider_id',0)->pluck('slider_id')->all();
        $edit_slider = Slider_model::findOrFail($slider_id);
        return view('backEnd.slider.edit',compact('edit_slider','menu_active','sliders','edit_slider'));
    }
    public function update(Request $request, $slider_id)
    {
        $update_slider=Slider_model::findOrFail($slider_id);
        $this->validate($request,[
            'slider_name'=>'required|min:5',
            'slider_desc'=>'required',
        ]);
        $formInput=$request->all();

        if(empty($formInput['slider_status'])){
            $formInput['slider_status']=0;
        }
        $update_slider->update($formInput);
        return redirect()->route('slider.index')->with('message','Update Sliders Successfully!');
    }

    public function destroy($slider_id)
    {
        $delete=Slider_model::findOrFail($slider_id);
        $image_path=public_path().'/sliders/imgs/'.$delete->slider_image;
        if($delete->delete()){
            unlink($image_path);
        }
        return redirect()->route('slider.index')->with('message','Delete Success!');
    }



}
