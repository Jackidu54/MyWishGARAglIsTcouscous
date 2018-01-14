<?php
namespace mywishlist\models;

use Illuminate\Database\Eloquent\Model;


class Liste extends Model 
{
    protected $table='liste';
    protected $primaryKey='no';
    public $timestamps=false; 
    
    public function items(){
        return Item::select()->where("liste_id","=",$this->no)->get();
    }
    public function urls(){
        return UrlListe::select()->where('id','=',$this->id)->get();
    }
}

