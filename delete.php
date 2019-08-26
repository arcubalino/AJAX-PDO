<?php 

require("db.php");

$user_id = $_POST['user_id'];

$sql = "DELETE FROM user WHERE user_id=?";
$pre = $db->prepare($sql);

$result = $pre->execute(array($user_id));

	if($result){
		echo "Success";
	}else{
		echo "Error";
	}

?>