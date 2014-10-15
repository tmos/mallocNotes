<?php

require_once 'models/user.php';

class Controller_User
{
	public function signin() {
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET' :
				if (isset($_SESSION['user'])) {
					$_SESSION['user'] = $u->login();
					$_SESSION['message']['type'] = 'message';
					$_SESSION['message']['text'] = 'Vous êtes déjà connectés en tant que '.$_SESSION['user'];
					include 'views/signin.php';
				} else {
					include 'views/signin.php';
				}
				break;

			case 'POST' :
				if (isset($_POST['login']) && isset($_POST['password'])) {
					$u = User::get_by_login($_POST['login']);
					if (!is_null($u)) {
						if ($u->password() == $_POST['password'])
						{
							$_SESSION['user'] = $u->login();
							$_SESSION['message']['type'] = 'message';
							$_SESSION['message']['text'] = 'Vous êtes connecté(e)';
							include 'views/home.php';
						}
						else
						{
							$_SESSION['message']['type'] = 'error';
							$_SESSION['message']['text'] = 'Login ou mot de passe erroné!';
							include 'views/signin.php';
						}
					} else {
						$_SESSION['message']['type'] = 'error';
						$_SESSION['message']['text'] = 'Login ou mot de passe erroné!';
						include 'views/signin.php';
					}
				} else {
						$_SESSION['message']['type'] = 'error';
						$_SESSION['message']['text'] = 'Données incomplètes';
						include 'views/signin.php';
				}
				break;
		}	
	}

	public function signup() {
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET' :
				if (isset($_SESSION['user'])) {
					$_SESSION['message']['type'] = 'error';
					$_SESSION['message']['text'] = 'Vous êtes déjà connectés en tant que '.$_SESSION['user'];
					include 'views/home.php';
				} else {
					include 'views/signup.php';
				}
				break;

			case 'POST' :
				if (isset($_POST['login']) && isset($_POST['password'])) {
					$exist = User::exist_login($_POST['login']);
					if (!$exist) {
						User::insert($_POST['login'],$_POST['password'],$_POST['email']);
						$_SESSION['message']['type'] = 'message';
						$_SESSION['message']['text'] = 'Inscription de '.$_POST['login'].' effectuée';
						include 'views/home.php';
					}
					else 
					{
						$_SESSION['message']['type'] = 'error';
						$_SESSION['message']['text'] = 'Login donné déjà existant dans la base';
						include 'views/signup.php';
					}
				} else {
						$_SESSION['message']['type'] = 'error';
						$_SESSION['message']['text'] = 'Données incomplètes';
						include 'views/signup.php';
				}
				break;
		}
	}


	public function signout() {
		unset($_SESSION['user']);
		$_SESSION['message']['type'] = 'error';
		$_SESSION['message']['text'] = 'Vous êtes bien déconnecté(e)';
		header('Location: '.BASEURL.'/index.php');
	}

	public function profil() {
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET' :
				if (isset($_SESSION['user'])) {
					$u = User::get_by_login($_SESSION['user']);
					$emailProfil = $u->email();
					include 'views/profil.php';
				} else {
					$message_connexion = "";
					include 'views/signin.php';
				}
				break;

			case 'POST' :
				$u = User::get_by_login($_SESSION['user']);
				if (isset($_POST['updateLogin']) && isset($_POST['updatePassword']))
				{
					if ($_POST['updatePassword'] == $u->password())
					{
						$u->set_login($_POST['updateLogin']);
						$u->save();
						$_SESSION['user'] = $_POST['updateLogin'];
						include 'views/profil.php';
					}
				}
				if (isset($_POST['lastPassword']) && isset($_POST['newPassword']))
				{
					if ($_POST['lastPassword'] == $u->password())
					{
						$u->set_password($_POST['newPassword']);
						$u->save();
						include 'views/profil.php';
					}
				}
				if (isset($_POST['updateEmail']) && isset($_POST['update2Password']))
				{
					if ($_POST['update2Password'] == $u->password())
					{
						$u->set_email($_POST['updateEmail']);
						$u->save();
						include 'views/profil.php';
					}
				}
				break;
		}
		// TODO
		// - si accès en GET et client connecté :
		//   affiche les infos du user et un formulaire permettant de les mettre à jour
		//   (on demande le mot de passe actuel pour toute modification d'information)
		// - si accès en POST :
		//   gestion de la mise à jour des informations
	}
}
