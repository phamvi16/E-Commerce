@extends('backEnd.layouts.master')
@section('title','Add New Slider')
@section('content')
    <div id="breadcrumb"> <a href="{{url('/admin')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
        <a href="{{route('slider.index')}}">Sliders</a>
        <a href="{{route('slider.create')}}" class="current">Add New Slider</a>
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
                <form action="{{route('slider.store')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="control-group">
                        <label for="slider_name" class="control-label">Slider Name</label>
                        <div class="controls{{$errors->has('slider_name')?' has-error':''}}">
                            <input type="text" name="slider_name" id="slider_name"  class="form-control"  title="" required="required" style="width: 400px;">
                            <span class="text-danger">{{$errors->first('slider_name')}}</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="description" class="control-label">Description</label>
                        <div class="controls">
                            <textarea class="textarea_editor span12" name="slider_desc" id="slider_desc" rows="6" placeholder="Slider Description" style="width: 580px;"></textarea>
                            <span class="text-danger">{{$errors->first('slider_desc')}}</span>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Image</label>
                        <div class="controls">
                            <input type="file" name="slider_image" />
                            <span class="text-danger">{{$errors->first('slider_image')}}</span>
                        </div>
                    </div>
                    <div class="control-group{{$errors->has('slider_status')?' has-error':''}}">
                            <label class="control-label">Enable :</label>
                            <div class="controls">
                                <input type="checkbox" name="slider_status" id="slider_status" value="1">
                                <span class="text-danger">{{$errors->first('slider_status')}}</span>
                            </div>
                    </div>
                    <div class="control-group">
                        <label for="" class="control-label"></label>
                        <div class="controls">
                            <button type="submit" class="btn btn-success">Add New Sliders</button>
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
        $('.textarea_editor').wysihtml5();
    </script>
@endsection
