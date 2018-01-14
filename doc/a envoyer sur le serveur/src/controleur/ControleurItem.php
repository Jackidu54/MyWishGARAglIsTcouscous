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

    function supprimerItem($id){
        $item = Item::select()->where('id', '=', $id)->get()->first();
        unlink(__DIR__."..\\..\\..\\web\\img\\".$item->img);
        $item->delete();
    }

    function afficherItem($num)
    {
        $item = Item::select()->where('id', '=', $num)->get()->first();
        if(isset($item)){
        	$vue = new VueItem(VueItem::$AFFICHER_1_ITEM, $item);
        }
        echo $vue->render();
    }

    function itemVerif($num, $tokenListe){
        $item = Item::select()->where('id', '=', $num)->get()->first();
        $liste = Liste::select()->where('token', '=', $tokenListe)->first();
        if(isset($item) && ($item->liste_id == $liste->no)){
            return true;
        }else return false;
    }
	
	function reserverItem($id)
	{
        $item=Item::select()->where('id','=',$id)->first();
        $item->reserve="reservé";
        $item->email=$_SESSION['email'];
        $item->save();
	}

	function dereserverItem($id)
	{
	    $item=Item::select()->where('id','=',$id)->first();
	    $item->reserve="non reservé";
	    unset($item->email);
	    $item->save();
	}
	
	function createurItem($id_liste){
		$vue=new VueItem(VueItem::$CREATION_ITEM, $id_liste);
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
        if($tarif<1000){
            $app = \Slim\Slim::getInstance();
            $dir = __DIR__;
            $dir2 = $_FILES['mon_image']['tmp_name'];
            $hash = md5(uniqid(rand(), true));
            echo "$dir";
            echo $dir2;
            $extension_upload = strtolower(  substr(  strrchr($_FILES['mon_image']['name'], '.')  ,1)  );
            move_uploaded_file($_FILES['mon_image']['tmp_name'],__DIR__."..\\..\\..\\web\\img\\$hash".".$extension_upload");
            $i = new Item();
            $i->liste_id = $liste_id;
            $i->nom = $nom;
            $i->descr = $descr;
            $i->url = $url;
            $i->tarif = $tarif;
            $i->img = "$hash".".$extension_upload";
            $i->save();
        }else {
            $_SESSION['erreur']['tarifItem'] = true;
        }
	}
}
