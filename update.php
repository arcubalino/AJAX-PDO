<?php 

	require('db.php');
	$username = $_POST['username'];
	$password = $_POST['password'];
	$user_id = $_POST['user_id'];

	$sql = "UPDATE `user` SET `username`=?,`password`=? WHERE user_id=?";
	$pre = $db->prepare($sql);

	$result = $pre->execute(array($username,$password,$user_id));

	if($result){
		echo"Success";
	}else{
		echo"Error";
	}
?>