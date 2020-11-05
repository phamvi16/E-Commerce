<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table='contact';
    protected $primaryKey='id';
    protected $fillable=['customer_name','customer_email','message'];

}
