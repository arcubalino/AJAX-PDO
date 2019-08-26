<?php

	require('db.php');

	$user = $_POST['user'];
	$pass = $_POST['pass'];

	$sql = "INSERT INTO `user`(`username`,`password`) VALUES(:username,:password);";

	$pre = $db->prepare($sql);

	$result = $pre->execute(array(':username'=>$user,':password'=>$pass));

$id =  $db->lastInsertId();
	if($result){
		echo '<tr id="tr_'.$id.'">
				<td>'.$id.'</td>
				<td>'.$user.'</td>
				<td>'.$pass.'</td>
				<td><a onclick="edit_user('.$id.');" href="#">Edit</a></td>
				<td><a onclick="delete_user('.$id.');" href="#">Delete</a></td>
			</tr>';
	}else{
		echo "Error";
	}

 ?>