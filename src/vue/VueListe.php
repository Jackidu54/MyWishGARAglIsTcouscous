<?php
namespace mywishlist\vue;

class VueListe
{

    public static $AFFICHE_1_LISTE = 0;

    public static $AFFICHE_LISTES = 1;

    public static $CREATION_LISTE = 2;

    public static $MODIFY_LISTE = 3;

    private $selecteur;

    private $modele;

    function __construct($select, $model)
    {
        $this->selecteur = $select;
        $this->modele = $model;
    }

    function render()
    {
        $contenu = "";
        if ($this->selecteur == self::$AFFICHE_1_LISTE) {
            $liste = $this->modele;
            $contenu = <<<html
<h1>Wishliste $liste->titre</h1>
<p>description : $liste->description  Expire le : $liste->expiration</p>
<ol>

html;
            $items = $liste->items();
            foreach ($items as $item) {
                $contenu = $contenu . <<<html
<li><p class="descritem">$item->nom, etat de reservation : non reservé</p>
<img src="/web/img/$item->img" alt="$item->img">

</li>
html;
    }
            $contenu . <<<html
</ol>
<form id="ajoutItem" method="post" action="/item/ajouter/$liste->no">
<button type="submit" name="valid" >ajouter un nouvel item</button>
</form>    
html;
        }
        if ($this->selecteur == self::$AFFICHE_LISTES) {
            $contenu = <<<html
<h1>Mes WishListes</h1>
  <p>Veuillez sélectionner votre liste dans cette liste de liste</p>
  <ul>
html;
            foreach ($this->modele as $liste) {
                $contenu = $contenu . <<<html
    <li id="liste_affichee"><a href="/liste/display/$liste->no">$liste->titre</a><form id="suprlist" method="post" action="/liste/delete/$liste->no"><button type="submit" name="valid" >supprimer la liste</button></form></li>
html;
            }
            
            $contenu = $contenu . <<<html
  </ul>
html;
        }
        if ($this->selecteur == self::$CREATION_LISTE) {
            $contenu = <<<html
<h1>Creation d'une nouvelle liste</h1>
<form id="formcreationliste" method="post" action="/liste/create/valide">

    <label for"formnomliste">nom de la liste</label>
    <input type="text" id="formnomliste" name="titre" required placeholder="<nom de la liste>">

    <label for"formdescliste">description de la liste</label>    
    <input type="text" id="formdescliste" name="description" required placeholder="<description de la liste>">

    <button type="submit" name="valid" >Créer</button>
</form>
html;
        }
        if ($this->selecteur == self::$MODIFY_LISTE) {
            $contenu=<<<html
TODO
html;
        }
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

