<?php
namespace mywishlist\vue;
use mywishlist\controleur\ControleurUrl;
use mywishlist\models\User;
use mywishlist\controleur\Authentication;
use mywishlist\vue\VueHtml;

class VueConfig
{

    private static $USER = 1;

    private static $MODO = 2;

    private static $ADMIN = 3;

    private static $SUP_ADMIN = 4;

    public static $ERR_VERIF = 2;

    public static $OK = 1;

    public static $ERR_MDP = 3;

    private $selecteur;

    private $modele;

    private $users;

    function __construct($select, $model)
    {
        $this->selecteur = $select;
        $this->modele = $model;
    }

    function setUsers($users){
        $this->users = $users;
    }

    function render()
    {
    $inscription = ControleurUrl::urlName('connection');
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
    <div class="formParam"><button type="submit" name="valid" class="formParam">Confirmer</button></div>
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

    if($this->selecteur >=2){
        $contenu = $contenu . <<<html
        <h3>Droits des utilisateurs</h3>
        <table>
            <tr>
                <th>Pseudo</th>
                <th>mail</th>
                <th>droit</th>
                <th>changer de Role</th>
                <th>action</th>
            </tr>
html;
        foreach ($this->users as $user) {
            $droit = "";
            $options = "";
            switch ($user->droit) {
                case 2:
                    $droit = "Moderateur";
                    break;
                case 3:
                    $droit = "Administrateur";
                    break;
                case 4:
                    $droit = "Super Admin";
                    break;
                default:
                    $droit = "Utilisateur";
                    break;
            }
            switch ($_SESSION['profile']['droit']) {
                case 2:
                    $options = '
                        <option value="1">Utilisateur
                        <option value="2">Moderateur
                    ';
                    break;
                case 3:
                    $options = '
                        <option value="1">Utilisateur
                        <option value="2">Moderateur
                        <option value="3">Admin
                    ';           
                case 4:
                    $options = '
                        <option value="1">Utilisateur
                        <option value="2">Moderateur
                        <option value="3">Admin
                    ';    
                default:
                    # code...
                    break;
            }
            $urlchangementderole=ControleurUrl::urlId('changer_role', $user->id);
            $contenu = $contenu . <<<html
            <tr>
                <td>$user->pseudo</td>
                <td>$user->mail</td>
                <td>$droit</td>
                <td>
                <form method="post" action="$urlchangementderole">
                <select name="newRole" size="1">
html;
            $urlsuppressionuser=ControleurUrl::urlId('supprimer_user',$user->id);
            $contenu = $contenu . $options . <<<eof
                </select>
                <input type="submit" id="formParam" value="Valider" title="test" />
                </form>
                </td>
                <td><form id="suprUser" method="post" action="$urlsuppressionuser" onsubmit="return confirmation('$user->pseudo');"><button type="submit" class="formParam" name="valid">Supprimer</button></form></td>
                <script>
                    function confirmation(id){
                        return confirm("voulez vous vraiment supprimer "+id+" ?");
                    } 
                </script>
            </tr>
eof;
        }
        $contenu = $contenu . "</table>";
    }
        $vue=new VueHtml($contenu, VueHtml::$ARTICLE);
        $html = $vue->render();
        return utf8_encode($html);

    }

}