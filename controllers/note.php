<?php

require_once 'models/user.php';
require_once 'models/note.php';

class Controller_Note
{
	public function mine() {
		if (user_connected()) {
			$data = array();
			$data = Note::get_by_creator($_SESSION['user']);
			include "views/mine.php";
		}
		else {
			show_message('message error',"You're not connected");
			include 'views/signin.php';
		}
	}

	public function create() {
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET' :
				if(user_connected()) {
					include 'views/create.php';
				}
				else {
					show_message('message error','You have te be connected!');
					include 'views/signin.php';
				}
				break;

			case 'POST' :
				if(user_connected()) {
					if(strlen($_POST['value']) <= 300) {
						Note::insert(htmlspecialchars($_POST['title']),htmlspecialchars($_SESSION['user']),htmlspecialchars($_POST['value']));
						show_message('message success','Note successfuly created!');
						$this->mine();
					}
					else {
						show_message('message error','Note too long! (300 max)');
						include 'views/create.php';
					}
				}
				break;
			}
	}

	public function edit($id_note) {
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET' :
				if(user_connected()) {
					$note = Note::get_by_id($id_note);
					if($note && $note->creator() == $_SESSION['user']) {
						$data = Note::get_share_by_id_note($id_note);
						$list_user = null;
						if ($data) {
							$list_user = $data[0]->login();
							for ($i = 1; $i < count($data); $i++) {
								$list_user = $list_user.",".$data[$i]->login();
							}
						}
						include 'views/edit.php';
					}
					else {
						show_message('message error','Not your note or not shares with you!');
						$this->mine();
					}
				}
				else {
					show_message('message error','You have te be connected!');
					include 'views/signin.php';
				}
				break;

			case 'POST' :
				if(user_connected()) {
					if(isset($_POST['value'])) {
						$note = Note::get_by_id($id_note);
						if($note && $note->creator() == $_SESSION['user']) {
							if($note->value() != $_POST['value'] || $note->title() != $_POST['title']) {
								$note->set_title(htmlspecialchars($_POST['title']));
								$note->set_value(htmlspecialchars($_POST['value']));
								$note->save();
								header('Location: '.BASEURL.'/index.php/note/mine');
							}
						}
					}
				}
				else {
					show_message('message error','You have to be connected!');
					include 'views/signin.php';
				}
		}

	}

	public function delete($id_note) {
		if(user_connected()) {
			if(isset($_POST)) {
				$note = Note::get_by_id($id_note);
				if ($note && $note->creator() == $_SESSION['user']) {
					$verif = $note->delete();
					if($verif) {
						show_message('message success','Note deleted successfuly');
						$this->mine();
					}
					else {
						show_message('message error','Error deleting note');
						$note = Note::get_by_id($id_note);
						include 'views/edit';
					}
				}
				else {
					show_message('message error','Note inexistant or not your note');
					$this->mine();
				}
			}
		}
		else {
			show_message('message error','You have te be connected!');
		}
	}


	public function edit_share($id_note) {
		if (user_connected()) {
			$note = Note::get_by_id($id_note);
			if ($note && $note->creator() == $_SESSION['user']) {
				if (isset($_POST['share'])) {
					$users_html = explode(',',$_POST['share']); // Tableau de chaine de caractère
					$users_bdd  = Note::get_share_by_id_note($id_note); // Tableau de User

					foreach($users_bdd as $u) {
						if (!in_array($u->login(), $users_html)) {
							// Retrait
							if (User::exist_login($u->login())) {
								$verif = Note::delete_share($id_note,$u->id());
								if($verif) {
									show_message('message success','Share deleted successfuly with');
								}
								else {
									show_message('message error', 'Share not really deleted');
								}
							}
							else {
								show_message('message error', 'Error in deleting share');
							}
						}
					}

					foreach($users_html as $u) {
						$user = User::get_by_login(trim($u));
						if (!in_array($user, $users_bdd)) {
							// Ajout
							if (User::exist_login($u)) {
								if ($note->creator() != $u) {
									$verif = Note::add_share($id_note,$user->id());
									if($verif) {
										show_message('message success','Note shared successfuly');
									}
									else {
										show_message('message error', 'Note not shared');
									}
								}
								else {
									show_message('message error', 'You are the creator of the note');
								}
							}
							else {
								show_message('message error', 'Error in sharing note');
							}
						}
					}
					$this->mine();
				}
				else {
					show_message('message error', 'User to share with not defined');
					$this->mine();
				}
			}
			else {
				show_message('message error',"Inexistant note or not you're note");
				$this->mine();
			}
		}
	}

	public function shared() {
		if (user_connected()) {
			$data = array();
			$user = User::get_by_login($_SESSION['user']);
			$data = Note::get_share_by_id_user($user->id());
			include "views/shared.php";
		}
		else {
			show_message('message error',"You're not connected");
			include 'views/signin.php';
		}
	}
}
