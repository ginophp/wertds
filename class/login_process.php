<?php
session_start();
require_once("config.php");
require_once("function.php");
	
	
if($_POST['action'] == 'login'){
    $q = $mysqli->query("select * from user where username ='".$_POST['username']."' and password = md5('".$_POST['password']."')");
	if($q->num_rows>0){
		while($r = $q->fetch_object()){
            if($r->Status == 'Unconfirmed'){
                // 
                die(json_encode(array('result'=>'failed','message'=>'X Your account is not yet activated. Please coordinate with our CSRs.')));
            }
			$_SESSION['username'] = $r->username;
			$_SESSION['AccountType'] = $r->AccountType;
			$_SESSION['empid'] = $r->ID;
			$_SESSION['position'] = $r->position;
			$_SESSION['LastIPAddress'] = $r->LastIPAddress;
			$_SESSION['LastLogin'] = $r->LastLogin;
			$_SESSION['LastSessionCountry'] = $r->LastSessionCountry;
			$_SESSION['employee_id'] = $r->employee_id;
		}
		die(json_encode(array('result'=>'success','message'=>'login successful')));
	}else{
         
            die(json_encode(array('result'=>'failed','message'=>'Incorect username or password.')));
        
    }
}
  	
if($_POST['action'] == 'register'){
    $results = array();
    /*Array ( [rusername] => [rpassword] => [rname] => [raddress] => [rcpno] => [action] => register )*/
    /*validate username.. */
    $validate = $mysqli->query("select * from user where username = '".$_POST['rusername']."'")->num_rows;
    
    
    if($validate>0){
        $results['response'] = 'failed';
        $results['message'] = 'Username Already Taken.';
    }else{
        
        $mysqli->query("INSERT INTO `user` (`username`,`password`,`position`,`Name`,`Address`,`CP`,`email`)
            VALUES
        ('".$_POST['rusername']."',md5('".$_POST['rpassword']."'),'player','".$_POST['rname']."','".$_POST['raddress']."','".$_POST['rcpno']."','".$_POST['email']."')");
       $results['response'] = 'success';
       $results['message'] = 'Registration Success. Please wait for our CSRs to activate your account. For follow up, please email or contact our CSRs. Thank you.'; 
    }
    
    die(json_encode($results));
}
    
?>