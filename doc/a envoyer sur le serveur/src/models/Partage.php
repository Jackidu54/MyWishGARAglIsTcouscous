<?php
namespace mywishlist\models;
use Illuminate\Database\Eloquent\Model;
class Partage extends Model
{
    protected $table='partage';
    protected $primaryKey='id_liste,email';
    public $timestamps=false;
    
    
}
