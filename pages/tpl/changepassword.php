<?php 
session_start();
require('../../class/config.php');

if(isset($_POST['action'])){
	
	if($_POST['action'] == "ChangePasswordForm"){
		
		echo "<div class='alert' style='display:none; margin-bottom:10px;'></div>";
		
		echo "<form name='ChangePasswordForm' role='form' class='form-horizontal'>";
			
			echo "<div class='form-group'>
					<label class='control-label col-lg-4'>Old Password : </label>
					<div class='col-lg-8'>
						<input type='password' class='form-control' name='OldPassword' />
					</div>
				</div>";
			
			echo "<div class='form-group'>
					<label class='control-label col-lg-4'>New Password : </label>
					<div class='col-lg-8'>
						<input type='password' class='form-control' name='NewPassword' />
					</div>
				</div>";
				
			echo "<div class='form-group'>
					<label class='control-label col-lg-4'>Confirm Password : </label>
					<div class='col-lg-8'>
						<input type='password' class='form-control' name='ConfirmPassword' />
					</div>
				</div>";
			
		echo "</form>";
		
	}
	
	if($_POST['action'] == "SavePassword"){
		
		try{
		
			mysqli_autocommit($mysqli, FALSE);
			
			$userid = $_SESSION['empid'];
			$oldpassword = md5($_POST['OldPassword']);
			$newpassword = md5($_POST['NewPassword']);
			
			$password = $mysqli->query("SELECT * FROM user WHERE ID = ".$userid." AND password = '".$oldpassword."'");
			$res = mysqli_fetch_object($password);
			
			if($password->num_rows){
				$mysqli->query("UPDATE user SET password = '".$newpassword."' WHERE ID = $userid");
			}else{
				throw new Exception("Old Password is not valid.");
			}
			
			mysqli_commit($mysqli);
			
			$result['Success'] = 1;
			$result['ErrorMessage'] = "Password has been successfully updated.";
			
		}catch(Exception $e){
		
			mysqli_rollback($mysqli);
			$result['Success'] = 0;
			$result['ErrorMessage'] = $e->getMessage();
		
		}
		
		die(json_encode($result));
		
	}

}

?>