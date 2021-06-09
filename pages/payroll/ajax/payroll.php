<?php
session_start();
require('../../../class/config.php');
require('../../../library/pagination.php');


$table = $_POST['table'];
$field = array();
$post = array();
$update = array();
$result = array();
if($_POST['action'] == 'save' || $_POST['action'] == 'update'){
    
    /*
        Array
        (
            [emp_id] => 1
            [days_work] => 
            [ot_hours] => 
            [allowances] => 
            [advances] => 
            [date_from] => 
            [date_to] => 
            [action] => save
            [table] => payroll
        )
    */
    
    $res = $mysqli->query("select * from employee where emp_id = '{$_POST['emp_id']}'")->fetch_object();
    $_POST['salary'] = $res->salary;
    $_POST['overtime_rate_hour'] = $res->overtime_rate_hour;
    
    if(isset($_POST['date_from'])){
        $_POST['date_from']=date("Y-m-d",strtotime($_POST['date_from']));
        $_POST['date_to']=date("Y-m-d",strtotime($_POST['date_to']));
    }
    $descq = $mysqli->query("desc `{$table}`");
    if($descq->num_rows >0){
        while($descr=$descq->fetch_object()){
            if(isset($_POST[$descr->Field])){
                if($_POST['action'] == 'save'){
                    $field[] = "`{$descr->Field}`";
                    $post[]  = "'{$_POST[$descr->Field]}'";
                }else{
                    if($descr->Field != 'ID'){
                        $update[] = "`{$descr->Field}`='{$_POST[$descr->Field]}'";
                    }
                }
            }
        }
    }
    if($_POST['action'] == 'save'){
        $mysqli->query("insert into `{$table}` (".@implode(',',$field).") values (".@implode(',',$post).")");
    }else{
         $mysqli->query("uodate `{$table}` set ".@implode(',',$update)." where ID = {$_POST['updateid']}");
    }
    $result['resp'] = 'success';
}

if($_POST['action'] == 'fetch'){
    $row = 10;
    $start = ($_POST['page'] > 1) ? ($_POST['page'] - 1) * $row : 0;
    $q = $mysqli->query("select * from {$table} LIMIT {$start}, {$row}");
    $totalquery = $mysqli->query("select * from {$table}");
    if($q->num_rows >0){
        while($r=$q->fetch_object()){
           if(isset($r->first_name)){
               $r->full_name = "{$r->first_name} {$r->initial_name} {$r->last_name}";
           }
            
           if(isset($r->birthday)){
               $r->birthday = date("m/d/Y",strtotime($r->birthday));
           }
           $result['data_handler'][] = $r;
        }
        $result['resp'] = 'success';
        $result['Pagination'] = "<ul class='pagination' style='padding:0px; margin:0px;'>".AddPagination($row, $totalquery->num_rows, $_POST['page'], 'showPage')."</ul>";
    }else{
        $result['resp'] = 'failed';
    }
    
}
if($_POST['action'] == 'fetchbiid'){
    $q = $mysqli->query("select * from {$table} where ID = {$_POST['ID']}");
    if($q->num_rows >0){
        while($r=$q->fetch_object()){
           if(isset($r->birthday)){
               $r->birthday = date("m/d/Y",strtotime($r->birthday));
           }
           $result['data_handler'][] = $r;
        }
        $result['resp'] = 'success';
    }else{
        $result['resp'] = 'failed';
    }
    
}

if($_POST['action'] == 'getpayroll'){
    $q = $mysqli->query("select * from {$table} where emp_id = {$_POST['ID']} order by ID desc");
    if($q->num_rows >0){
        while($r=$q->fetch_object()){
           if(isset($r->birthday)){
               $r->birthday = date("m/d/Y",strtotime($r->birthday));
           }
           $result['data_handler'][] = $r;
        }
        $result['resp'] = 'success';
    }else{
        $result['resp'] = 'failed';
    }
}

die(json_encode($result));
?>