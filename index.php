<script src="jquery-3.0.0.min.js"></script>
<script>
		
	function create_user(){

		$username = $("#username").val();
		$password = $("#password").val();

		if($username == "" || $password == ""){
			alert('Username/Password is empty!');
		}else{

			$.ajax({

				url: "create.php",
				type: "POST",
				data:{'user':$username,'pass':$password},
				success:function(data){
					// alert(data);

					if(data!="Error"){
						$(".tbl_user").append(data);
						$("#username").val('');
						$("#password").val('');
					}//end of success

				}//end of success call back
			});//end of ajax

		}
	}

	function delete_user(user_id){


		if(confirm('Are you sure?')){
		
				$.ajax({
		
						url: "delete.php",
						type: "POST",
						data:{'user_id':user_id},
						success:function(data){
							if(data == "Success"){
								// alert('Successfully deleted!');
								$("#tr_"+user_id).remove();
							}//end of if
						}//end of success
				});//end of ajax

			}
	}


	function edit_user(user_id){

			$.ajax({
					url: "edit.php",
					type: "POST",
					data:{'user_id':user_id},
					success:function(data){
						$("#update_here").html(data);
					}

			});
	}

function update_user(){

		$username = $("#update_username").val();
		$password = $("#update_password").val();
		$hidden_user_id = $("#hidden_user_id").val();

		if($username == "" || $password == ""){
			alert('Username/Password is empty!');
		}else{

			$.ajax({

				url: "update.php",
				type: "POST",
				data:{'user_id':$hidden_user_id,'username':$username,'password':$password},
				success:function(data){
					if(data == "Success"){
						$("#td_username_"+$hidden_user_id).html($username);
						$("#td_password_"+$hidden_user_id).html($password);
						
						
					}
				}

			});
		}

}

</script>

Username: <input type="text" id="username">
<br><br>
Password: <input type="text" id="password">
<br><br>
<button onclick="create_user()">Add User</button>
<br><hr>
<?php 

	require('db.php');


	$sql = "SELECT * FROM user";

	$pre = $db->prepare($sql);

	$pre->execute();

	echo'
	<table class="tbl_user" border="1" width="40%">
	<tr>
	<th>User ID</th>
	<th>Username</th>
	<th>Password</th>
	<th>Edit</th>
	<th>Delete</th>
	</tr>
	';
	while($row=$pre->fetch(PDO::FETCH_ASSOC)){

		echo'
		<tr id="tr_'.$row['user_id'].'">
			<td>'.$row['user_id'].'</td>
			<td id="td_username_'.$row['user_id'].'">'.$row['username'].'</td>
			<td id="td_password_'.$row['user_id'].'">'.$row['password'].'</td>
			<td><a href="#" onclick="edit_user('.$row['user_id'].');">Edit</a></td>
			<td><a href="#" onclick="delete_user('.$row['user_id'].');">Delete</a></td>
		</tr>
		';
	}

?>
</table>

<div id="update_here"></div>
<br><br>