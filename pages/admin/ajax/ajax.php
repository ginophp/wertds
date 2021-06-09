<?php

session_start();
require('../../../class/config.php');
$results = array();

if($_POST['action']=='getforms'){
    $result = array();
    $q = $mysqli->query('desc user');
    $notin = array('ID','LastLogin','LastIPAddress','Status','LastSessionCountry','BranchCode');
    if($q->num_rows>0){
        while($r = $q->fetch_object()){
            
            if(!in_array($r->Field,$notin)){
                if($r->Field == 'password'){
                    $result['param_handler'][] =  "<label>{$r->Field}</label> : <input type = 'text' class = 'form-control' value = '' name = '{$r->Field}'>";
                }else if($r->Type == 'datetime'){
                    $result['param_handler'][] =  "{$r->Field} : <input type = 'text' class = 'datepicker form-control' value = '' name = '{$r->Field}'>";
                }else if ($r->Field == 'AccountType'){
                    $selectionq = $mysqli->query("select AccountType from user where position = 'supervisor' group by AccountType");
                    $selection = "<option>[SELECT HERE]</option>";
                    while($selectionr = $selectionq->fetch_object()){
                        $selection .= "<option>{$selectionr->AccountType}</option>";
                    }
                    $result['param_handler'][] =  "<label>{$r->Field}</label> : <select class = 'form-control' value = '' name = '{$r->Field}'>{$selection}</select>";
                }else if ($r->Field == 'position'){
                    $selectionq = $mysqli->query("select position from user where position !='admin'  group by position");
                    $selection = "<option>[SELECT HERE]</option>";
                    while($selectionr = $selectionq->fetch_object()){
                        $selection .= "<option>{$selectionr->position}</option>";
                    }
                    $result['param_handler'][] =  "<label>{$r->Field}</label> : <select class = 'form-control' value = '' name = '{$r->Field}'>{$selection}</select>";
                }else{
                    $result['param_handler'][] =  "<label>{$r->Field}</label> : <input type = 'text' class = 'form-control' value = '' name = '{$r->Field}'>";
                }
            }
           
        }
    }
}

if($_POST['action']=='DoSave'){
    $result = array();
    $q = $mysqli->query('desc user');
    $param=array();
    $field = array();
    
    //$notin = array('ID','position','LastLogin','LastIPAddress','LastSessionCountry','BranchCode');
    if($q->num_rows>0){
        while($r = $q->fetch_object()){
            if(isset($_POST[$r->Field])){
                // $param[] = "'{$_POST[$r->Field]}'";
                $field[] = "`{$r->Field}`";
                if($r->Field == 'password'){
                    $param[] = "md5('{$_POST[$r->Field]}')"; 
                }else{
                    $param[] = "'{$_POST[$r->Field]}'";
                }
            }
        }
        $mysqli->query("insert into user (".@implode(',',$field).") values (".@implode(',',$param).")");
       // echo "insert into (".@implode(',',$field).") values (".@implode(',',$param).")";
		$result['message'] = 'sample12';
    }
}


if($_POST['action'] == 'fetch'){
    $q = $mysqli->query("select * from user");
    if($q->num_rows>0){
        while($r = $q->fetch_object()){
            $result['data_handler'][] = $r;
        }
    }
}

if($_POST['action'] == 'changepassword'){
  
	$mysqli->query("update user set password = md5('".$_POST['password']."') where ID = {$_POST['ID']} ");
	$result['message'] = 'Change password succesfull';
	
   
}



die(json_encode($result));

?>