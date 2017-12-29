<?php
namespace mywishlist\vue;
use mywishlist\controleur\ControleurUrl;
use mywishlist\models\User;
use mywishlist\controleur\Authentication;

class VueConfig
{

    private static $USER = 1;

    private static $MODO = 2;

    private static $ADMIN = 3;

    private static $SUP_ADMIN = 4;

    public static $ERR_VERIF = 1;

    public static $OK = 0;

    public static $ERR_MDP = 2;

    private $selecteur;

    private $modele;

    function __construct($select, $model)
    {
        $this->selecteur = $select;
        $this->modele = $model;
    }

    function render()
    {
    $inscription = ControleurUrl::urlName('inscription');
    $urlChange = ControleurUrl::urlName('changePass');
    $contenu = "";
    $verif1 = 'champ_con';
    $verif2 = 'champ_con';
    $verif3 = 'champ_con';

    if($this->modele == VueConfig::$ERR_VERIF){
        $verif2 = 'champ_inscr';
        $verif3 = 'champ_inscr';
    }else if($this->modele == VueConfig::$ERR_MDP){
        $verif1 = 'champ_inscr';
    }

    $contenu = $contenu . <<<html
    <h3>Changer mot de passe</h3>

    <form id="changePass" method="post" action="$urlChange">
    <label>Ancien mot de passe</label>
    <input type="password" id="pass" name="pass" class="$verif1">
    <label>Mot de passe</label>
    <input type="password" id="pass" name="newPass" class="$verif2">
    <label>Confirmer</label>
    <input type="password" id="pass" name="passVerif" class="$verif3">
    <button type="submit" name="valid" class="se_connecter">Confirmer</button>
    </form>

html;
    if($this->modele == VueConfig::$ERR_VERIF){
        $contenu = $contenu . <<<html
    <p>Les mots de passe ne correspondent pas</p>
html;
    }else if($this->modele == VueConfig::$OK){
        $contenu = $contenu . <<<html
        <p>Mot de passe changé</p>
html;
    }else if($this->modele == VueConfig::$ERR_MDP){
        $contenu = $contenu . <<<html
        <p>Le mot de passe n'est pas bon</p>
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

}