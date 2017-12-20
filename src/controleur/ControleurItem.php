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
	
	function reserverItem()
	{

	}

	function createurItem($id_liste){
		$vue=new VueItem(VueItem::$RESERVE_ITEM, null);
        echo $vue->render();
	}
	
	function annulerReservation($idList, $idItem)
	{
		$item = Item::select()->where('id', '=', $idItem)->first();
		if($item->liste_id == $idList){
			$item->liste_id = 0;
		}
	}

	function ajouterItem($liste_id, $nom, $descr, $url, $tarif){
        $i = new Item();
        $i->liste_id = $liste_id;
        $i->nom = $nom;
        $i->descr = $descr;
        $i->url = $utl;
        $i->tarif = $tarif;
        $i->save();
	}
}
