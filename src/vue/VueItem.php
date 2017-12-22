<?php
namespace mywishlist\vue;

class VueItem
{
    public static $AFFICHER_1_ITEM=0;
    public static $RESERVE_ITEM=1;
    public static $ANNULER_ITEM=2;
    public static $CREATION_MESSAGE=3;
    private $selecteur;
    private $model;
    function __construct($select,$modele){
        $this->selecteur=$select;
        $this->model=$modele;
    }
    
    function render()
    {
        $contenu = "";
           
        if ($this->selecteur == self::$AFFICHER_1_ITEM) {
            $tmp=$this->model;
            $contenu = <<<html
<h1>Item : $tmp->nom</h1>
html;
            $contenu = $contenu.<<<html
    <a>Description : $tmp->descr </br></a>
<img src="/web/img/$tmp->img" alt="$tmp->img">
html;
            
            $contenu=$contenu.<<<html
html;
            
        }
            
        if ($this->selecteur == self::$RESERVE_ITEM) {
            $id = $this->model;
            $app =\Slim\Slim::getInstance();
            $rootUri = $app->request->getRootUri();
            $itemUrl = $app->urlFor('ajoute_item_valide', ['id'=> $id]);
            $urlCreerItem = $rootUri . $itemUrl;
            $contenu = <<<html
<h1>Reservation d'un item</h1>
<form id="formreserveitem" method="post" action="$urlCreerItem">

    <label for"formnomreserve">Nom de l'item</label>
    <input type="text" id="formnomreserve" name="nom" required placeholder="<nom de l'item>">
    
    <label for"formdescitem">Description de l'item</label>
    <input type="text" id="formdescitem" name="descr" required placeholder="<description de l'item>">

    <label for"formimageitem">url</label>
    <input type="text" id="formimageitem" name="url" required placeholder="<url de l'item>">
    
    <label for"formTarif">tarif (€)</label>
    <input type="number" step=".01" id="formTarif" name="tarif" required placeholder="5,00">

    <button type="submit" name="valid" >Ajouter</button>
</form>
html;
        }
        
        if ($this->selecteur == self::$ANNULER_ITEM) {
            
                
            
        }
        
        if ($this->selecteur == self::$CREATION_MESSAGE) {}

        
        $html = <<<html
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Titre de la page</title>
  <link rel="stylesheet" href="/web/css/style.css">
  
  
</head>
<body>

<div class="container">

<header>
   <h1>Liste de Cadeaux</h1>
</header>

<nav>
  <ul>
    <li><a href="#">Créer un compte</a></li>
    <li><a href="#">Se connecter</a></li>
    <li><a href="/liste/display">Affiche mes listes</a></li>
    <li><a href="/liste/create">Créer une liste</a></li>
    <li><a href="#">Ordonner les items</a></li>
  </ul>
</nav>

<article>
  $contenu
</article>

<footer>
<div id="gauche">
Petit message de paix d'amour et d'amitié
</div>
<div id="droite">
Copyright
</div>

</footer>

</div>

</body>
</html>
html;
        return $html;
    }
}

