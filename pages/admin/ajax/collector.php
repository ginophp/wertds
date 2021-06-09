<?php 

session_start();
require('../../../class/config.php');
require('../../../library/pagination.php');

if(isset($_POST['action'])){
	
	//adding new collector
	if($_POST['action'] == "AddCollector"){
		
		try{
			
			$userid = $_SESSION['empid'];
			$name = $_POST['CollectorName'];
			$status = $_POST['CollectorStatus'];
			$alias = $_POST['CollectorAlias'];
			$birthdate = date("Y-m-d", strtotime($_POST['CollectorBirthdate']));
			$number = $_POST['CollectorNumber'];
			$email = $_POST['CollectorEmail'];
			$address = $_POST['CollectorAddress'];
			$title = $_POST['CollectorTitle'];
			
			mysqli_autocommit($mysqli, FALSE);
			
			$st = $mysqli->prepare("INSERT INTO collectors(Name, Status, UserID, Alias, Address, Number, EmailAddress, Birthday, Title, DateRegistered) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
			$st->bind_param("ssissssss", $name, $status, $userid, $alias, $address, $number, $email, $birthdate, $title);
			$st->execute();
			
			$lastid = date("mdY").$mysqli->insert_id;
			$mysqli->query("UPDATE collectors SET Code = '{$lastid}' WHERE ID = {$mysqli->insert_id}");
			
			mysqli_commit($mysqli);
			
			$result['Success'] = 1;
			$result['ErrorMessage'] = "A new collector has been added.";
			
		}catch(Exception $e){
			mysqli_rollback($mysqli);
			$result['Success'] = 0;
			$result['ErrorMessage'] = $e->getMessage();
		}
		
		die(json_encode($result));
		
	}
	
	//update collector
	if($_POST['action'] == "EditCollector"){
		
		try{
			
			mysqli_autocommit($mysqli, FALSE);
			
			$code = $_POST['CollectorCode'];
			$name = $_POST['CollectorName'];
			$alias = $_POST['CollectorAlias'];
			$status = $_POST['CollectorStatus'];
			$address = $_POST['CollectorAddress'];
			$number = $_POST['CollectorNumber'];
			$email = $_POST['CollectorEmail'];
			
			$st = $mysqli->prepare("UPDATE collectors SET Name = ?, Alias = ?, Status = ?, Address = ? , Number = ?  , EmailAddress = ? WHERE Code = ?");
			$st->bind_param("sssssss",$name,$alias, $status, $address,$number,$email,$code);
			$st->execute();
			
			mysqli_commit($mysqli);
			
			$result['Success'] = 1;
			$result['ErrorMessage'] = "Collector has been updated.";
			
		}catch(Exception $e){
			mysqli_rollback($mysqli);
			$result['Success'] = 0;
			$result['ErrorMessage'] = $e->getMessage();
		}
		
		die(json_encode($result));
	
	}
	
	if($_POST['action'] == "ViewCollectors"){
		
		$row = 5;
		$page = $_POST['page'];
		$start = ($page > 1) ? (($page - 1) * $row) : 0;
		
		$userid = $_SESSION['empid'];
		$query = $mysqli->query("SELECT * FROM collectors WHERE UserID = $userid LIMIT $start, $row");
		$total = $mysqli->query("SELECT * FROM collectors WHERE UserID = $userid")->num_rows;
	
		echo '<div class="panel panel-primary">
			
				<div class="panel-heading">Information</div>
				
				<div class="table-responsive">
					<table id = "fetch_data" class="table table-striped table-bordered table-hover">
						<thead>
							<tr class="warning">
								<th>Code</th>
								<th>Name</th>
								<th>Alias</th>
								<th>Birthday</th>
								<th>Status</th>
								<th>Number</th>
								<th>Email</th>
								<th>Address</th>
							</tr>
						</thead>
						<tbody>';
						
						if($query->num_rows){
							while($res = mysqli_fetch_object($query)){
							
							echo '<tr>
								<td>'.$res->Code.'</td>
								<td>'.$res->Name.'</td>
								<td>'.$res->Alias.'</td>
								<td>'.$res->Birthday.'</td>
								<td>'.$res->Status.'</td>
								<td>'.$res->Number.'</td>
								<td>'.$res->EmailAddress.'</td>
								<td>'.$res->Address.'</td>
							</tr>';
						}}else{
							echo '<tr>
								<td colspan="3" align="center">No record found</td>
							</tr>';
						}
						echo '</tbody>
					</table>
				</div>
				
				<div class="panel-footer"><ul class="pagination" style="margin:0;">'.AddPagination($row, $total, $page, "ViewCollectors").'</ul></div>
			
			</div>';
		
	}
	
	if($_POST["action"] == "Pagination"){
		$row = 15;
		$page = $_POST['page'];
		$start = ($page > 1) ? (($page-1) * $row) : 0;
	
		$userid = $_SESSION['empid'];
		$where = "";
		if($_POST['Collector'] > 0){
			$collector = $_POST['Collector'];
			$where = " WHERE UserID = ".$collector;
		}	
		
		$query = $mysqli->query("SELECT * FROM collectors $where
		LIMIT $start, $row");
		$queryTotal = $mysqli->query("SELECT * FROM collectors $where");
	
		$total = $queryTotal->num_rows;
	
		$html = '<table id = "fetch_data" class="table table-striped table-bordered table-hover">
					<thead>
						<tr class="warning">
							<th>Action</th>
							<th>Code</th>
							<th>Name</th>
							<th>Alias</th>
							<th>Birthday</th>
							<th>Status</th>
							<th>Number</th>
							<th>Email</th>
							<th>Address</th>
						</tr>
					</thead>
					<tbody>';

				if($query->num_rows){
					while($res = mysqli_fetch_object($query)){
					
					$html .= '<tr>
							<td align="center">
								<button class="btn btn-warning btn-xs" type="button" name="EditCollector" onclick="EditCollector(\''.$res->Code.'\');">
									<span class="fa fa-edit fa-fw"></span>Edit
								</button>
							</td>
							<td>'.$res->Code.'</td>
							<td>'.$res->Name.'</td>
							<td>'.$res->Alias.'</td>
							<td>'.$res->Birthday.'</td>
							<td>'.$res->Status.'</td>
							<td>'.$res->Number.'</td>
							<td>'.$res->EmailAddress.'</td>
							<td>'.$res->Address.'</td>
						</tr>';
					}
				}else{
					$html .= '<tr>
						<td colspan="4" align="center">No record found</td>
					</tr>';
				}
			
			$html .= '</tbody>
		</table>';
		
		$result["Details"] = $html;
		$result["Pagination"] = AddPagination($row, $total, $page, "showPage");
		die(json_encode($result));
	}
	
}

?>