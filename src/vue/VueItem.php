<?php
namespace mywishlist\vue;

use mywishlist\controleur\Authentication;
use mywishlist\controleur\ControleurUrl;

class VueItem
{
    public static $AFFICHER_1_ITEM=0;
    public static $RESERVE_ITEM=1;
    public static $ANNULER_ITEM=2;
    public static $CREATION_MESSAGE=3;
    public static $CREATION_ITEM=4;
    private $selecteur;
    private $model;
    function __construct($select,$modele){
        $this->selecteur=$select;
        $this->model=$modele;
    }
    
    function render()
    {
        $contenu = "";
        $inscription = ControleurUrl::urlName('connection');
        if ($this->selecteur == self::$AFFICHER_1_ITEM) {
            $tmp=$this->model;
            $contenu = <<<html
<h1>Item : $tmp->nom</h1>
html;
            $contenu = $contenu.<<<html
    <a>Description : $tmp->descr </br></a>
<img src="/web/img/$tmp->img" alt="$tmp->img">
html;
        if($tmp->url != null){
            $contenu = $contenu . <<<html
            <a href="$tmp->url"><p>En savoir plus</p></a>
html;
        }
            
            $contenu=$contenu.<<<html
html;
            
        }
            
        if ($this->selecteur == self::$CREATION_ITEM) {
            $id = $this->model;
            $app =\Slim\Slim::getInstance();
            $rootUri = $app->request->getRootUri();
            $itemUrl = $app->urlFor('ajoute_item_valide', ['id'=> $id]);
            $urlCreerItem = $rootUri . $itemUrl;
            $contenu = <<<html
<h1>Reservation d'un item</h1>
<form id="formreserveitem" method="post" action="$urlCreerItem" enctype="multipart/form-data">

    <label for"formnomreserve">Nom de l'item</label>
    <input type="text" id="formnomreserve" name="nom" required placeholder="<nom de l'item>">
    
    <label for"formdescitem">Description de l'item</label>
    <input type="text" id="formdescitem" name="descr" required placeholder="<description de l'item>">

    <label for"formimageitem">url</label>
    <input type="text" id="formimageitem" name="url" required placeholder="<url de l'item>">
    
    <label for="mon_fichier">Fichier (tous formats | max. 1 Mo) :</label><br />
     <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
     <input type="file" name="mon_image" id="mon_fichier" /><br />

    <label for"formTarif">Tarif (€)</label>
    <input type="number" step=".01" id="formTarif" name="tarif" required placeholder="5,00">

    <button type="submit" name="valid" >Ajouter</button>
</form>
html;
if(isset($_SESSION['erreur']['tarifItem'])){
    $contenu = $contenu . <<<html
    <p>attention le prix ne doit pas exceder 1000€ exclu</p>
html;
    $_SESSION['erreur']['tarifItem'] = null;
}
        }
        
        if ($this->selecteur == self::$ANNULER_ITEM) {
            
                
            
        }
        
        if ($this->selecteur == self::$CREATION_MESSAGE) {}


        $vue=new VueHtml($contenu, VueHtml::$ARTICLE);
        $html = $vue->render();
        return $html;
    }
}

