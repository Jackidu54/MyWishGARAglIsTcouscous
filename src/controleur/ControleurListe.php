<?php
namespace mywishlist\controleur;

use mywishlist\models\Liste;
use mywishlist\vue\VueListe;
class ControleurListe
{


    function afficherListes()
    {
        $listes = Liste::select()->get();
        $vue=new VueListe(VueListe::$AFFICHE_LISTES, $listes);
        echo $vue->render();
    }
    function afficherListe($num)
    {
        $liste = Liste::select()->where('no', '=', $num)->first();
        if(isset($liste)){
        	$vue=new VueListe(VueListe::$AFFICHE_1_LISTE, $liste);
        	echo $vue->render();
        }else {
        	echo "liste inexistante tricheur de merde";
    	}
    }

    function creerListe($user, $titre, $description)
    {
    	$date = date("Y-m-d", strtotime("+1 year"));
        $l = new Liste();
        $l->user_id = $user;
        $l->titre = $titre;
        $l->description = $description;
        $l->expiration = $date;
        $l->save();
    }
    
    function afficheCreationListe(){
        $user="";
        $vue= new VueListe(VueListe::$CREATION_LISTE, $user);
        echo $vue->render();
    }


    function modifierListe($no,$titre,$description){
    	$liste = Liste::select()->where('no', '=', $no)->first();
    	$liste->titre = $titre;
    	$liste->description = $description;
    	$liste->expiration = date("Y-m-d", strtotime("+1 year"));
    	$l->save();
    }

    function ajouterMessage($id, $message){
    	$liste = Liste::select()->where('no', '=', $id)->first();
    	$liste->message = $message;
    	$liste->save();
    }

    function afficherModificationListe($idliste){
        $liste = Liste::select()->where('no', '=', $idliste)->first();
        $vue=new VueListe(VueListe::$MODIFY_LISTE, $liste);
        echo $vue->render();
    }

    function supprimerListe($id){
    	$liste = Liste::select()->where('no', '=', $id)->first();
    	$liste->delete();
    }
}