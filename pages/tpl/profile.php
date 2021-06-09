<?php 
	
session_start();
require('../../class/config.php');

$userid = $_SESSION['empid'];

if(isset($_POST['action'])){
	
	if($_POST['action'] == "ViewProfile"){
		
		$query = $mysqli->query("SELECT * FROM user WHERE ID = $userid");
		$res = mysqli_fetch_object($query);
		
		echo "<div class='alert' style='display:none; margin-bottom:10px;'></div>";
		echo "<form name='ProfileForm' role='form' class='form-horizontal'>";
		
			echo "<div class='form-group'>
					<label class='control-label col-lg-5'>Name : </label>
					<div class='col-lg-7'>
						<p class='form-control-static'>".$res->Name."</p>
					</div>
				</div>";
			
			echo "<div class='form-group'>
					<label class='control-label col-lg-5'>Position : </label>
					<div class='col-lg-7'>
						<p class='form-control-static'>".ucfirst($res->position)."</p>
					</div>
				</div>";
			
			echo "<div class='form-group'>
					<label class='control-label col-lg-5'>Email : </label>
					<div class='col-lg-7'>
						<p class='form-control-static'>".$res->Email."</p>
					</div>
				</div>";
			
			echo "<div class='form-group'>
					<label class='control-label col-lg-5'>Address : </label>
					<div class='col-lg-7'>
						<p class='form-control-static'>".$res->Address."</p>
					</div>
				</div>";
			
			echo "<div class='form-group'>
					<label class='control-label col-lg-5'>Contact : </label>
					<div class='col-lg-7'>
						<p class='form-control-static'>".((empty($res->CP)) ? "N/A" : $res->CP)."</p>
					</div>
				</div>";
			
			if($res->position == 'supervisor'){
				echo "<div class='form-group'>
						<label class='control-label col-lg-5'>Recovery Officer : </label>
						<div class='col-lg-7'>
							<input type='text' name='RecoveryOfficer' class='form-control input-sm' value='{$res->RecoveryOfficer}' />
						</div>
					</div>";
				
				echo "<div class='form-group'>
						<label class='control-label col-lg-5'>Recovery Unit/Senior Manager : </label>
						<div class='col-lg-7'>
							<input type='text' name='RecoveryUnit' class='form-control input-sm' value='{$res->RecoveryUnit}' />
						</div>
					</div>";
			}
		echo "</form>";
		
	}
	
	if($_POST['action'] == "SaveProfile"){
		
		try{
		
			$RecoveryOfficer = $_POST['RecoveryOfficer'];
			$RecoveryUnit = $_POST['RecoveryUnit'];
			
			$mysqli->query("UPDATE user SET RecoveryOfficer = '{$RecoveryOfficer}', RecoveryUnit = '{$RecoveryUnit}' WHERE ID = {$userid}");
			
			$result["Success"] = 1;			
			$result["ErrorMessage"] = "Your profile has been successfully updated.";			
		
		}catch(Exception $e){
			
			$result['Success'] = 0;
			$result['ErrorMessage'] = $e->getMessage();
			
		}
		
		die(json_encode($result));
	}
	
}
	
?>