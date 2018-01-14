<?php
namespace mywishlist\models;

use Illuminate\Database\Eloquent\Model;

class User extends \Illuminate\Database\Eloquent\Model{
	
	protected $table='user';
    protected $primaryKey='id';
    public $timestamps=false; 
}