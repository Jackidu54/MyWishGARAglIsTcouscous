<?php
namespace mywishlist\models;

use Illuminate\Database\Eloquent\Model;


class Guest extends Model 
{
    protected $table='guest';
    protected $primaryKey='id_user';
    public $timestamps=false; 
    
}