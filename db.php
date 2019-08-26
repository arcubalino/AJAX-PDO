<?php

	$db = NEW PDO('mysql:host=localhost;dbname=test', "root", "");  

	function create($name, $description, $course){
		$db = database();
		$sql = 'INSERT INTO crud_data(name, description, course, status) VALUES(?, ?, ?, ?)';
		$cmd = $db->prepare($sql);
		$cmd->execute(array($name, $description, $course, 1));
		$db = null;
	}

	function get_data($id){
		$bd = database();
		$sql = 'SELECT name, description, course, status FROM crud_data WHERE id = ?';
		$cmd = $db->prepare($sql);
		$cmd->execute(array($id));
		$rows = $cmd->fetch(); 
		$db = null;

		return $rows;

	}

	function update($name, $description, $course, $id){
		$db = database();
		$sql = 'UPDATE crud_data SET name = ?, description = ?, $course = ? WHERE id = ?';
		$cmd = $db->prepare($sql);
		$cmd->execute(array($name, $description, $course, $id));
		$db = null;
	}

?>