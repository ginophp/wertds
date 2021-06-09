<!DOCTYPE html>
<!--[if IE 7 ]><html lang="en" class="ie7 ielt9 ielt10 en"><![endif]-->
<!--[if IE 8 ]><html lang="en" class="ie8 ielt9 ielt10 en"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="ie9 ielt10 en"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en" class=" en"><!--<![endif]-->
<?php 
error_reporting(0);
include "class/config.php";

$_GET['datefrom']   = date('Y-m-d',strtotime($_GET['datefrom']));
$_GET['dateto']		= date('Y-m-d',strtotime($_GET['dateto']));

$q = $mysqli->query("SELECT e.* FROM employee e
					 INNER JOIN timeinout t ON t.employee_id = e.company_id_no
					 WHERE DATE(t.datetime) BETWEEN '{$_GET['datefrom']}' and '{$_GET['dateto']}' group by e.id");

					 
$datediff = 1;
// = $mysqli->query("SELECT DATEDIFF('{$_GET['dateto']}','{$_GET['datefrom']}') xdatediff;")->fetch_object()->xdatediff;
$num_rows = $q->num_rows;
$px = 60 * $num_rows;
$in = 11 * $num_rows;
 
?>
<style>
    body {
	background: #f0f0f0;
	width: 100vw;
	height: 100vh;
	display: flex;
	justify-content: center;
    padding: 20px;
    height: 100%;
}

@import url('https://fonts.googleapis.com/css?family=Roboto:200,300,400,600,700');

* {
	font-family: 'Roboto', sans-serif;
	font-size: 12px;
	color: #444;
}

#payslip {
	width: calc( 8.5in - 80px );
	/*height: 100%*/;
	height: calc( <?=$in;?>in - <?=$px;?>px );
	background: #fff;
	padding: 30px 40px;
}

#title {
	margin-bottom: 20px;
	font-size: 38px;
	font-weight: 600;
}

#scope {
	border-top: 1px solid #ccc;
	border-bottom: 1px solid #ccc;
	padding: 7px 0 4px 0;
	display: flex;
	justify-content: space-around;
}

#scope > .scope-entry {
	text-align: center;
}

#scope > .scope-entry > .value {
	font-size: 14px;
	font-weight: 700;
}

.content {
	display: flex;
	border-bottom: 1px solid #ccc;
	height: 880px;
}

.content .left-panel {
	border-right: 1px solid #ccc;
	min-width: 200px;
	padding: 20px 16px 0 0;
}

.content .right-panel {
	width: 100%;
	padding: 10px 0  0 16px;
}

#employee {
	text-align: center;
	margin-bottom: 20px;
}
#employee #name {
	font-size: 15px;
	font-weight: 700;
}

#employee #email {
	font-size: 11px;
	font-weight: 300;
}

.details, .contributions, .ytd, .gross {
	margin-bottom: 20px;
}

.details .entry, .contributions .entry, .ytd .entry {
	display: flex;
	justify-content: space-between;
	margin-bottom: 6px;
}

.details .entry .value, .contributions .entry .value, .ytd .entry .value {
	font-weight: 700;
	max-width: 130px;
	text-align: right;
}

.gross .entry .value {
	font-weight: 700;
	text-align: right;
	font-size: 16px;
}

.contributions .title, .ytd .title, .gross .title {
	font-size: 15px;
	font-weight: 700;
	border-bottom: 1px solid #ccc;
	padding-bottom: 4px;
	margin-bottom: 6px;
}

.content .right-panel .details {
	width: 100%;
}

.content .right-panel .details .entry {
	display: flex;
	padding: 0 10px;
	margin: 6px 0;
}

.content .right-panel .details .label {
	font-weight: 700;
	width: 120px;
}

.content .right-panel .details .detail {
	font-weight: 600;
	width: 130px;
}

.content .right-panel .details .rate {
	font-weight: 400;
	width: 80px;
	font-style: italic;
	letter-spacing: 1px;
}

.content .right-panel .details .amount {
	text-align: right;
	font-weight: 700;
	width: 90px;
}

.content .right-panel .details .net_pay div, .content .right-panel .details .nti div {
	font-weight: 600;
	font-size: 12px;
}

.content .right-panel .details .net_pay, .content .right-panel .details .nti {
	padding: 3px 0 2px 0;
	margin-bottom: 10px;
	background: rgba(0, 0, 0, 0.04);
}

</style>




