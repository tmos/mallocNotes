<?php

require_once 'models/user.php';

class Controller_User
{
	public function signin() {
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET' :
				if (isset($_SESSION['user'])) {
					show_message('message success',"You're already connected as ".$_SESSION['user']);
					include 'views/home.php';
				}
				else {
					include 'views/signin.php';
				}
				break;

			case 'POST' :
				if (isset($_POST['login']) && isset($_POST['password'])) {
					$u = User::get_by_login($_POST['login']);
					if (!is_null($u)) {
						if ($u->password() == sha1($_POST['password']))
						{
							$_SESSION['user'] = $u->login();
							show_message('message success',"You're connected");
							header('Location: '.BASEURL.'/index.php/note/mine');
						}
						else {
							show_message('message error',"Login or password false");
							include 'views/signin.php';
						}
					}
					else {
						show_message('message error',"Login or password false");
						include 'views/signin.php';
					}
				}
				else {
						show_message('message error',"Incomplete data!");
						include 'views/signin.php';
				}
				break;
		}
	}

	public function signup() {
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET' :
				if (isset($_SESSION['user'])) {
					show_message('message success',"You're already connected as ".$_SESSION['user']);
					include 'views/home.php';
				}
				else {
					include 'views/signup.php';
				}
				break;

			case 'POST' :
				if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['password_check'])) {
					$exist = User::exist_login($_POST['login']);
					if (!$exist) {
						if($_POST['password'] == $_POST['password_check']) {
							User::insert(htmlspecialchars($_POST['login']),sha1($_POST['password']),htmlspecialchars($_POST['email']));
							show_message('message success',"Signup of  ".$_POST['login'].' !');
							include 'views/signin.php';
						}
						else {
							show_message('message error',"Not same password");
							include 'views/signup.php';
						}
					}
					else {
						show_message('message error',"This username already exists, please choose another one.");
						include 'views/signup.php';
					}
				}
				else {
						show_message('message error',"Incomplete data!");
						include 'views/signup.php';
				}
				break;
		}
	}


	public function signout() {
		unset($_SESSION['user']);
		header('Location: '.BASEURL.'/index.php');
	}

	/* Provient du début de l'exercice sur les Users
	Ce code est buggé
	public function profil() {
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET' :
				if (isset($_SESSION['user'])) {
					$u = User::get_by_login($_SESSION['user']);
					$emailProfil = $u->email();
					include 'views/profil.php';
				} else {
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
	} */
}
