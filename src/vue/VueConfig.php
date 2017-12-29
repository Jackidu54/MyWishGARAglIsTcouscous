<?php
namespace mywishlist\vue;
use mywishlist\controleur\ControleurUrl;
use mywishlist\models\User;
use mywishlist\controleur\Authentication;

class VueListe
{

    private static $USER = 1;

    private static $MODO = 2;

    private static $ADMIN = 3;

    private static $SUP_ADMIN = 4;

    private $selecteur;

    private $modele;

    function __construct($select, $model)
    {
        $this->selecteur = $select;
        $this->modele = $model;
    }

    function render()
    {
    $contenu = $contenu . <<<html
    <h3>Changer mot de passe</h3>
    <label>Ancien mot de passe</label>
    <input type="password" id="pass" name="pass" class="champ_inscr">
    <label>Mot de passe</label>
    <input type="password" id="pass" name="newPass" class="champ_inscr">
    <label>Confirmer</label>
    <input type="password" id="pass" name="passVerif" class="champ_inscr">

html;

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
    <li><a href="$inscription">Se déconnecter</a></li>
    <li><a href="/liste/display">Affiche mes listes</a></li>
    <li><a href="/liste/create">Créer une liste</a></li>
    <li><a href="#">Ordonner les items</a></li>
html;
    if(Authentication::checkAccessRights(Authentication::$ACCESS_SUP_ADMIN)){
        $url = ControleurUrl::urlName('listes_all');
        $html = $html . <<<html
    <li><a href="$url">Afficher toutes les listes</a></li>
html;
    }
    $html = $html . <<<html
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