<div id="payslip">
	
	<?php
		if($num_rows):
			while($row = $q->fetch_object()):
	?>
	<div id="title">Payslip</div>
	<div id="scope">
		<div class="scope-entry">
			<div class="title">PAY RUN</div>
			<div class="value"><?=date("M/d/Y");?></div>
		</div>
		<div class="scope-entry">
			<div class="title">PAY PERIOD</div>
			<div class="value"></div>
		</div>
	</div>
	<div class="content">
		<div class="left-panel">
			<div id="employee">
				<div id="name">
					<?php echo $row->first_name." ".$row->middle_name.". ".$row->last_name;?>
				</div>
				<div id="email">
					<?php echo $row->work_email;?>
				</div>
			</div>
			<div class="details">
				<div class="entry">
					<div class="label">Employee ID</div>
					<div class="value"><?php echo $row->company_id_no;?></div>
				</div>
				<div class="entry">
					<div class="label">Tax Status</div>
					<div class="value"></div>
				</div>
				<div class="entry">
					<div class="label">Hourly Rate</div>
					<div class="value"><?php echo number_format((( ($row->cola + $row->salary) / 26 ) / 9 ),2); ?></div>
				</div>
				<div class="entry">
					<div class="label">Company Name</div>
					<div class="value">Alexis A. Molaer</div>
				</div>
				<div class="entry">
					<div class="label">Date Hired</div>
					<div class="value">Dec 1, 1862</div>
				</div>
				<div class="entry">
					<div class="label">Position</div>
					<div class="value"><?=$row->position;?></div>
				</div>
				<div class="entry">
					<div class="label">TIN</div>
					<div class="value"><?=$row->tin_no;?></div>
				</div>
				<div class="entry">
					<div class="label">SSS</div>
					<div class="value"><?=$row->sss_no;?></div>
				</div>
				<div class="entry">
					<div class="label">Philhealth</div>
					<div class="value"><?=$row->philhealth_no;?></div>
				</div>
			</div>
			<div class="gross">
				<div class="title">Gross Semi Income</div>
				<div class="entry">
					<div class="label"></div>
					
					<div class="value"><?php echo number_format($row->salary / 2,2);?></div>
				</div>
			</div>
			
			
			<?php
				// echo 'http://birtaxcalculator.com/ajax_autocalc.php?salary='.$row->salary.'&period=monthly';
				// Get cURL resource
				// Set some options - we are passing in a useragent too here
				// curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_FOLLOWLOCATION=>true,
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => 'http://birtaxcalculator.com/ajax_autocalc.php?salary='.$row->salary.'&period=monthly',
					CURLOPT_USERAGENT => 'Codular Sample cURL Request'
				));
				// Send the request & save response to $resp
				$resp = curl_exec($curl);
				
				// echo $resp;
				$json_decoded = json_decode($resp);
				
				// print_r($json_decoded);
				// die('x');
				curl_close($curl);
			?>
			
			
			
			<div class="contributions">
				<div class="title">Employer Contribution</div>
				<div class="entry">
					<div class="label">SSS</div>
					<div class="value"><?php echo number_format($json_decoded->sss,2);?></div>
				</div>
				<div class="entry">
					<div class="label">Pag-ibig</div>
					<div class="value"><?php echo number_format($json_decoded->pagibig,2);?></div>
				</div>
				<div class="entry">
					<div class="label">PhilHealth</div>
					<div class="value"><?php echo number_format($json_decoded->philhealth,2);?></div>
				</div>
			</div>
			
			
			<div class="ytd">
				<!-- div class="title">Year To Date Figures</div>
				<div class="entry">
					<div class="label">Gross Income</div>
					<div class="value">92,823.86</div>
				</div>
				<div class="entry">
					<div class="label">Taxable Income</div>
					<div class="value">82,705.06</div>
				</div>
				<div class="entry">
					<div class="label">Withholding Tax</div>
					<div class="value">21,548.85</div>
				</div>
				<div class="entry">
					<div class="label">Net Pay</div>
					<div class="value">69,656.21</div>
				</div>
				<div class="entry">
					<div class="label">Allowance</div>
					<div class="value">2,500.00</div>
				</div>
				<div class="entry">
					<div class="label">Bonus</div>
					<div class="value">21,409.34</div>
				</div>
				<div class="entry">
					<div class="label">Commission</div>
					<div class="value">5,500.00</div>
				</div>
				<div class="entry">
					<div class="label">Deduction</div>
					<div class="value">500.00</div>
				</div>
				<div class="entry">
					<div class="label">SSS Employer</div>
					<div class="value">1,178.70</div>
				</div>
				<div class="entry">
					<div class="label">SSS EC Employer</div>
					<div class="value">30.00</div>
				</div>
				<div class="entry">
					<div class="label">PhilHealth Employer</div>
					<div class="value">437.50</div>
				</div>
				<div class="entry">
					<div class="label">Pag-ibig Employer</div>
					<div class="value">100.00</div>
				</div -->
			</div>
		</div>
		<div class="right-panel">
			<div class="details">
				<div class="basic-pay">
					<div class="entry">
						<div class="label">Basic Pay</div>
						<div class="detail"></div>
						<div class="rate"><?php echo number_format(($row->salary / 2) ,2);?>/Semi Month</div>
						
					</div>
				</div>
				
				<div class="salary">
					
					<?php 
					
					$tquery = $mysqli->query("
												SELECT valuefour, id,IsOT, FullName,`Date`,`Day`,TimeInFormat,TimeOutFormat,TotalHours,
													IF(`Day` != 'Sunday', IF(TotalHours < 8,TotalHours - IF(TotalHours > 0,8,0),0),0) UnderTimeLates,
													#REPLACE(FORMAT(( ( salary / 26 ) / 8) * ( IF(TotalHours>8,8,TotalHours) - IF(`Day` != 'Sunday', IF(TotalHours < 8,TotalHours - IF(TotalHours > 0,8,0),0),0) ),2),',','') 
													if(IsOT = 1,format(((( salary / 26 ) / 9 ) + ((( salary / 26 ) / 9 ) * .30)) * IF(TotalHours > 9,9,TotalHours),2),format((( salary / 26 ) / 9 ) * IF(TotalHours > 9,9,TotalHours),2))
														
													 SalaryPerDay
												FROM (
													SELECT  CONCAT(e.first_name,' ',e.middle_name,'. ',e.last_name) FullName,tbla.*,DATE_FORMAT(`Date`, '%W') `Day`,
													#IF(TIMESTAMPDIFF(HOUR, TimeIN, TimeOut)  - 1.67 > 0, TIMESTAMPDIFF(HOUR, TimeIN, TimeOut)  - 1.67,0)
													IF(TIMESTAMPDIFF(HOUR, TimeIN, TimeOut) > 0, TIMESTAMPDIFF(HOUR, TimeIN, TimeOut) ,0)
													TotalHours,( e.cola + e.salary ) salary FROM 
													( SELECT valuefour, tbl.id,IsOT, employee_id,`Date`,
														  TIME_FORMAT(TimeIn, '%h:%i:%s%p') TimeInFormat, 
														  IF(TimeIn=TimeOut,'N/A',TIME_FORMAT(TimeOut, '%h:%i:%s%p')) TimeOutFormat, 
														  TimeIn,
														  TimeOut
														  FROM (
															SELECT valuefour, t.id,IsOT,employee_id,DATE(`datetime`) `Date`,TIME(`datetime`) TimeIn ,
																TIME((SELECT `datetime` FROM timeinout 
																WHERE employee_id = t.employee_id AND DATE(`datetime`) = DATE(t.`datetime`) ORDER BY `datetime` DESC LIMIT 1)
																) TimeOut
															FROM timeinout t
															WHERE employee_id = {$row->company_id_no} and date(datetime) between '{$_GET['datefrom']}' and '{$_GET['dateto']}'
															GROUP BY DATE(t.`datetime`) ORDER BY DATETIME ASC 
														) tbl
													) tbla 
													INNER JOIN employee e ON tbla.employee_id = e.company_id_no ORDER BY tbla.Date ASC
												) tblb ORDER BY tblb.Date ASC");
					
					$salary_per_day = ($row->salary) / 26)) / 8;
					
					$ot = $mysqli->query("select * from ot where employee = {$row->company_id_no}");
					
					
					
					if($tquery->num_rows > 0){
						$SalaryPerDay = 0;
						echo '	<div class="entry">
									<div class="label">Day</div>
									<div class="detail">Time In</div>
									<div class="detail">Time Out</div>
									<div class="amount">Salary per day</div>
								</div>';
						while($trow = $tquery->fetch_object()){
						echo '	<div class="entry">
									<div class="label">'.$trow->Date.'('.$trow->Day.')</div>
									<div class="detail">'.$trow->TimeInFormat.'</div>
									<div class="detail">'.$trow->TimeOutFormat.'</div>
									<div class="amount">'.$trow->SalaryPerDay.'</div>
								</div>';
						$SalaryPerDay += str_replace(',','',$trow->SalaryPerDay);
						}
						echo '	<div class="entry">
									<div class="label">Total</div>
									<div class="detail"></div>
									<div class="detail"></div>
									<div class="amount">'.number_format($SalaryPerDay,2).'</div>
								</div>';
					}
					
					if($ot->num_rows > 0){
						echo '	<div class="entry">
									<div class="label">OT Day</div>
									<div class="amount">Day</div>
									<div class="amount">OT hours</div>
									<div class="amount">OT Salary per day</div>
								</div>';
						$total_otamount = 0;
						while($otr = $ot->fetch_object()){
							
							$ot_amount = $salary_per_day * $otr->ot_hours;
							// regular day 25%
							// weekend 30%
							// holiday if special 30%
							// regular holiday na nag fall ng regular day = 125%
							// regular holiday na nag fall ng weekends day = 130%
							
							$weekDay = date('w', strtotime($otr->date));
							$weekDay = ($weekDay == 0 || $weekDay == 6);
							
							// echo $weekDay;
							// die();
							
							if($weekDay){
								$ot_amount = ($salary_per_day * $otr->ot_hours) + (($salary_per_day * $otr->ot_hours) * .30);
								$percentage = 30;
							}else{
								$ot_amount = ($salary_per_day * $otr->ot_hours) + (($salary_per_day * $otr->ot_hours) * .25);
								$percentage = 25;
							}
							$total_otamount += $ot_amount;
							echo '<div class="entry">
									<div class="label">'.$otr->date.'</div>
									<div class="amount">'.date("D ",strtotime($otr->date)).'</div>
									<div class="amount">'.$otr->ot_hours.'</div>
									<div class="amount">'.number_format($ot_amount,2).'</div>
								  </div>';
						}
						echo '	<div class="entry">
									<div class="label">Total</div>
									<div class="detail"></div>
									<div class="amount"></div>
									<div class="amount">'.number_format($total_otamount,2).'</div>
								</div>';
						
						
					}
					
					?>
					
					
					
				</div>
				<div class="leaves">
					<div class="entry">
						<div class="label">Leaves</div>
						<div class="detail"></div>
						<div class="rate"></div>
						<div class="amount"></div>
					</div>
					<div class="entry paid">
						<div class="label"></div>
						<div class="detail"></div>
						<div class="rate"></div>
						<div class="amount"></div>
					</div>
				</div>
				<div class="contributions">
					<div class="entry">
						<div class="label">Contributions</div>
						<div class="detail"></div>
						<div class="rate"></div>
						<div class="amount"></div>
					</div>
					<div class="entry">
						<div class="label"></div>
						<div class="detail">SSS</div>
						<div class="rate"></div>
						<div class="amount">(<?php echo number_format($json_decoded->sss,2);?>)</div>
					</div>
					<div class="entry">
						<div class="label"></div>
						<div class="detail">Pagibig</div>
						<div class="rate"></div>
						<div class="amount">(<?php echo number_format($json_decoded->pagibig,2);?>)</div>
					</div>
					<div class="entry">
						<div class="label"></div>
						<div class="detail">PhilHealth</div>
						<div class="rate"></div>
						<div class="amount">(<?php echo number_format($json_decoded->philhealth,2);?>)</div>
					</div>
				</div>
				
				<?php
				
						// Get cURL resource
						$curl = curl_init();
						// Set some options - we are passing in a useragent too here
						curl_setopt_array($curl, array(
							CURLOPT_RETURNTRANSFER => 1,
							CURLOPT_URL => 'http://birtaxcalculator.com/ajax_bir_tax2.php',
							CURLOPT_USERAGENT => 'Codular Sample cURL Request',
							CURLOPT_POST => 1,
							CURLOPT_POSTFIELDS => array(
								period				=>	'monthly',
								salary				=> 	str_replace(',','',$row->salary),
								status				=> 	'S',
								sss					=> 	$json_decoded->sss,
								philhealth			=> 	$json_decoded->philhealth,
								pagibig				=> 	$json_decoded->pagibig,
								hmo					=>  '',
								overtime			=>  '',
								night_diff			=>  '',
								holiday_pay			=>  '',
								absent				=>  '',
								tardiness			=>  '',
								undertime			=>  '',
								meal				=>  '',
								transportation		=>  '',
								cola				=>  $row->cola,
								other				=>  '',
								tax_shielded		=>  ''
							)
						));
						// Send the request & save response to $resp
						$resp = curl_exec($curl);
						// Close request to clear up some resources
						
						$json_decodedx = json_decode($resp);

						curl_close($curl);
				
				
				?>
				<div class="withholding_tax">
					<div class="entry">
						<div class="label">Withholding Tax</div>
						<div class="detail"></div>
						<div class="rate"></div>
						<div class="amount">(<?php echo number_format(str_replace(',','',$json_decodedx->tax),2);?>)</div>
					</div>
				</div>
				<div class="deductions">
					<div class="entry">
						<div class="label">Deductions</div>
						<div class="detail">Total Deductions</div>
						<div class="rate"></div>
						<div class="amount">(<?php echo number_format(str_replace(',','',$json_decodedx->total_deductions),2);?>)</div>
					</div>
					<div class="entry">
						<div class="label"></div>
						<div class="detail"></div>
						<div class="rate"></div>
						<div class="amount"></div>
					</div>
				</div>
				<div class="net_pay">
					<div class="entry">
						<div class="label">NET PAY</div>
						<div class="detail"></div>
						<div class="rate"></div>
						<div class="amount"><?php echo number_format(($SalaryPerDay-(str_replace(',','',$json_decodedx->total_deductions) + str_replace(',','',$json_decodedx->tax))),2);?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
			endwhile;
		endif;
	?>
</div>
