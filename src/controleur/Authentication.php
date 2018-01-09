<?php

namespace mywishlist\controleur;

use mywishlist\models\User;
use mywishlist\vue\VueConfig;


class Authentication{	
	
	public static $ACCESS_USER = 1;
	public static $ACCESS_MODO = 2;
	public static $ACCESS_ADMIN = 3;
	public static $ACCESS_SUP_ADMIN = 4;

	public static $OPTION_LOADPROFILE = 0;
	public static $OPTION_CHANGEPASS = 1;


	static function createUser () {
		$app = \Slim\Slim::getInstance();
		$pseudo = $app->request->post('pseudo');
		$user = User::select()->where('pseudo', '=', $pseudo)->first();
		$occ = !($user==null);
		$mail = $app->request->post('mail');
		if(!isset($user)){
			if($app->request->post('pass')==$app->request->post('passVerif') && filter_var($mail, FILTER_VALIDATE_EMAIL) && !$occ){
				$hash=password_hash($app->request->post('pass'), PASSWORD_DEFAULT, ['cost'=>14] );
				$u = new User();
				$u->pseudo = $app->request->post('pseudo');
				$u->pass = $hash;
				$u->droit = 1;
				$u->jeton = 1;
				$u->mail = $mail;
				$u->save();
				Authentication::loadProfile($app->request->post('pseudo'));
				return true;
			}
		}else return false;
	}

	private static function changePass($user, $password){
		$hash=password_hash($password, PASSWORD_DEFAULT, ['cost'=>14] );
		$user->pass = $hash;
		$user->save();
	}

	static function authenticate ($pseudo, $pass, $option, $arg){
		$user = User::select()->where('pseudo', '=', $pseudo)->first();
		if($user!=null){
			$app = \Slim\Slim::getInstance();
			$hash = $user->pass;
			if (password_verify($pass, $hash)){
				if($option==0){
					Authentication::loadProfile($pseudo);
				}
				else if($option==1){
					Authentication::changePass($user, $arg);
				}
			}else{
				if($option==1){
					$app->redirect('/user/pannel/'.VueConfig::$ERR_MDP);
				}
			}
		}
	}
	
	private static function loadProfile ($pseudo){
		$app = \Slim\Slim::getInstance();
		$user = User::select()->where('pseudo', '=', $pseudo)->first();
		$_SESSION['profile']['pseudo'] = $user->pseudo;
		$_SESSION['profile']['droit'] = $user->droit;
		$_SESSION['profile']['jeton'] = $user->jeton;
		$_SESSION['profile']['id'] = $user->id;
	}
	
	static function checkAccessRights ($required){
		if(!isset($_SESSION['profile']['jeton'])) return false;
		else if($_SESSION['profile']['jeton']>=$required)return true;
		else return false;
	}

}


