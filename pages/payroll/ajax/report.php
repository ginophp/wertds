<?php
session_start();
require('../../../class/config.php');
require('../../../library/pagination.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Payslip</title>
</head>
<style type="text/css">
body{
	background-color:#999;}
.wrapper{
	background-color:#FFF;
	width:900px;
	height:600px;
	margin:auto;
	}
.header{
	background-image:url(print/p_header.png);
	height:153px;
	width:365px;
	float:left;}
.header2{
	background-image:url(print/p_header2.png);
	height:153px;
	width:535px;
	float:left;}
.body{
	background-image:url(print/abc-online_03.png);
	
	width:900px;
	}
.name{
	background-color:#fff;
	height:50px;
	width:900px;
	float:left;

	}
.name_{
	background-color:#fff;
	height:100px;
	width:450px;
	float:left;
	}
.payslip{
	background-color:#fff;
	height:100px;
	width:450px;
	float:left;
	}
.payslip2{
	background-color:#fff;
	width:900px;
	float:left;
	}
.payslip2_{
	padding-left:25px;
	}
	td{
		font-size:16px;}
.box{	font-family:Tahoma, Geneva, sans-serif;}
.box1{
	font-weight:bold;
	opacity:0;
	font-size:1px;}
</style>

<body>

<div class="wrapper" title="Right click to print payslip">
<div class="header"><img height="150" src="../../../img/logo.jpg"></div>
<div class="body">
<div class="name"></div>
<div class="name_">
<?php 
 
    $res = $mysqli->query("select * from payroll where ID = {$_POST['ID'][0]}")->fetch_object();
    $resemp = $mysqli->query("select * from employee where emp_id = '{$res->emp_id}'")->fetch_object();
?>
<style type="text/css">
.top1{
	margin-left:25px;}
</style>
<form method="post" action="entry.php" onSubmit="return proceed()">
<table border="0" align="left" width="300" class="top1" cellspacing="0">
  <tr>
    <td class="box" width="">Employee Number</td>
    <td >:<?=$resemp->emp_id;?></td></tr>
     <tr>
    <td class="box">Department</td>
    <td>:<?=$resemp->department;?></td>
  </tr>
  <tr>
  
  <tr>
    <td class="box">Position</td>
    <td>:<?=$resemp->position;?></td>
  </tr>
</table>
<input type="hidden" name="insert" value="x" />

</div>
<div class="payslip">
<table border="0" align="left" width="300"  cellspacing="0">
<tr>
    <td class="box">Lastname</td>
    <td>:<?=$resemp->last_name;?></td>
  </tr>
  <tr>
    <td class="box">Firstname</td>
    <td>:<?=$resemp->first_name;?></td></tr>
  <tr>
    <td class="box">Initial</td>
    <td>:<?=$resemp->initial_name;?></td>
  </tr>
</table>
</div>
</form>
<div class="payslip2">
<div class="payslip2_"> 
<form method="post" action="entry.php" onSubmit="return proceed()">
<table width="" border="0">
<?php
    
    $gross = ($res->salary * $res->days_work) + ($res->overtime_rate_hour * $res->ot_hours) + $res->allowances;
	$paluwagan = $res->paluwagan;
    if ($gross>=50000)
		$tax = $gross * .15;
    if ($gross>=30000 && $gross <=49999)
		$tax = $gross * .10;
    if ($gross>=10000 && $gross <=29999)
		$tax = $gross * .05;
    if ($gross>=5000 && $gross <=9999)
		$tax = $gross * .03;
    if ($gross < 5000)
		$tax = 0;

      $deduction = $tax + $paluwagan;
      $netpay = $gross - $deduction;
  
  ?>
<style type="">
.align{
	word-spacing:285px;}.align1{
	word-spacing:300px;}.align3{
		float:right;}.net{
			margin-right:31px;}
</style>
<table border="1" cellspacing="0">
<tr><td align="left" class="align1"><b>Earnings  Amount</b></td>
<td class="align"><b>Deductions  Amount</b></td>
</tr>
<tr><td>
<table border="0" width="417" cellspacing="0">
   <tr>
    <td class="box1"></td>
    <td class="box1"></td>
  </tr>
  <tr>
    <td class="box" >Basic Pay</td>
    <td align="right"><?=number_format($res->salary,2);?></td>
  </tr>
  <tr>
    <td class="box">Days worked</td>
    <td align="right"><?=$res->days_work;?></td>
  </tr>
  <tr>
    <td class="box">Overtime Rate/Hour</td>
    <td align="right"><?=$res->overtime_rate_hour;?></td>
  </tr>
  <tr>
    <td class="box">OT Hours</td>
    <td align="right"><?=$res->ot_hours;?></td>
  </tr>
  <tr>
    <td class="box">Allowances</td>
    <td align="right"><?=number_format($res->allowances,2);?></td>
  </tr>
     
  <tr>
    <td class="box"></td>
    <td align="right">
</td>
  

  
</table>
</td><td width="">
<table border="0"  width="417" cellspacing="0">
 
	<tr>
		<td class="box">W/Tax</td>
		<td align="right"><?=number_format($tax,2);?></td>
	</tr>
	<tr>
		<td class="box">Paluwagan</td>
		<td align="right"><?=number_format($paluwagan,2);?></td>
	</tr>
   </tr>
  <tr>
    <td class="box"></td>
    <td height="40" width=""></td>
  </tr>
  
</table>
</td></tr></tr>
  <tr><td class="align2"><b>Gross Pay <div class="align3"><?=number_format($gross,2);?></div></b>
  
  </td><td ><b>Total Deductions <div class="align3"><?=number_format($deduction,2);?></div></b></td></tr>
</table>
</br>
<table border="1" width="422" align="right" class="net" cellspacing="0">
<tr>
<td align="left"><b> Net Pay <div class="align3"><?=number_format($netpay,2);?></div></b></td>
</tr>
</table>
<input type="hidden" name="insert" disabled value="x" />
</form></div>

</div>
</div>

</div>
</body>
</html>
