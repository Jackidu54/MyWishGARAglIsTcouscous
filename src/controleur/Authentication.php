<?php

namespace mywishlist\controleur;

use mywishlist\models\User;


class Authentication{	
	


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
				$u->save();
				Authentication::loadProfile($app->request->post('pseudo'));
				return true;
			}
		}else return false;
	}

	static function authenticate ($pseudo){
		$app = \Slim\Slim::getInstance();
		$user = User::select()->where('pseudo', '=', $pseudo)->first();
		$hash = $user->pass;
		if (password_verify($app->request->post('pass'), $hash)){
			Authentication::loadProfile($app->request->post('pseudo'));
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
		
	}

}


