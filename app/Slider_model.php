<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider_model extends Model
{
    protected $table='sliders';
    protected $primaryKey='slider_id';
    protected $fillable=['slider_name','slider_image','slider_status','slider_desc'];
}
