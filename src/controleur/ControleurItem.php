<?php
namespace mywishlist\controleur;

use mywishlist\models\Item;
use mywishlist\models\Liste;

class ControleurItem{
	
	function afficherItems()
    {
        $items = Item::select()->get();
        foreach ($items as $item) {
            echo $item . "<br>";
        }
    }

    function afficherItem($num)
    {
        $items = Item::select()->where('id', '=', $num)->get();
        foreach ($items as $item) {
            echo $item . "<br>";
        }
    }
	
	function reserverItem($idList, $idItem)
	{
		 $item = Item::select()->where('id', '=', $idItem)->first();
		 if($item->liste_id == 0){
			 $liste = Liste::select()->where('no', '=', $idList)->first();
			 if(isset($liste)){
				 $item->liste_id = 1;
			 }
		 }
		 
		 
	}
	
	function annulerReservation($idList, $idItem)
	{
		$item = Item::select()->where('id', '=', $idItem)->first();
		if($item->liste_id == $idList){
			$item->liste_id = 0;
		}
	}
}
