<?php
namespace mywishlist\models;

use Illuminate\Database\Eloquent\Model;


class UrlListe extends Model
{
    protected $table='urlListe';
    protected $primaryKey='id,url';
    public $timestamps=false;
    
    public function Liste(){
        return Liste::select()->where("id","=",$this->id)->first();
    }
}