<?php 

session_start();
require('../../../class/config.php');
require('../../../library/pagination.php');
$resp=array();
if($_POST['action'] == 'birthdays'){
	$q = $mysqli->query("SELECT *, (year(curdate()) - year(birthdate)) age FROM employee WHERE MONTH(birthdate) = MONTH(NOW()) order by day(birthdate) asc");
	
	if($q->num_rows > 0){
		while($r = $q->fetch_object()){
			$resp['data_handler'][] = $r;
		}
		$resp['response'] = 'success';
	}else{
		$resp['response'] = 'failed.';
		$resp['message'] = 'no record(s) found.';
	}
}
die(json_encode($resp));

?>