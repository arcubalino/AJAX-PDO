<?php

	require('db.php');

	$user_id = $_POST['user_id'];

	$sql = "SELECT * FROM user WHERE user_id=?";
	$pre = $db->prepare($sql);
	$pre->execute(array($user_id));
	$row = $pre->fetch(PDO::FETCH_ASSOC);


	echo'
	<input type="hidden" value="'.$user_id.'" id="hidden_user_id">
Username: <input type="text" value="'.$row['username'].'" id="update_username">
<br><br>
Password: <input type="text" id="update_password" value="'.$row['password'].'">
<br><br>
<button onclick="update_user()">Update User</button>
<br><hr>
';

?>