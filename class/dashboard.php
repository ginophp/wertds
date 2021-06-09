<?php
session_start();
require_once "config.php";
$result = array();
if($_POST['action'] == 'GetPositiveAndNegativeChart'){
	
	 
	
	$q = $mysqli->query("SELECT COUNT(UPPER(ds.Status)) `Count`, UPPER(`Status`) `Status` FROM demandletter d
						INNER JOIN driverschedule ds ON ds.DLID = d.ID
						WHERE d.CreatedBy = {$_SESSION['empid']} AND ds.`Status` <> '' AND YEAR(ds.DateReturned) = YEAR(CURDATE()) 
						GROUP BY ds.`Status`");
						
	if($q->num_rows){
		while($r = $q->fetch_object()){
			$result[$r->Status] = $r->{"Count"};
		}
	}
}

die(json_encode($result));
?>