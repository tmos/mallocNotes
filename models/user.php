<?php

require_once 'base.php';

class User extends Model_Base
{
	private $_id;

	private $_login;

	private $_password;

	private $_email;

	public function __construct($id, $login, $password, $email) {
		$this->set_id($id);
		$this->set_login($login);
		$this->set_password($password);
		$this->set_email($email);
	}


	// Getter
	public function id() {
		return $this->_id;
	}

	public function login() {
		return $this->_login;
	}

	public function password() {
		return $this->_password;
	}

	public function email() {
		return $this->_email;
	}


	// Setter
	public function set_id($v) {
		$this->_id = (int) $v;
	}

	public function set_login($v) {
		$this->_login = strval($v);
	}

	public function set_password($v) {
		$this->_password = strval($v);
	}

	public function set_email($v) {
		$this->_email = strval($v);
	}


	public static function insert($login,$password,$email)
	{
		$q = self::$_db->prepare('INSERT INTO users (login, password, email) VALUES (:login,:password, :email)');
		$q->bindValue(':login', $login, PDO::PARAM_STR);
		$q->bindValue(':password', $password, PDO::PARAM_STR);
		$q->bindValue(':email', $email, PDO::PARAM_STR);
		$q->execute();
	}

	public function save()
	{
		if(!is_null($this->_id)) {
			$q = self::$_db->prepare('UPDATE users SET login=:login, password=:password, email=:email WHERE id = :id');
			// bind value des champs
			$q->bindValue(':id', $this->_id, PDO::PARAM_INT);
			$q->bindValue(':login', $this->_login, PDO::PARAM_STR);
			$q->bindValue(':password', $this->_password, PDO::PARAM_STR);
			$q->bindValue(':email', $this->_email, PDO::PARAM_STR);
			$q->execute();
		}
	}

	public function delete()
	{
		if(!is_null($this->_id)) {
			$q = self::$_db->prepare('DELETE FROM users WHERE id = :id');
			$q->bindValue(':id', $this->_id);
			$q->execute();
			$this->_id = null;
		}
	}

	public static function get_by_login($login) {
		// !!! attention au nom de la table !!!
		$s = self::$_db->prepare('SELECT * FROM users where login = :l');
		$s->bindValue(':l', $login, PDO::PARAM_STR);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return new User($data['id'],$data['login'],$data['password'],$data['email']);
		}
		else {
			return null;
		}
	}

	public static function get_by_id($id) {
		$s = self::$_db->prepare('SELECT * FROM users where id = :id');
		$s->bindValue(':id', $id, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return new User($data['id'],$data['login'],$data['password'],$data['email']);
		}
		else {
			return null;
		}
	}

	public static function exist_login($login) {
		$test = false;
		$s = self::$_db->prepare('SELECT * FROM users where login = :l');
		$s->bindValue(':l', $login, PDO::PARAM_STR);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data)
		{
			$test = true;
		}
		return $test;
	}
}
