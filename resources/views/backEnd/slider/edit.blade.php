@extends('backEnd.layouts.master')
@section('title','Edit Slider')
@section('content')
    <div id="breadcrumb"> <a href="{{url('/admin')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
        <a href="{{route('slider.index')}}">Sliders</a>
        <a href="#" class="current">Edit Slider</a>
    </div>
    <div class="container-fluid">
        @if(Session::has('message'))
            <div class="alert alert-success text-center" role="alert">
                <strong>Well done! &nbsp;</strong>{{Session::get('message')}}
            </div>
        @endif
        <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
                <h5>Add New Sliders</h5>
            </div>
            <div class="widget-content nopadding">
                <form action="{{route('slider.update',$edit_slider->slider_id)}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    {{method_field("PUT")}}
                    <div class="control-group">
                        <label  class="control-label">Slider Name</label>
                        <div class="controls">
                            <input type="text" name="slider_name" id="slider_name" value="{{$edit_slider->slider_name}}" class="form-control"  title="" required="required" style="width: 400px;">
                            <span class="text-danger">{{$errors->first('slider_name')}}</span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="description" class="control-label">Description</label>
                        <div class="controls">
                            <textarea class="textarea_editor span12" name="slider_desc" id="slider_desc" rows="6" placeholder="Slider Description" style="width: 580px;">{{$edit_slider->slider_desc}}</textarea>
                            <span class="text-danger">{{$errors->first('slider_desc')}}</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Image</label>
                        <div class="controls">
                            <input type="file" name="slider_image" />
                            <span class="text-danger">{{$errors->first('slider_image')}}</span>
                            @if($edit_slider->slider_image!='')
                                &nbsp;&nbsp;&nbsp;
                                <!-- <a href="javascript:" rel="{{$edit_slider->slider_id}}" rel1="delete-image" class="btn btn-danger btn-mini deleteRecord">Delete Old Image</a> -->
                                <img src="{{url('sliders/imgs/',$edit_slider->slider_image)}}" width="35" alt="">
                            @endif
                        </div>
                    </div>
                    <div class="control-group{{$errors->has('slider_status')?' has-error':''}}">
                            <label class="control-label">Enable :</label>
                            <div class="controls">
                            <input type="checkbox" name="slider_status" id="slider_status" value="1" {{($edit_slider->slider_status==0)?'':'checked'}}>
                            </div>
                    </div>

                    <div class="control-group">
                        <label for="" class="control-label"></label>
                        <div class="controls">
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('jsblock')
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/jquery.ui.custom.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-colorpicker.js')}}"></script>
    <script src="{{asset('js/jquery.toggle.buttons.js')}}"></script>
    <script src="{{asset('js/masked.js')}}"></script>
    <script src="{{asset('js/jquery.uniform.js')}}"></script>
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script src="{{asset('js/matrix.js')}}"></script>
    <script src="{{asset('js/matrix.form_common.js')}}"></script>
    <script src="{{asset('js/wysihtml5-0.3.0.js')}}"></script>
    <script src="{{asset('js/jquery.peity.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-wysihtml5.js')}}"></script>
    <script>
        $(".deleteRecord").click(function () {
            var id=$(this).attr('rel');
            var deleteFunction=$(this).attr('rel1');
            swal({
                title:'Are you sure?',
                text:"You won't be able to revert this!",
                type:'warning',
                showCancelButton:true,
                confirmButtonColor:'#3085d6',
                cancelButtonColor:'#d33',
                confirmButtonText:'Yes, delete it!',
                cancelButtonText:'No, cancel!',
                confirmButtonClass:'btn btn-success',
                cancelButtonClass:'btn btn-danger',
                buttonsStyling:false,
                reverseButtons:true
            },function () {
                window.location.href="/admin/"+deleteFunction+"/"+id;
            });
        });
        $('.textarea_editor').wysihtml5();
    </script>
@endsection
