<?php
namespace mywishlist\controleur;

use mywishlist\models\Item;
use mywishlist\models\Liste;
use mywishlist\vue\VueItem;

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
        $item = Item::select()->where('id', '=', $num)->get()->first();
        if(isset($item)){
        	$vue = new VueItem(VueItem::$AFFICHER_1_ITEM, $item);
        }
        echo $vue->render();
    }
	
	function validerItem($idItem, $liste_id, $nom, $descr, $img, $url, $tarif)
	{
		$item = new Item();
		$item->id = $idItem;
		$item->liste_id = $liste_id;
		$item->nom = $nom;
		$item->descr = $descr;
		$item->img = $img;
	}

	function reserverItem()
	{

	}
	
	function annulerReservation($idList, $idItem)
	{
		$item = Item::select()->where('id', '=', $idItem)->first();
		if($item->liste_id == $idList){
			$item->liste_id = 0;
		}
	}
}
