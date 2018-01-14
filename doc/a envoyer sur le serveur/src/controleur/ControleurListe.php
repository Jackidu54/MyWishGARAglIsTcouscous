<?php
namespace mywishlist\controleur;

use mywishlist\models\Liste;
use mywishlist\models\Guest;
use mywishlist\models\Partage;
use mywishlist\models\User;
use mywishlist\vue\VueListe;
use mywishlist\models\UrlListe;
class ControleurListe
{

    function afficherAdminListes()
    {
        $listes = Liste::select()->get();
        $vue = new VueListe(VueListe::$AFFICHE_ALL, $listes);
        echo $vue->render();
    }

    function afficherListes(){

        $listes = Liste::select()->where('user_id','=', $_SESSION['profile']['id']);
        $listes2 = Liste::join('guest', 'liste.no', '=', 'guest.liste_id')->select('no', 'liste.user_id', 'titre', 'description', 'expiration', 'token','message')->where('guest.user_id','=',$_SESSION['profile']['id'])->union($listes)->get();
        $vue = new VueListe(VueListe::$AFFICHE_LISTES, $listes2);
        echo $vue->render();
    }

    function afficherListe($num)
    {
        $liste = Liste::select()->where('no', '=', $num)->first();
        if (isset($liste)) {
            $vue = new VueListe(VueListe::$AFFICHE_1_LISTE, $liste);
            echo $vue->render();
        } else {
            echo "liste inexistante tricheur de merde";
        }
    }

    function creerListe($user, $titre, $description)
    {
        //$token = md5(uniqid(rand(), true));
        $date = date("Y-m-d", strtotime("+1 year"));
        $l = new Liste();
        $l->user_id = $_SESSION['profile']['id'];
        $l->titre = $titre;
        $l->description = $description;
        $l->expiration = $date;
        //$l->token = $token;
        $l->save();
        $this->changerUrlPartage($l->no);
    }

    function afficheCreationListe()
    {
        $user = "";
        $vue = new VueListe(VueListe::$CREATION_LISTE, $user);
        echo $vue->render();
    }

    function modifierListe($no, $titre, $description)
    {
        $liste = Liste::select()->where('no', '=', $no)->first();
        $liste->titre = $titre;
        $liste->description = $description;
        $liste->expiration = date("Y-m-d", strtotime("+1 year"));
        $liste->save();
    }

    function ajouterMessage($id, $message)
    {
        $liste = Liste::select()->where('no', '=', $id)->first();
        if ($message == "") {
            $liste->message = null;
            $liste->save();
        } else {
            $liste->message = $message;
            $liste->save();
        }
    }

    function afficherModificationListe($idliste)
    {
        $liste = Liste::select()->where('no', '=', $idliste)->first();
        $vue = new VueListe(VueListe::$MODIFY_LISTE, $liste);
        echo $vue->render();
    }

    function supprimerListe($id)
    {
        $liste = Liste::select()->where('no', '=', $id)->first();
        $liste->delete();
        $guests = Guest::select()->where('liste_id', '=', $id)->get();
        foreach ($guests as $guest) {
            $guest->delete();
        }
        $partage = Partage::select()->where('id_liste', '=', $id)->get();
        foreach ($partage as $val) {
            $val->delete();
        }
    }

    function afficherContributeurs($id){
        $liste = Liste::select()->where('no', '=', $id)->first();
        $vue = new VueListe(VueListe::$DISPLAY_CONTRI, $liste);
        echo $vue->render();
    }

    function supprimerGuest($id_liste, $id_user){
        $guest = Guest::select()->where('liste_id', '=', $id_liste)->where('user_id', '=', $id_user)->first();
        $guest->delete();
    }

    function ajouterGuest($id_liste){
        $app = \Slim\Slim::getInstance();
        $pseudo = $app->request->post('pseudo');
        $user = User::select('id')->where('pseudo', '=', $pseudo)->first();
        if($user!=null){
            $id = $user->id;
            $guest = new Guest();
            $guest->liste_id = $id_liste;
            $guest->user_id = $id;
            $guest->save();
        }
    }
    function changerUrlPartage($id_liste){
        $liste=Liste::select()->where('no','=',$id_liste)->first();
        $str = "";
        $chaine = "abcdefghijklmnpqrstuvwxyABCDEFGHIJKLMNOPQRSUTVWXYZ0123456789";
        $nb_chars = strlen($chaine);
        for($i=0; $i<20; $i++){
            $str .= $chaine[ rand(0, ($nb_chars-1)) ];
        }
        while(UrlListe::select()->where('token','=',$str)->first() != null){
            $str="";
            for($i=0; $i<20; $i++){
                $str .= $chaine[ rand(0, ($nb_chars-1)) ];
            }
        }
        $liste->token=$str;
        $liste->save();
        $url=new UrlListe();
        $url->id=$id_liste;
        $url->token=$liste->token;
        $url->save();
    }
    function afficherListePartagee()
    {
        $liste=Liste::select()->where('token','=',$_SESSION['partage'])->first();
        $vue = new VueListe(VueListe::$PARTAGE, $liste);
        echo $vue->render();
    }
    
}