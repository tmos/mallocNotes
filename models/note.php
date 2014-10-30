<?php

require_once 'base.php';

class Note extends Model_Base
{
	private $_id;

	private $_title;

	private $_creator;

	private $_value;


	public function __construct($id, $title, $creator, $value) {
		$this->set_id($id);
		$this->set_title($title);
		$this->set_creator($creator);
		$this->set_value($value);
	}


	// Getter
	public function id() {
		return $this->_id;
	}

	public function title() {
		return $this->_title;
	}

	public function creator() {
		return $this->_creator;
	}

	public function value() {
		return $this->_value;
	}


	// Setter
	public function set_id($v) {
		$this->_id = (int) $v;
	}

	public function set_title($v) {
		$this->_title = strval($v);
	}

	public function set_creator($v) {
		$this->_creator = strval($v);
	}

	public function set_value($v) {
		$this->_value = strval($v);
	}


	public static function insert($title,$creator,$value)
	{
		$s = self::$_db->prepare('INSERT INTO notes (title, creator, value, time) VALUES (:title,:creator,:value, :time)');
		$s->bindValue(':title', $title, PDO::PARAM_STR);
		$s->bindValue(':creator', $creator, PDO::PARAM_STR);
		$s->bindValue(':value', $value, PDO::PARAM_STR);
		$s->bindValue(':time', date("Y-m-d H:i:s"), PDO::PARAM_STR); // Au format date SQL
		$s->execute();
	}

	public function save()
	{
		if(!is_null($this->_id)) {
			$s = self::$_db->prepare('UPDATE notes SET title=:title, creator=:creator, value=:value, time=:time WHERE id = :id');
			// bind value des champs
			$s->bindValue(':id', $this->_id, PDO::PARAM_INT);
			$s->bindValue(':title', $this->_title, PDO::PARAM_STR);
			$s->bindValue(':creator', $this->_creator, PDO::PARAM_STR);
			$s->bindValue(':value', $this->_value, PDO::PARAM_STR);
			$s->bindValue(':time', date("Y-m-d H:i:s"), PDO::PARAM_STR);
			$s->execute();
			return $s;
		}
	}

	public function delete()
	{
		if(!is_null($this->_id)) {
			$s = self::$_db->prepare('DELETE FROM notes WHERE id = :id');
			$s->bindValue(':id', $this->_id);
			$s->execute();
			if ($s) {
				$this->_id = null;
			}
			return $s;
		}
	}

	public static function get_by_title($title) {
		// !!! attention au nom de la table !!!
		$s = self::$_db->prepare('SELECT * FROM notes WHERE title = :title');
		$s->bindValue(':title', $title, PDO::PARAM_STR);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return new Note($data['id'],$data['title'],$data['creator'],$data['value'],$data['time']);
		}
		else {
			return null;
		}
	}

	public static function get_by_id($id) {
		$s = self::$_db->prepare('SELECT * FROM notes WHERE id = :id');
		$s->bindValue(':id', $id, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return new Note($data['id'],$data['title'],$data['creator'],$data['value'],$data['time']);
		}
		else {
			return null;
		}
	}

	public static function get_by_creator($creator) {
		$s = self::$_db->prepare('SELECT * FROM notes where creator = :creator ORDER BY time DESC');
		$s->bindValue(':creator', $creator, PDO::PARAM_STR);
		$s->execute();
		$data = array();
		while ($row = $s->fetch(PDO::FETCH_ASSOC)) {
  			$data[] = new Note($row['id'],$row['title'],$row['creator'],$row['value'],$row['time']);
    	}
    	return $data;
	}

	public function get_time($id) {
		$s = self::$_db->prepare('SELECT time FROM notes WHERE id = :id');
		$s->bindValue(':id', $id, PDO::PARAM_INT);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			return $data['time'];
		}
		else {
			return '';
		}
	}

	public static function exist_title($title) {
		$test = false;
		$s = self::$_db->prepare('SELECT * FROM notes where title = :t');
		$s->bindValue(':t', $login, PDO::PARAM_STR);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data)
		{
			$test = true;
		}
		return $test;
	}

	public static function exist_creator($creator) {
		$test = false;
		$s = self::$_db->prepare('SELECT * FROM notes where creator = :creator');
		$s->bindValue(':creator', $creator, PDO::PARAM_STR);
		$s->execute();
		$data = $s->fetch(PDO::FETCH_ASSOC);
		if ($data)
		{
			$test = true;
		}
		return $test;
	}





	public static function add_share($id_note,$id_user) {
		$q = self::$_db->prepare('INSERT INTO shares (id_note,id_user) VALUES (:id_note,:id_user)');
		$q->bindValue(':id_note', $id_note, PDO::PARAM_INT);
		$q->bindValue(':id_user', $id_user, PDO::PARAM_INT);
		$q->execute();
		return $q;
	}

	public static function delete_share_by_id_note($id_note) {
		$q = self::$_db->prepare('DELETE FROM shares WHERE id_note = :id_note');
		$q->bindValue(':id_note', $id_note, PDO::PARAM_INT);
		$q->execute();
		return $q;
	}

	public static function delete_share($id_note,$id_user) {
		$q = self::$_db->prepare('DELETE FROM shares WHERE id_note = :id_note AND id_user = :id_user');
		$q->bindValue(':id_note', $id_note, PDO::PARAM_INT);
		$q->bindValue(':id_user', $id_user, PDO::PARAM_INT);
		$q->execute();
		return $q;
	}

	public static function get_share_by_id_note($id_note) {
		$q = self::$_db->prepare('SELECT * FROM shares where id_note = :id_note ORDER BY id_note');
		$q->bindValue(':id_note', $id_note, PDO::PARAM_INT);
		$q->execute();
		$data = array();
		while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
			$data[] = User::get_by_id($row['id_user']);
		}
		return $data;
	}

	public static function get_share_by_id_user($id_user) {
		$q = self::$_db->prepare('SELECT n.id,n.title,n.creator,n.value,n.time FROM notes n, shares s WHERE n.id=s.id_note AND s.id_user = :id_user ORDER BY n.time DESC');
		$q->bindValue(':id_user', $id_user, PDO::PARAM_INT);
		$q->execute();
		$data = array();
		while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
			$data[] = Note::get_by_id($row['id']);
		}
		return $data;
	}

	public static function get_share($id_note,$id_user) {
		$q = self::$_db->prepare('SELECT * FROM shares where id_note = :id_note AND id_user = :id_user');
		$q->bindValue(':id_note', $id_note, PDO::PARAM_INT);
		$q->bindValue(':id_user', $id_user, PDO::PARAM_INT);
		$data = $q->fetch(PDO::FETCH_COLUMN);
		return $q;
	}

}
