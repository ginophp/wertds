<?php 

session_start();
require('../../../class/config.php');
require('../../../library/pagination.php');
error_reporting(1);
if(isset($_POST['action'])){
	
	
	
	if($_POST["action"] == "Pagination"){
		$action_btn= 1;
		$row =    25;
		$page = $_POST['page'];
		$start = ($page > 1) ? (($page-1) * $row) : 0;
		
		$userid = $_SESSION['empid'];
        $where = array();
		
		if($_POST['Table'] == 'so' || $_POST['Table'] == 'dailysalesreport'  || $_POST['Table'] == 'dailysalesreport_details' ){
			// $where[] = " status = 'Hired'";
			// if($_POST['Table'] == '')
				
			
			/*
				last_name: SANTIAGO
				last_name: 
				so: 
				transaction_date: 
				action: Pagination
				page: 1
				Table: so
			*/
			
			
			if($_POST['Table']  == 'dailysalesreport'){
				$where[] = " so.status = 'confirmed'";
			}
			
			if($_POST['first_name'] != ""){
				$where[] = " dealer.first_name = '{$_POST['first_name']}'";
			}
			
			if($_POST['last_name'] != ""){
				$where[] = " dealer.last_name = '{$_POST['last_name']}'";
			}
			
			if($_POST['so'] != ""){
				$where[] = " so.id = {$_POST['so']}";
			}
			
			if($_POST['transaction_date'] != ""){
				$where[] = " date(so.transaction_date) = '{$_POST['transaction_date']}'";
			}
			
			if(isset($_POST['date_from'])){
				if($_POST['date_from'] != ""){
					$where[] = " date(so.transaction_date) between '{$_POST['date_from']}' and '{$_POST['date_to']}'";
				}
				
			}
			
			
			
		}
		if($_POST['Table'] == 'si_stock_movement' ){
			// $where[] = " status = 'Hired'";
			// if($_POST['Table'] == '')
				
			
			/*
				last_name: SANTIAGO
				last_name: 
				so: 
				transaction_date: 
				action: Pagination
				page: 1
				Table: so
			*/
			
			
			if(isset($_POST['date_from'])){
				if($_POST['date_from'] != ""){
					$where[] = " date(so.transaction_date) between '{$_POST['date_from']}' and '{$_POST['date_to']}'";
				}
				
			}
			
			
			
		}
		
		if($_POST['Table'] == 'no_recruits' ){
			// $where[] = " status = 'Hired'";
			// if($_POST['Table'] == '')
				
			
			/*
				last_name: SANTIAGO
				last_name: 
				so: 
				transaction_date: 
				action: Pagination
				page: 1
				Table: so
			*/
			$where[] = " d.Mother_ID = dealer.`id`";
			
			if(isset($_POST['date_from'])){
				if($_POST['date_from'] != ""){
					$where[] = " date(d.transaction_date) between '{$_POST['date_from']}' and '{$_POST['date_to']}'";
				}
				
			}
			
			
			
		}
		
		if($_POST['Table'] == 'no_recruits_details' ){
			// $where[] = " status = 'Hired'";
			// if($_POST['Table'] == '')
				
			
			/*
				last_name: SANTIAGO
				last_name: 
				so: 
				transaction_date: 
				action: Pagination
				page: 1
				Table: so
			*/
			
			if(isset($_POST['date_from'])){
				if($_POST['date_from'] != ""){
					$where[] = " date(dealer.transaction_date) between '{$_POST['date_from']}' and '{$_POST['date_to']}'";
				}
				
			}
			
			if($_POST['first_name'] != ''){
				$where[] = "dd.first_name like '%{$_POST['first_name']}%'";
			}
			
			
			if($_POST['last_name'] != ''){
				
				$where[] = "dd.last_name like '%{$_POST['last_name']}%'";
				
				
			}
			
			if($_POST['so'] != ''){
				
				$where[] = "dealer.id = '{$_POST['so']}'";
				
				
			}
			
			
		}
		
		
		if($_POST['Table'] == 'search_top_sales_report' ){
		
			$where[] = " so.status = 'confirmed'";
			
			if(isset($_POST['date_from'])){
				if($_POST['date_from'] != ""){
					$where[] = " date(so.transaction_date) between '{$_POST['date_from']}' and '{$_POST['date_to']}'";
				}
				
			}
		}
		
		if($_POST['Table'] == 'search_due_dates' ){
		
			$where[] = " so.status = 'confirmed'";
			$where[] = " outstanding_balance > 0";
			
			if(isset($_POST['due_date'])){
				if($_POST['due_date'] != ""){
					$where[] = " so.due_date <= '{$_POST['due_date']}'";
				}
				
			}
		}
		
		if($_POST['Table'] == 'search_collection_report' ){
		
			 //DATE(DATE) = CURDATE()
			
			if(isset($_POST['date_from'])){
				if($_POST['date_from'] != ""){
					$where[] = " DATE(date) between '{$_POST['date_from']}' and '{$_POST['date_to']}'";
				}else{
					
					$where[] = " DATE(date) curdate()";
				}
				
			}
		}
		
		if($_POST['Table'] == 'sales_report' ){
		
			// $where[] = " d.Mother_ID = dealer.`id`";
			
			if(isset($_POST['date_from'])){
				if($_POST['date_from'] != ""){
					$where[] = " date(so.transaction_date) between '{$_POST['date_from']}' and '{$_POST['date_to']}'";
				}
				
			}
			
			
			
		}
		
		if($_POST['Table'] == 'dealer' ){
			// $where[] = " status = 'Hired'";
			// if($_POST['Table'] == '')
				
			
			/*
				last_name: SANTIAGO
				last_name: 
				so: 
				transaction_date: 
				action: Pagination
				page: 1
				Table: so
			*/
				if($_POST['first_name'] != ""){
					$where[] = " dealer.first_name = '{$_POST['first_name']}'";
				}
			
				if($_POST['last_name'] != ""){
					$where[] = " dealer.last_name = '{$_POST['last_name']}' ";
				}
			
			
				if($_POST['last_name'] != ""){
					$where[] = " dealer.last_name = '{$_POST['last_name']}' ";
				}
				if($_POST['id'] != ""){
					$where[] = "dealer. id = '{$_POST['id']}' ";
				}
			
			
			
		}
		
		$wherecond = "";
		$validation = 0;
		if(count($where) > 0)
		{
			$wherecond = "where ".@implode(' and ',$where)."";
		}
		
		// echo "SELECT * FROM {$_POST['Table']} {$wherecond}";
		
		if($_POST['Table'] == 'product'){
			$query = $mysqli->query("select * from product");			
			$validation =1;
		}elseif($_POST['Table'] == 'creditline'){
			$action_btn= 0;
			// $query = $mysqli->query("SELECT b.company_id_no,concat(b.first_name,' ', b.middle_name,', ',b.last_name) full_name,a.* FROM `{$_POST['Table']}` a inner join employee b on a.employee_id = b.id {$wherecond}  LIMIT $start, $row");			
			
			// echo "SELECT * FROM `{$_POST['Table']}` {$wherecond}  order by soh asc LIMIT $start, $row";
			
			$query = $mysqli->query("select id account_no,first_name,middle_name,last_name,approved_credit_limit,credit_limit from dealer  ");	
			$queryTotal = $mysqli->query("SELECT * FROM `{$_POST['Table']}` {$wherecond}  order by soh asc ");
			
			
			$validation =1;
		}elseif($_POST['Table'] == 'so'){
			// die('x');
			
			if(isset($_POST['report_type'])){
				$action_btn= 0;
				if($_POST['report_type']=='sales_report'){
					
					$query = $mysqli->query("SELECT 
					(SELECT SUM(total_price) FROM so WHERE DATE(transaction_date) = CURDATE()) today,
					'' Achievement_vs_daily_target,
					'' contribution_vs_monthly_target,
					'' daily_target,
					(SELECT SUM(total_price) FROM so WHERE MONTH(transaction_date) = MONTH(CURDATE()) 
					AND YEAR(transaction_date) = YEAR(CURDATE())) MTD_Performance,
					'' percent_Achievement_vs_Monthly_Target,
					'' monthly_target,
					(SELECT SUM(total_price) FROM so WHERE YEAR(transaction_date) = YEAR(CURDATE())) MTD_Performance,
					'' percent_Achievement_vs_Annual_Target,
					'' Annual_Target");
				}elseif($_POST['report_type']=='search_top_sales_report'){
					
					$query = $mysqli->query("SELECT CONCAT(dealer.`first_name`,' ',dealer.`middle_name`,' ',dealer.`last_name`) dealer_name,
											FORMAT(SUM(total_price),2) sales_gross_amount,  
											FORMAT(SUM(total_price) - ( SUM(dealer_discount)),2) dgs_amount FROM so
											INNER JOIN dealer ON dealer.id = so.dealer
											 {$wherecond}  
											GROUP BY dealer 
											ORDER BY  SUM(total_price) DESC ");
				}elseif($_POST['report_type'] == 'collection_report'){
					$query = $mysqli->query("SELECT 
											(SELECT SUM(amount) today FROM official_receipt WHERE mode_of_payment = 'CASH' AND 
											DATE(transaction_date) = CURDATE()) today_cash,

											(SELECT SUM(amount) today FROM official_receipt WHERE mode_of_payment = 'check_payment' AND 
											DATE(transaction_date) = CURDATE()) today_check,

											(SELECT SUM(amount) today FROM official_receipt WHERE mode_of_payment = 'CASH' AND 
											MONTH(transaction_date) = MONTH(CURDATE()) AND  YEAR(transaction_date) = YEAR(CURDATE()))  monthly_cash,

											(SELECT SUM(amount) today FROM official_receipt WHERE mode_of_payment = 'CHECK' AND 
											MONTH(transaction_date) = MONTH(CURDATE()) AND  YEAR(transaction_date) = YEAR(CURDATE()))  monthly_check,


											(SELECT SUM(amount) today FROM official_receipt WHERE mode_of_payment = 'CASH' AND 
											 YEAR(transaction_date) = YEAR(CURDATE()))  annual_cash,

											(SELECT SUM(amount) today FROM official_receipt WHERE mode_of_payment = 'CHECK' AND 
											YEAR(transaction_date) = YEAR(CURDATE()))  anual_check");
				}
			}else{
				
				
				
				$query = $mysqli->query("SELECT so.id DR_NO,concat(dealer.first_name,' ',dealer.last_name) dealer_name,
				concat(dd.first_name,' ',dd.last_name) mother_name,
				us.username ,
				so.* FROM `{$_POST['Table']}` 
										inner join dealer on dealer.id = {$_POST['Table']}.dealer 
										left join dealer dd on dealer.Mother_ID = dd.ID 
										left join user us on so.created_by = us.id
										{$wherecond}  
										order by so.id desc
										#LIMIT $start, $row");
			}
			
				
			$validation = 1;
			
		}elseif($_POST['Table'] == 'boma_summary_report'){
			// die('x');
			$action_btn= 0;
			$query = $mysqli->query("
								
									SELECT * FROM (
									SELECT CONCAT(dealer.first_name,' ',dealer.`middle_name`, ' ',dealer.last_name) dealer_name,
									FORMAT(SUM(total_price),2) csp ,	
									FORMAT(SUM(total_price) -  SUM(dealer_discount),2) dgs ,
									FORMAT(SUM(total_price) -  SUM(dealer_discount) - SUM(dealer_discount),2) invoice_amount ,
									FORMAT(SUM(dealer_discount),2) additional_discount
									FROM so 
									INNER JOIN dealer ON dealer.id = so.dealer
									WHERE dealer = {$_POST['boma']} AND so.status = 'confirmed' 
									and date(so.transaction_date) between  '{$_POST['date_from']}' and '{$_POST['date_to']}'
									UNION ALL 
									SELECT CONCAT(dealer.first_name,' ',dealer.`middle_name`, ' ',dealer.last_name) dealer_name,
									FORMAT(SUM(total_price),2) csp ,
									FORMAT(SUM(total_price) -  SUM(dealer_discount),2) dgs ,
									FORMAT(SUM(total_price) -  SUM(dealer_discount) - SUM(dealer_discount),2) invoice_amount,
									FORMAT(SUM(dealer_discount),2) additional_discount
									FROM so 
									INNER JOIN dealer ON dealer.id = so.dealer
									WHERE dealer.`Mother_ID` = {$_POST['boma']}  AND  dealer.level = 'BOA'  AND so.status = 'confirmed' 
									and date(so.transaction_date) between  '{$_POST['date_from']}' and '{$_POST['date_to']}'
									GROUP BY dealer.id 
									) tbl 
								UNION ALL
								SELECT 'Total ',FORMAT(SUM(csp),2),FORMAT(SUM(dgs),2),FORMAT(SUM(invoice_amount),2),FORMAT(SUM(additional_discount),2) FROM (
									SELECT CONCAT(dealer.first_name,' ',dealer.`middle_name`, ' ',dealer.last_name) dealer_name,
									SUM(total_price) csp ,
									SUM(total_price) -  SUM(dealer_discount) dgs ,
									SUM(total_price) -  SUM(dealer_discount) - SUM(dealer_discount) invoice_amount,
									SUM(dealer_discount) additional_discount
									FROM so 
									INNER JOIN dealer ON dealer.id = so.dealer
									WHERE dealer = {$_POST['boma']} AND so.status = 'confirmed' 
									and date(so.transaction_date) between  '{$_POST['date_from']}' and '{$_POST['date_to']}'
									UNION ALL 
									SELECT CONCAT(dealer.first_name,' ',dealer.`middle_name`, ' ',dealer.last_name) dealer_name,
									SUM(total_price) csp ,
									SUM(total_price) -  SUM(dealer_discount) dgs ,
									SUM(total_price) -  SUM(dealer_discount) - SUM(dealer_discount) invoice_amount,
									SUM(dealer_discount) additional_discount
									FROM so 
									INNER JOIN dealer ON dealer.id = so.dealer
									WHERE dealer.`Mother_ID` = {$_POST['boma']}  AND  dealer.level = 'BOA' and so.status = 'confirmed' 
									and date(so.transaction_date) between  '{$_POST['date_from']}' and '{$_POST['date_to']}'
								) tbla
");


		
		// $query = $mysqli->query("
										
										// SELECT *, 
										// FORMAT(REPLACE(personal_dgs_less_cpi,',','') +  REPLACE(IFNULL(boa_dgs_less_cpi,0),',','') ,2) group_dgs_less_cpi FROM (
										// SELECT 
										// dealer.id dealer_account_no,
										// CONCAT(dealer.first_name,' ',dealer.`middle_name`, ' ',dealer.last_name) dealer_name, `level`,
										// FORMAT(SUM(total_price),2) personal_csp ,	
										// FORMAT(SUM(cpi),2) personal_cpi ,
										// FORMAT(SUM(total_price) -  SUM(dealer_discount),2) personal_dgs ,
										// FORMAT(SUM(total_price-cpi-dealer_discount),2) personal_dgs_less_cpi ,	
										// FORMAT(SUM(dealer_discount),2) personal_additional_discount,
										// FORMAT(SUM(total_price) -  SUM(dealer_discount) - dealer_discount ,2)  personal_dgs_less_addi_discount,


										// (
										// SELECT 
											// FORMAT(SUM(sox.total_price),2) boa_csp 
											// FROM so sox
											// INNER JOIN dealer d ON d.id = sox.dealer
											// WHERE 

											// d.`Mother_ID` = dealer.id AND d.level = 'boa'  AND sox.status = 'confirmed' 
											// AND DATE(sox.transaction_date) BETWEEN  '{$_POST['date_from']}' AND '{$_POST['date_to']}'
										// ) boa_csp,


										// (
										// SELECT 
											// FORMAT(SUM(cpi),2)   
											// FROM so sox
											// INNER JOIN dealer d ON d.id = sox.dealer
											// WHERE 

											// d.`Mother_ID` = dealer.id AND d.level = 'boa'  AND sox.status = 'confirmed' 
											// AND DATE(sox.transaction_date) BETWEEN  '{$_POST['date_from']}' AND '{$_POST['date_to']}'
										// ) boa_cpi,
										// (
										// SELECT 
											// FORMAT(SUM(total_price) -  SUM(dealer_discount),2)
											// FROM so sox
											// INNER JOIN dealer d ON d.id = sox.dealer
											// WHERE 

											// d.`Mother_ID` = dealer.id AND d.level = 'boa'  AND sox.status = 'confirmed' 
											// AND DATE(sox.transaction_date) BETWEEN  '{$_POST['date_from']}' AND '{$_POST['date_to']}'
										// ) boa_dgs,
										// (SELECT 
											// FORMAT(SUM(total_price-cpi-dealer_discount),2) 	
											// FROM so sox
											// INNER JOIN dealer d ON d.id = sox.dealer
											// WHERE 

											// d.`Mother_ID` = dealer.id AND d.level = 'boa'  AND sox.status = 'confirmed' 
											// AND DATE(sox.transaction_date) BETWEEN  '{$_POST['date_from']}' AND '{$_POST['date_to']}'
										// ) boa_dgs_less_cpi
										// ,
										// (SELECT 
											// FORMAT(SUM(dealer_discount),2) 

											// FROM so sox
											// INNER JOIN dealer d ON d.id = sox.dealer
											// WHERE 

											// d.`Mother_ID` = dealer.id AND d.level = 'boa'  AND sox.status = 'confirmed' 
											// AND DATE(sox.transaction_date) BETWEEN  '{$_POST['date_from']}' AND '{$_POST['date_to']}'
										// ) boa_additional_discount,

										// (SELECT 
											// FORMAT(SUM(total_price) -  SUM(dealer_discount) - dealer_discount ,2)  
											// FROM so sox
											// INNER JOIN dealer d ON d.id = sox.dealer
											// WHERE 

											// d.`Mother_ID` = dealer.id AND d.level = 'boa'  AND sox.status = 'confirmed' 
											// AND DATE(sox.transaction_date) BETWEEN  '{$_POST['date_from']}' AND '{$_POST['date_to']}'
										// ) boa_dgs_less_addi_discount,

										// '' boa_active_based_on_parameter

										// FROM so 
										// INNER JOIN dealer ON dealer.id = so.dealer
										// WHERE `level` IN ('boma','bom') AND 
										// so.status = 'confirmed' 
										// and date(so.transaction_date) between  '{$_POST['date_from']}' and '{$_POST['date_to']}'
										// GROUP BY so.dealer
										// ) tbl
										// ");
			
			
				
			$validation = 1;
			
		}elseif($_POST['Table'] == 'boma_details_report'){
			// die('x');
			$action_btn= 0;
			// $query = $mysqli->query("
								
									// SELECT * FROM (
									// SELECT CONCAT(dealer.first_name,' ',dealer.`middle_name`, ' ',dealer.last_name) dealer_name,
									// FORMAT(SUM(total_price),2) csp ,	
									// FORMAT(SUM(total_price) -  SUM(dealer_discount),2) dgs ,
									// FORMAT(SUM(total_price) -  SUM(dealer_discount) - SUM(dealer_discount),2) invoice_amount ,
									// FORMAT(SUM(dealer_discount),2) additional_discount
									// FROM so 
									// INNER JOIN dealer ON dealer.id = so.dealer
									// WHERE dealer = {$_POST['boma']} AND so.status = 'confirmed' 
									// and date(so.transaction_date) between  '{$_POST['date_from']}' and '{$_POST['date_to']}'
									// UNION ALL 
									// SELECT CONCAT(dealer.first_name,' ',dealer.`middle_name`, ' ',dealer.last_name) dealer_name,
									// FORMAT(SUM(total_price),2) csp ,
									// FORMAT(SUM(total_price) -  SUM(dealer_discount),2) dgs ,
									// FORMAT(SUM(total_price) -  SUM(dealer_discount) - SUM(dealer_discount),2) invoice_amount,
									// FORMAT(SUM(dealer_discount),2) additional_discount
									// FROM so 
									// INNER JOIN dealer ON dealer.id = so.dealer
									// WHERE dealer.`Mother_ID` = {$_POST['boma']}  AND so.status = 'confirmed' 
									// and date(so.transaction_date) between  '{$_POST['date_from']}' and '{$_POST['date_to']}'
									// GROUP BY dealer.id 
									// ) tbl 
								// UNION ALL
								// SELECT 'Total ',FORMAT(SUM(csp),2),FORMAT(SUM(dgs),2),FORMAT(SUM(invoice_amount),2),FORMAT(SUM(additional_discount),2) FROM (
									// SELECT CONCAT(dealer.first_name,' ',dealer.`middle_name`, ' ',dealer.last_name) dealer_name,
									// SUM(total_price) csp ,
									// SUM(total_price) -  SUM(dealer_discount) dgs ,
									// SUM(total_price) -  SUM(dealer_discount) - SUM(dealer_discount) invoice_amount,
									// SUM(dealer_discount) additional_discount
									// FROM so 
									// INNER JOIN dealer ON dealer.id = so.dealer
									// WHERE dealer = {$_POST['boma']} AND so.status = 'confirmed' 
									// and date(so.transaction_date) between  '{$_POST['date_from']}' and '{$_POST['date_to']}'
									// UNION ALL 
									// SELECT CONCAT(dealer.first_name,' ',dealer.`middle_name`, ' ',dealer.last_name) dealer_name,
									// SUM(total_price) csp ,
									// SUM(total_price) -  SUM(dealer_discount) dgs ,
									// SUM(total_price) -  SUM(dealer_discount) - SUM(dealer_discount) invoice_amount,
									// SUM(dealer_discount) additional_discount
									// FROM so 
									// INNER JOIN dealer ON dealer.id = so.dealer
									// WHERE dealer.`Mother_ID` = {$_POST['boma']}  AND so.status = 'confirmed' 
									// and date(so.transaction_date) between  '{$_POST['date_from']}' and '{$_POST['date_to']}'
								// ) tbla
// ");
	
		echo "SELECT *, 
										FORMAT(REPLACE(personal_dgs_less_cpi,',','') +  REPLACE(IFNULL(boa_dgs_less_cpi,0),',','') ,2) group_dgs_less_cpi FROM (
										SELECT 
										dealer.id dealer_account_no,
										CONCAT(dealer.first_name,' ',dealer.`middle_name`, ' ',dealer.last_name) dealer_name, `level`,
										FORMAT(SUM(total_price),2) personal_csp ,	
										FORMAT(SUM(cpi),2) personal_cpi ,
										FORMAT(SUM(total_price) -  SUM(dealer_discount),2) personal_dgs ,
										FORMAT(SUM(total_price-cpi-dealer_discount),2) personal_dgs_less_cpi ,	
										FORMAT(SUM(dealer_discount),2) personal_additional_discount,
										FORMAT(SUM(total_price) -  SUM(dealer_discount) - dealer_discount ,2)  personal_dgs_less_addi_discount,


										(
										SELECT 
											FORMAT(SUM(sox.total_price),2) boa_csp 
											FROM so sox
											INNER JOIN dealer d ON d.id = sox.dealer
											WHERE 

											d.`Mother_ID` = dealer.id AND d.level = 'boa'  AND sox.status = 'confirmed' 
											AND DATE(sox.transaction_date) BETWEEN  '{$_POST['date_from']}' AND '{$_POST['date_to']}'
										) boa_csp,


										(
										SELECT 
											FORMAT(SUM(cpi),2)   
											FROM so sox
											INNER JOIN dealer d ON d.id = sox.dealer
											WHERE 

											d.`Mother_ID` = dealer.id AND d.level = 'boa'  AND sox.status = 'confirmed' 
											AND DATE(sox.transaction_date) BETWEEN  '{$_POST['date_from']}' AND '{$_POST['date_to']}'
										) boa_cpi,
										(
										SELECT 
											FORMAT(SUM(total_price) -  SUM(dealer_discount),2)
											FROM so sox
											INNER JOIN dealer d ON d.id = sox.dealer
											WHERE 

											d.`Mother_ID` = dealer.id AND d.level = 'boa'  AND sox.status = 'confirmed' 
											AND DATE(sox.transaction_date) BETWEEN  '{$_POST['date_from']}' AND '{$_POST['date_to']}'
										) boa_dgs,
										(SELECT 
											FORMAT(SUM(total_price-cpi-dealer_discount),2) 	
											FROM so sox
											INNER JOIN dealer d ON d.id = sox.dealer
											WHERE 

											d.`Mother_ID` = dealer.id AND d.level = 'boa'  AND sox.status = 'confirmed' 
											AND DATE(sox.transaction_date) BETWEEN  '{$_POST['date_from']}' AND '{$_POST['date_to']}'
										) boa_dgs_less_cpi
										,
										(SELECT 
											FORMAT(SUM(dealer_discount),2) 

											FROM so sox
											INNER JOIN dealer d ON d.id = sox.dealer
											WHERE 

											d.`Mother_ID` = dealer.id AND d.level = 'boa'  AND sox.status = 'confirmed' 
											AND DATE(sox.transaction_date) BETWEEN  '{$_POST['date_from']}' AND '{$_POST['date_to']}'
										) boa_additional_discount,

										(SELECT 
											FORMAT(SUM(total_price) -  SUM(dealer_discount) - dealer_discount ,2)  
											FROM so sox
											INNER JOIN dealer d ON d.id = sox.dealer
											WHERE 

											d.`Mother_ID` = dealer.id AND d.level = 'boa'  AND sox.status = 'confirmed' 
											AND DATE(sox.transaction_date) BETWEEN  '{$_POST['date_from']}' AND '{$_POST['date_to']}'
										) boa_dgs_less_addi_discount,

										'' boa_active_based_on_parameter

										FROM so 
										INNER JOIN dealer ON dealer.id = so.dealer
										WHERE `level` IN ('boma','bom') AND 
										so.status = 'confirmed' 
										and date(so.transaction_date) between  '{$_POST['date_from']}' and '{$_POST['date_to']}'
										GROUP BY so.dealer
										) tbl";

		
		$query = $mysqli->query("
										
										SELECT *, 
										FORMAT(REPLACE(personal_dgs_less_cpi,',','') +  REPLACE(IFNULL(boa_dgs_less_cpi,0),',','') ,2) group_dgs_less_cpi FROM (
										SELECT 
										dealer.id dealer_account_no,
										CONCAT(dealer.first_name,' ',dealer.`middle_name`, ' ',dealer.last_name) dealer_name, `level`,
										FORMAT(SUM(total_price),2) personal_csp ,	
										FORMAT(SUM(cpi),2) personal_cpi ,
										FORMAT(SUM(total_price) -  SUM(dealer_discount),2) personal_dgs ,
										FORMAT(SUM(total_price-cpi-dealer_discount),2) personal_dgs_less_cpi ,	
										FORMAT(SUM(dealer_discount),2) personal_additional_discount,
										FORMAT(SUM(total_price) -  SUM(dealer_discount) - dealer_discount ,2)  personal_dgs_less_addi_discount,


										(
										SELECT 
											FORMAT(SUM(sox.total_price),2) boa_csp 
											FROM so sox
											INNER JOIN dealer d ON d.id = sox.dealer
											WHERE 

											d.`Mother_ID` = dealer.id AND d.level = 'boa'  AND sox.status = 'confirmed' 
											AND DATE(sox.transaction_date) BETWEEN  '{$_POST['date_from']}' AND '{$_POST['date_to']}'
										) boa_csp,


										(
										SELECT 
											FORMAT(SUM(cpi),2)   
											FROM so sox
											INNER JOIN dealer d ON d.id = sox.dealer
											WHERE 

											d.`Mother_ID` = dealer.id AND d.level = 'boa'  AND sox.status = 'confirmed' 
											AND DATE(sox.transaction_date) BETWEEN  '{$_POST['date_from']}' AND '{$_POST['date_to']}'
										) boa_cpi,
										(
										SELECT 
											FORMAT(SUM(total_price) -  SUM(dealer_discount),2)
											FROM so sox
											INNER JOIN dealer d ON d.id = sox.dealer
											WHERE 

											d.`Mother_ID` = dealer.id AND d.level = 'boa'  AND sox.status = 'confirmed' 
											AND DATE(sox.transaction_date) BETWEEN  '{$_POST['date_from']}' AND '{$_POST['date_to']}'
										) boa_dgs,
										(SELECT 
											FORMAT(SUM(total_price-cpi-dealer_discount),2) 	
											FROM so sox
											INNER JOIN dealer d ON d.id = sox.dealer
											WHERE 

											d.`Mother_ID` = dealer.id AND d.level = 'boa'  AND sox.status = 'confirmed' 
											AND DATE(sox.transaction_date) BETWEEN  '{$_POST['date_from']}' AND '{$_POST['date_to']}'
										) boa_dgs_less_cpi
										,
										(SELECT 
											FORMAT(SUM(dealer_discount),2) 

											FROM so sox
											INNER JOIN dealer d ON d.id = sox.dealer
											WHERE 

											d.`Mother_ID` = dealer.id AND d.level = 'boa'  AND sox.status = 'confirmed' 
											AND DATE(sox.transaction_date) BETWEEN  '{$_POST['date_from']}' AND '{$_POST['date_to']}'
										) boa_additional_discount,

										(SELECT 
											FORMAT(SUM(total_price) -  SUM(dealer_discount) - dealer_discount ,2)  
											FROM so sox
											INNER JOIN dealer d ON d.id = sox.dealer
											WHERE 

											d.`Mother_ID` = dealer.id AND d.level = 'boa'  AND sox.status = 'confirmed' 
											AND DATE(sox.transaction_date) BETWEEN  '{$_POST['date_from']}' AND '{$_POST['date_to']}'
										) boa_dgs_less_addi_discount,

										'' boa_active_based_on_parameter

										FROM so 
										INNER JOIN dealer ON dealer.id = so.dealer
										WHERE `level` IN ('boma','bom') AND 
										so.status = 'confirmed' 
										and date(so.transaction_date) between  '{$_POST['date_from']}' and '{$_POST['date_to']}'
										GROUP BY so.dealer
										) tbl
										");
			
			
				
			$validation = 1;
			
		}elseif($_POST['Table'] == 'dss'){
			// die('x');
			// $action_btn= 0;
			$query = $mysqli->query("
										SELECT dss.id,dss.date,dss.`delivery_no`,product.`description`,dss.qty,dss.`inventory_type`,dss.branch FROM dss
INNER JOIN product ON product.code = dss.product");
			
			
				
			$validation = 1;
			
		}elseif($_POST['Table'] == 'dealer'){
			// die('x');
			// $action_btn= 0;
			$query = $mysqli->query("
										SELECT dealer.id, dealer.id account_no, dealer.first_name,dealer.middle_name,dealer.last_name,
										CONCAT(dd.first_name, ' ',dd.last_name) mother_name,
										CONCAT(ddd.first_name, ' ',ddd.last_name) recruiter_name,
										(SELECT DATE(transaction_date) FROM so WHERE dealer = dealer.id ORDER BY id ASC LIMIT 1)appointment_date,
										dealer.level
										FROM dealer
										LEFT JOIN dealer dd ON dd.id = dealer.mother_id
										LEFT JOIN dealer ddd ON ddd.id = dealer.`Recruiter_ID`
										{$wherecond}  
										
										#LIMIT $start, $row");
			
			
				
			$validation = 1;
			
		}elseif($_POST['Table'] == 'dailysalesreport'){
			// die('x');
			$action_btn= 0;
			$query = $mysqli->query("
										SELECT so.id id_no,CONCAT(dealer.first_name,' ',dealer.`middle_name`,' ', dealer.`last_name` ) full_name,
										date(so.transaction_date) transaction_date,
										FORMAT(total_price,2) Gross_Amount, 
										FORMAT(cpi,2) cpi, 
										
										FORMAT(so.`vat`,2) vat, 
										FORMAT(so.`dealer_discount`,2) dealer_discount, 
										FORMAT(so.`additional_discount`,2) additional_discount, 
										FORMAT((total_price - dealer_discount),2) dgs,
										FORMAT((total_price - (dealer_discount + additional_discount)),2) Net_Amount,
										so.status
										FROM so 
										INNER JOIN dealer ON dealer.id = so.dealer
										{$wherecond}  
										
										#LIMIT $start, $row");
			
			
				
			$validation = 1;
			
		}elseif($_POST['Table'] == 'dailysalesreport_details'){
			// die('x');
			$action_btn= 0;
			
			
			
			$query = $mysqli->query("
										select so.id so_no, so_details.product, so_details.`product_description`,
										so_details.qty, format(so_details.`sub_total`,2) sub_total,


										format(IF(IFNULL(product.`is_nontrade`,0)=1,0,(so_details.`sub_total` * .20)),2) basic_discount,
										so.`transaction_date` po_date , so.`status`

										from 
										so_details
										left join product on so_details.`product` = product.code
										inner join so on so.id = so_details.si

										{$wherecond}  
										order by so.id asc
										
										#LIMIT $start, $row");
			
			
				
			$validation = 1;
			
		}elseif($_POST['Table'] == 'si_stock_movement'){
			// die('x');
			$action_btn= 0;
				
			$query = $mysqli->query("
										SELECT so.id id_no,product,product_description,promo_code,qty ,so.transaction_date
										FROM so_details so_details
										INNER JOIN so so ON so.id = so_details.id
										{$wherecond}  
										#LIMIT $start, $row");
			
			
				
			$validation = 1;
			
		}elseif($_POST['Table'] == 'no_recruits'){
			$action_btn= 0;
				
			$query = $mysqli->query("select * from (
										SELECT 
										id account_no, CONCAT(dealer.`first_name`,' ', dealer.`middle_name`, ' ', dealer.`last_name`) Mother_Name,`level`,
										(SELECT COUNT(*) FROM dealer d  {$wherecond} and d.Mother_ID = dealer.id ) no_of_recruits
										FROM dealer  
										WHERE `level` IN ('boma','bom')
										#LIMIT $start, $row
										) tbl where no_of_recruits > 0 order by no_of_recruits desc");
			
			
				
			$validation = 1;
			
		}elseif($_POST['Table'] == 'no_recruits_details'){
			$action_btn= 0;
				
			$query = $mysqli->query("SELECT 
									CONCAT(dd.first_name,' ',dd.`middle_name`,' ',dd.`last_name`) Mother_Dealer,dd.level Mother_Level,
									CONCAT(dealer.first_name,' ',dealer.`middle_name`,' ',dealer.`last_name`) Recruiter_Name, 
									dealer.level Recruit_Level,
									dealer.`transaction_date` Date_Recruit
									FROM dealer 
									INNER JOIN dealer dd ON dealer.Mother_ID = dd.id
									{$wherecond}
									
									ORDER BY dealer.`transaction_date` ASC ");
			
			
				
			$validation = 1;
			
		}elseif($_POST['Table'] == 'search_due_dates'){
			// die('x');
			$action_btn= 0;
				
			$query = $mysqli->query("
								SELECT so.id order_no, CONCAT(dealer.`first_name`,' ',dealer.`middle_name`,' ',dealer.last_name) dealer_name, 
								dealer.mobile_number,
								CONCAT(dd.`first_name`,' ',dd.`middle_name`,' ',dd.last_name) BOMA, 
								date(so.transaction_date) transaction_date,
								date(so.delivery_date) delivery_date,
								
								due_date ,
								if(DATEDIFF(CURDATE(),due_date)>0,DATEDIFF(CURDATE(),due_date),0) no_days_due,
								total_price gross_amount, 
								dealer_discount,additional_discount,
								(total_price - dealer_discount ) dgs_amount,outstanding_balance  
								FROM so 
								INNER JOIN dealer ON dealer.id = so.dealer
								LEFT JOIN dealer dd ON dealer.Mother_ID = dd.id
								
								 {$wherecond}  
								ORDER BY due_date ASC ");
			
			
				
			$validation = 1;
			
		}elseif($_POST['Table'] == 'search_collection_report'){
			// die(
			$action_btn= 0;
			
				
			$query = $mysqli->query("
								SELECT 'CASH' mop, FORMAT(IFNULL(SUM(amount),0.00),2) amount FROM official_receipt  {$wherecond} and mode_of_payment = 'CASH'
								UNION ALL
								SELECT 'CHECK', FORMAT(IFNULL(SUM(amount),0.00),2) FROM official_receipt {$wherecond}   and mode_of_payment = 'CHECK'
								UNION ALL                                                                
								SELECT 'ONINE', FORMAT(IFNULL(SUM(amount),0.00),2) FROM official_receipt  {$wherecond}  and mode_of_payment = 'ONLINE'
								UNION ALL 
								SELECT 'TOTAL', FORMAT(IFNULL(SUM(amount),0.00),2) FROM official_receipt   {$wherecond}  

								
								
								#ORDER BY due_date ASC ");
			
			
				
			$validation = 1;
			
		}elseif($_POST['Table'] == 'search_top_sales_report'){
			// die('x');
			$action_btn= 0;
				
		$query = $mysqli->query("SELECT CONCAT(dealer.`first_name`,' ',dealer.`middle_name`,' ',dealer.`last_name`) dealer_name,
											FORMAT(SUM(total_price),2) sales_gross_amount,  
											FORMAT(SUM(total_price) - ( SUM(dealer_discount)),2) dgs_amount FROM so
											INNER JOIN dealer ON dealer.id = so.dealer
											 {$wherecond}  
											GROUP BY dealer ");
			
			
				
			$validation = 1;
			
		}elseif($_POST['Table'] == 'sales_report'){
			// die('x');
			$action_btn= 0;
				
			$query = $mysqli->query("
										SELECT 
										(
											SELECT COUNT(*) FROM dealer WHERE LEVEL = 'BOMA' 
											AND MONTH(transaction_date) = MONTH(CURDATE()) 
											AND YEAR(transaction_date) = YEAR(CURDATE()) 
										) BOMA_ENROLLED,
										(
											SELECT FORMAT(SUM(total),2) FROM ( 
												SELECT SUM(total_price) total FROM so
												INNER JOIN dealer ON dealer.id = so.dealer
												 
												{$wherecond} AND 
												dealer.mother_id IN (
												
													SELECT id FROM dealer WHERE LEVEL = 'BOMA'
												) AND dealer.level = 'BOA'
												#AND MONTH(so.transaction_date) = MONTH(CURDATE()) 
												#AND YEAR(so.transaction_date) = YEAR(CURDATE()) 
												
												AND so.status='confirmed'

												UNION ALL 
												
												SELECT SUM(total_price) FROM so
												INNER JOIN dealer ON dealer.id = so.dealer
												{$wherecond} AND  
												dealer.id IN (
												
													SELECT id FROM dealer WHERE LEVEL = 'BOMA'
												)
												#AND MONTH(so.transaction_date) = MONTH(CURDATE()) 
												#AND YEAR(so.transaction_date) = YEAR(CURDATE()) 
												AND so.status='confirmed'
											) tbl 
										) SALES_BOMA,

										(
											SELECT COUNT(*) FROM dealer so {$wherecond} AND 
											LEVEL = 'BOA' 
											# AND MONTH(transaction_date) = MONTH(CURDATE()) 
											# AND YEAR(transaction_date) = YEAR(CURDATE()) 
										) BOA_RECRUIT,

										(
											SELECT COUNT(*) FROM (
												SELECT COUNT(*) FROM so
												INNER JOIN dealer ON dealer.id = so.dealer
												{$wherecond} 
												AND  dealer.level = 'BOA' 
												#AND MONTH(DATE(so.transaction_date)) = MONTH(CURDATE()) 
												#AND YEAR(DATE(so.transaction_date)) = YEAR(CURDATE()) 
												AND so.status='confirmed'
												GROUP BY dealer.id
											) tbl

										 ) BOA_ACTIVES,

										(
											
											SELECT COUNT(*) FROM dealer WHERE Mother_ID = 0

										 ) BOA_NO_MOTHER_ID, 
										 
										 (
											SELECT FORMAT(SUM(total),2) FROM ( 
												SELECT SUM(total_price) total FROM so
												INNER JOIN dealer ON dealer.id = so.dealer
												{$wherecond} 
												AND  dealer.mother_id IN (
												
													SELECT id FROM dealer WHERE LEVEL = 'BOM'
												) 
												AND dealer.level = 'BOA'
												#AND MONTH(so.transaction_date) = MONTH(CURDATE()) 
												#AND YEAR(so.transaction_date) = YEAR(CURDATE()) 
												AND so.status='confirmed'

												UNION ALL 
												
												SELECT SUM(total_price) FROM so
												INNER JOIN dealer ON dealer.id = so.dealer
												{$wherecond} 
												AND dealer.id IN (
												
													SELECT id FROM dealer WHERE LEVEL = 'BOM'
												)
												#AND MONTH(so.transaction_date) = MONTH(CURDATE()) 
												#AND YEAR(so.transaction_date) = YEAR(CURDATE()) 
												AND so.status='confirmed'
											) tbl 
										) SALES_BOM,


										 (
											SELECT FORMAT(SUM(total_price),2) FROM so
											INNER JOIN dealer ON dealer.id = so.dealer
											{$wherecond} 
											AND  dealer.mother_id = 0 
											AND dealer.level = 'BOA'
											#AND MONTH(so.transaction_date) = MONTH(CURDATE()) 
											#AND YEAR(so.transaction_date) = YEAR(CURDATE())  
											AND so.status='confirmed'
										) BOA_NO_MOTHER_ID,

										(SELECT FORMAT(SUM(total_price),2) FROM so
										INNER JOIN dealer ON dealer.id = so.dealer
										{$wherecond}   
										#MONTH(so.transaction_date) = MONTH(CURDATE()) 
										#AND YEAR(so.transaction_date) = YEAR(CURDATE()) 
										AND so.status='confirmed'
										) BRANCH_SALES_GROSS,

										(SELECT FORMAT(SUM(total_price) - SUM(dealer_discount),2) FROM so
										INNER JOIN dealer ON dealer.id = so.dealer
										{$wherecond} AND  
										#MONTH(so.transaction_date) = MONTH(CURDATE()) 
										#AND YEAR(so.transaction_date) = YEAR(CURDATE()) AND 
										so.status='confirmed'
										) BRANCH_SALES_DGS


							");
			
			
				
			$validation = 1;
			
		}else{
			
			
				// echo "SELECT * FROM `{$_POST['Table']}` {$wherecond}  LIMIT $start, $row";
				// die();
				$query = $mysqli->query("SELECT * FROM `{$_POST['Table']}` {$wherecond}  LIMIT $start, $row");	
				
			
			
		}
		
		if(isset($_POST['isSalary'])){
			$query = $mysqli->query("SELECT id,company_id_no, concat(first_name,' ',middle_name,'. ', last_name) full_name, 
			salary salary, 
			(SELECT transaction_date from salary_logs where employee = a.company_id_no order by id desc limit 1) Eff_Date
			FROM `{$_POST['Table']}` a {$wherecond}  #LIMIT $start, $row");	
			$validation =1;
		}
		
		
		if(isset($_POST['isEmployeemovementsDept'])){
			$query = $mysqli->query("SELECT id,company_id_no, concat(first_name,' ',middle_name,'. ', last_name) full_name, 
			'' department , 
			(SELECT date from employee_movement_dept where employee = a.company_id_no order by id desc limit 1) Eff_Date
			FROM `{$_POST['Table']}` a {$wherecond}  LIMIT $start, $row");	
			$validation =1;
		}
		
		if(isset($_POST['isEmployeemovementsAccount'])){
			$query = $mysqli->query("SELECT id,company_id_no, concat(first_name,' ',middle_name,'. ', last_name) full_name, 
			account , 
			(SELECT date from employee_movement_accountgroup where employee = a.company_id_no order by id desc limit 1) Eff_Date
			FROM `{$_POST['Table']}` a {$wherecond}  LIMIT $start, $row");	
			$validation =1;
		}
		
		if(isset($_POST['isEmployeemovements'])){
			$query = $mysqli->query("SELECT id,company_id_no, concat(first_name,' ',middle_name,'. ', last_name) full_name, 
			branch , 
			(SELECT date from employee_movement where employee = a.company_id_no order by id desc limit 1) Eff_Date
			FROM `{$_POST['Table']}` a {$wherecond}  LIMIT $start, $row");	
			$validation =1;
		}
		
		
		
		
	
		if($_POST['Table'] == 'motorcycle_master_list'){
			
			$query = $mysqli->query("SELECT a.id,code,description, CONCAT(e.first_name,' ',e.middle_name,'. ',e.last_name) driver_name,
									 a.body_no,a.plate_no
									 FROM `motorcycle_master_list` a 
									 left JOIN  employee e ON e.company_id_no = a.driver
			{$wherecond}  order by a.body_no+0 asc LIMIT $start, $row");	
			$queryTotal = $mysqli->query("SELECT * FROM `{$_POST['Table']}` {$wherecond}");
			$validation =1;
		}
	
	
		if($_POST['Table'] == 'official_receipt'){
			
			
			$wherecond = "";
			
			if($_POST['date_from'] != ''){
				$_POST['date_from'] = date("Y-m-d",strtotime($_POST['date_from']));
				$_POST['date_to'] = date("Y-m-d",strtotime($_POST['date_to']));
				$wherecond = " where official_receipt.date between '{$_POST['date_from']}' and '{$_POST['date_to']}'";
			}
			
			$query = $mysqli->query("SELECT official_receipt.id, official_receipt.id ar,
									dealer.id dealer_account_no,official_receipt.date,
									CONCAT(dealer.`first_name`, ' ',dealer.`middle_name`, ' ',dealer.last_name) dealer_name,
									official_receipt.`mode_of_payment`,
									official_receipt.`amount`,
									official_receipt.`change`,

									IF(mode_of_payment ='CHECK',

									CONCAT(' CHECK DATE :',IFNULL(official_receipt.`check_date`,'N/A'),', VALIDATED DATE', 
									IFNULL(official_receipt.`validated_date`,'N/A'),', 
									CHECK NUMBER : ',IFNULL(official_receipt.`check_number`,'N/A'))

									,IF(mode_of_payment ='ONLINE',

									CONCAT(' VALIDATED DATE', 
									IFNULL(official_receipt.`validated_date`,'N/A')
									)

									,'N/A')) CHECK_INFO,
									official_receipt.particulars

									FROM official_receipt 
									INNER JOIN dealer ON dealer.id = official_receipt.dealer 
									{$wherecond}
									ORDER BY id DESC");	
			$queryTotal = $mysqli->query("SELECT * FROM `{$_POST['Table']}` {$wherecond}");
			$validation =1;
		}
		
		
		if($validation == 0){
			// spare_parts
			
			$query = $mysqli->query("SELECT * FROM `{$_POST['Table']}` {$wherecond}  LIMIT $start, $row");	
			$queryTotal = $mysqli->query("SELECT * FROM `{$_POST['Table']}` {$wherecond}");
			
		}
		
		
		
		
		$total = $queryTotal->num_rows;
	
        
        if($_POST['Table'] == 'leave'){
			$html = '<table id = "fetch_data" class="table table-striped table-bordered table-hover">
						<thead>
							<tr class="warning"><th>Action</th>
							<th>Employee Number</th>
							<th>Full name</th>';
			
		}
        elseif($_POST['Table'] == 'inventory_master_list'){
			// die('x');
			$html = '<form name = "dynamic_tables" ><table id = "fetch_data" class="table table-striped table-bordered table-hover">';
			$html .= '<tr class="warning"><th colspan = 2>Action</th>';
			
		}else{
			$html = '<form name = "dynamic_tables" ><table id = "fetch_data" class="table table-striped table-bordered table-hover">
						<thead>';
			// if(!isset($_POST['isSalary'])){
						if($action_btn == 1){
								$html .= '<tr class="warning"><th>Action</th>';
							
						}
			// }
			
		}				
        
        
        
        
		
        

				if($query->num_rows){
					$cnt = 0;
					while($res = mysqli_fetch_object($query)){
						
						if(isset($res->boa_active_based_on_parameter)){
							
							$res->boa_active_based_on_parameter = $mysqli->query("SELECT COUNT(*) a FROM (
								SELECT so.* FROM so
								INNER JOIN dealer ON dealer.id=so.dealer AND level = 'boa'
								where dealer.Mother_ID =  {$res->dealer_account_no} and so.status = 'confirmed' AND DATE(so.transaction_date) BETWEEN  '{$_POST['date_from']}' AND '{$_POST['date_to']}'
								GROUP BY dealer.id
								) tbl")->fetch_object()->a;
							
						}
						
						// $q = $mysqli->query("SHOW FULL COLUMNS FROM `{$_POST['Table']}`");
						if($cnt == 0){
							foreach($res as $header => $value){
								if($header != 'id'){
									$html.= '<th>'.strtoupper(str_replace('_',' ',$header)).'</th>';   
								}
							}
							$html .='</tr>
							</thead>
							<tbody>';
				
						}
						
						$cnt++;
						
						if($_POST['Table'] == "employee"){
							
							if(isset($_POST['isSalary'])){
									$html .= '<tr>
							   
											<td align="center">
												<button class="btn btn-warning btn-xs" type="button" name="EditCollector" onclick="view_salary_logs(\''.$res->company_id_no.'\');">
													<span class="fa fa-edit fa-fw"></span>View Salary Logs
												</button>
												
											</td>';
							}elseif(isset($_POST['isEmployeemovements'])){
									$html .= '<tr>
							   
											<td align="center">
												<button class="btn btn-warning btn-xs" type="button" name="EditCollector" onclick="view_salary_logs(\''.$res->company_id_no.'\');">
													<span class="fa fa-edit fa-fw"></span>View Branch Logs
												</button>
												
												
												
												
												
											</td>';
							}elseif(isset($_POST['isEmployeemovementsDept'])){
									$html .= '<tr>
							   
											<td align="center">
												<button class="btn btn-warning btn-xs" type="button" name="EditCollector" onclick="view_salary_logs(\''.$res->company_id_no.'\');">
													<span class="fa fa-edit fa-fw"></span>View Employee Logs
												</button>
												
												
												
												
												
											</td>';
							}elseif(isset($_POST['isEmployeemovementsAccount'])){
									$html .= '<tr>
							   
											<td align="center">
												<button class="btn btn-warning btn-xs" type="button" name="EditCollector" onclick="view_salary_logs(\''.$res->company_id_no.'\');">
													<span class="fa fa-edit fa-fw"></span>View Employee Logs
												</button>
												
												
												
												
												
											</td>';
							}else{
								$html .= '<tr>
							   
											<td align="center">
												<button class="btn btn-warning btn-xs" type="button" name="EditCollector" onclick="Edit(\''.$res->id.'\');">
													<span class="fa fa-edit fa-fw"></span>Edit
												</button>
												<button class="btn btn-primary btn-xs" type="button" name="EditCollector" onclick="ViewDTR(\''.$res->company_id_no.'\');">
													<span class="fa fa-edit fa-fw"></span>View DTR
												</button>
												<button class="btn btn-danger btn-xs" type="button" name="AddLeaves" onclick="AddLeaves(\''.$res->id.'\');">
													<span class="fa fa-edit fa-fw"></span>Add Leaves
												</button>
											</td>';
							}
								
							
						
							

							
							
						}elseif($_POST['Table'] == "leave"){
							$html .= '<tr>
                           
							<td align="center">
								<button class="btn btn-warning btn-xs" type="button" name="x" onclick="status(\''.$res->id.'\',\'approved\');">
									<span class="fa fa-edit fa-fw"></span>Approved
								</button>
								<button class="btn btn-primary btn-xs" type="button" name="y" onclick="status(\''.$res->id.'\',\'rejected\');">
									<span class="fa fa-edit fa-fw"></span>Reject
								</button>
							</td>';
						}elseif($_POST['Table'] == "office_supply" || $_POST['Table'] == "spare_parts"){
							$html .= '<tr>
                           
							<td align="center">
								<button class="btn btn-warning btn-xs" type="button" name="x" onclick="add_stock('.$res->id.');">
									<span class="fa fa-edit fa-fw"></span>Add stock
								</button>
								<button class="btn btn-primary btn-xs" type="button" name="y" onclick="show_stocklogs(\''.$res->code.'\');">
									<span class="fa fa-edit fa-fw"></span>Show Stock Logs
								</button>
								<button class="btn btn-danger btn-xs" type="button" name="EditCollector" onclick="Edit(\''.$res->id.'\');">
									<span class="fa fa-edit fa-fw"></span>Edit
								</button>
							</td>';
						}elseif($_POST['Table'] == "so"){
							
							if(!isset($_POST['report_type'])){
								$cancel = "";
								if($res->status != 'cancelled'){
									$cancel = '
									<a target="_blank" onclick = "return cancel_si('.$res->id.')" href="pages/cancel_si.php?id='.$res->id.'" class="green">
										<i class="ace-icon fa-130"></i>Cancel SI
									</a>
									';
								}
								
								
								$html .= '<tr>
							   
								<td align="center">
									
									<a target="_blank" href="pages/generate_si.php?id='.$res->id.'" class="green">
																		<i class="ace-icon fa fa-print bigger-130"></i>PRINT
																	</a>
									
									
									| '.$cancel.'
									
									
									
								</td>';
							}else{
								$html .= "<td></td>";
								
							}
						}elseif($_POST['Table'] == "official_receipt"){
							$html .= '<tr>
                           
							<td align="center">
								
								<a target="_blank" href="pages/generate_or.php?id='.$res->id.'" class="green">
																	<i class="ace-icon fa fa-print bigger-130"></i>PRINT
																</a>
								
								
							</td>';
						}elseif($_POST['Table'] == "product"){
							if(isset($_POST['IsSales'])){
								$html .= '<tr>
							<td align="center">
								<button class="btn btn-warning btn-xs" type="button" name="EditCollector" onclick="Edit(\''.$res->code.'\');">
									<span class="fa fa-edit fa-fw"></span>Show Stocklog
								</button>
							</td>';
							}else{
								$html .= '<tr>
							<td align="center">
								<button class="btn btn-warning btn-xs" type="button" name="EditCollector" onclick="Edit(\''.$res->id.'\');">
									<span class="fa fa-edit fa-fw"></span>Edit
							</td>';
							}
							
						
						}elseif($_POST['Table'] == "dealer"){
							
							if($action_btn == 1){
								$html .= '<tr>
                           
											<td align="center">
												<button class="btn btn-warning btn-xs" type="button" name="EditCollector" onclick="Edit(\''.$res->id.'\');">
													<span class="fa fa-edit fa-fw"></span>Edit
												</button>
												<button class="btn btn-danger btn-xs" type="button" name="EditCollector" onclick="Promote_Dealer(\''.$res->id.'|'.$res->level.'\');">
													<span class="fa fa-edit fa-fw"></span>Promote Dealer
												</button>
											</td>';
							
							}
							
						}else{
							
							if($action_btn == 1){
								$html .= '<tr>
                           
							<td align="center">
								<button class="btn btn-warning btn-xs" type="button" name="EditCollector" onclick="Edit(\''.$res->id.'\');">
									<span class="fa fa-edit fa-fw"></span>Edit
								</button>
							</td>';
							
							}
							
						}
							
                        $in_array = array('id');
                        foreach($res as $k => $v){
                            if(!in_array($k,$in_array)){
                                
								if($k == 'salary'){
									if(isset($_POST['isSalary'])){
										$html .= '<td><input class = "form-control" type = "text" name = "salary[]" value = "'.$v.'"><input class = "form-control" type = "hidden" name = "id[]" value = "'.$res->company_id_no.'"></td>';
									}
								}
								
								
								else{
									
									if($_POST['Table'] == 'promo'){
										if($k == 'product' && $v == ""){
											// echo $k;
											// $html.= '<td><a onclick  = "viewpromodetails('.$res->id.')">VIEW PRODUCT DETAILS</a></td>';
											
											$x = $mysqli->query("select * from promo_details where promo = {$res->id}");
											if($x->num_rows > 0){
												$array_product = array();
												while($y = $x->fetch_object()){
													$array_product[] = $y->product;
												}
												$html.= '<td>'.implode(',',$array_product).'</a></td>';
												
											}
										}else{
											$html.= '<td>'.strtoupper($v).'</td>';
											
										}
									}else{
										$html.= '<td>'.strtoupper($v).'</td>';
										
									}
									
								}
								
                            }
                        }
                    $html .= '</tr>';
					}
				}else{
					$html .= '<tr>
						<td colspan="100" align="center">No record found</td>
					</tr>';
				}
			$html .= '</tbody>
		</table></form>';
		
		$result["Details"] = $html;
		$result["Pagination"] = AddPagination($row, $total, $page, "showPage");
		
		die(json_encode($result));
	}
    
	if($_POST['action'] == 'ANY_PROMO'){
		
		// any two
		$q = $mysqli->query("SELECT * FROM promo WHERE promo_condition = 'ANY' AND promo_type = 'OVERLAY PROMO SET'
						AND CURDATE() BETWEEN date_start AND date_end");
		
		
		$resp=array();
		if($q->num_rows > 0){
			while($r = $q->fetch_object()){
					$resp['promo_header'][] = $r;
					
					$qq = $mysqli->query("SELECT product.*,promo.*,promo.price / promo.`any` price_per_item FROM promo_details 
											INNER JOIN product ON product.`code` = promo_details.`product`
											INNER JOIN promo ON promo.id = promo_details.promo
											WHERE promo_details.promo ={$r->id}");
											
					while($rr = $qq->fetch_object()){
						$resp['promo_header_details'][$r->id][] = $rr;
					}						
					
			}
			$resp['response'] = 'success';
		}
		
		die(json_encode($resp));
		
	}
	if($_POST['action'] == 'cancel_si'){
		// $_POST['id']..
		
		$so_details = $mysqli->query("select * from so where id = {$_POST['id']}")->fetch_object();
		
		$mysqli->query("update dealer set credit_limit = credit_limit + {$so_details->outstanding_balance} where id = {$so_details->dealer}");
		
		$mysqli->query("update so set status = 'cancelled' where id = {$_POST['id']}");
		//item returned..
		
		$q = $mysqli->query("SELECT * FROM so_details where si = {$_POST['id']}");
		
		if($q->num_rows > 0){
			while($r = $q->fetch_object()){
				// $r->qty;
				
				//prev stocks..
				
				$prev_stocks = $mysqli->query("select soh from product where 
				code = '{$r->product}'")->fetch_object()->soh;
				
				
				//now return stocks
				$mysqli->query("update product set soh = soh + {$r->qty} where code = '{$r->product}'");
				
				
				$qq = $mysqli->query("SELECT promo_details.* FROM promo_details 
										INNER JOIN promo ON promo.id = promo_details.`promo`
										WHERE promo_code = '{$r->product}'");
				

				$qqq = $mysqli->query("SELECT * FROM promob1t1 WHERE promo_code =  '{$r->product}'");
				
				if($qq->num_rows > 0){
					while($rr = $qq->fetch_object()){
						
						$prev_stocks = $mysqli->query("select soh from product where 
						code = '{$rr->product}'")->fetch_object()->soh;
						
						$mysqli->query("update product set soh = soh + {$r->qty} where code = '{$rr->product}'");
						
						$updated_stocks = $mysqli->query("select soh from product where 
						code = '{$rr->product}'")->fetch_object()->soh;
											
											// now add this item from stockard....
											$mysqli->query("INSERT INTO `stocklog` (
											`product_code`,promo,`product_description`,  `begining_balance`,
											`ending_balance`,  `transaction_date`, `created_by`,inventory_type,so)
											VALUES
											(
												'{$rr->product}',
												'{$r->product}',
												'CANCEL SI # {$_POST['id']}','{$prev_stocks}','{$updated_stocks}',
												now(),'{$_SESSION['empid']}','In',{$_POST['id']}
											);");
					}
				}elseif($qqq->num_rows > 0){
					while($rr = $qqq->fetch_object()){
						$prev_stocks = $mysqli->query("select soh from product where 
						code = '{$rr->product}'")->fetch_object()->soh;
						
						$mysqli->query("update product set soh = soh + ({$r->qty} * {$rr->qty}) where code = '{$rr->product}'");
						$mysqli->query("update product set soh = soh + ({$r->qty} * {$rr->qty_free}) where code = '{$rr->product_free}'");
						
						$updated_stocks = $mysqli->query("select soh from product where 
						code = '{$rr->product}'")->fetch_object()->soh;
											
											// now add this item from stockard....
											$mysqli->query("INSERT INTO `stocklog` (
											`product_code`,promo,`product_description`,  `begining_balance`,
											`ending_balance`,  `transaction_date`, `created_by`,inventory_type,so)
											VALUES
											(
												'{$rr->product}',
												'{$r->product}',
												'CANCEL SI # {$_POST['id']}' ,'{$prev_stocks}','{$updated_stocks}',
												now(),'{$_SESSION['empid']}','In',{$_POST['id']}
											);");
											
						$updated_stocks = $mysqli->query("select soh from product where 
						code = '{$rr->product_free}'")->fetch_object()->soh;
											
											// now add this item from stockard....
											$mysqli->query("INSERT INTO `stocklog` (
											`product_code`,promo,`product_description`,  `begining_balance`,
											`ending_balance`,  `transaction_date`, `created_by`,inventory_type,so)
											VALUES
											(
												'{$rr->product_free}',
												'{$r->product}',
												'CANCEL SI # {$_POST['id']}' ,'{$prev_stocks}','{$updated_stocks}',
												now(),'{$_SESSION['empid']}','In',{$_POST['id']}
											);");
					}
				}else{
					$updated_stocks = $mysqli->query("select soh from product where 
					code = '{$r->product}'")->fetch_object()->soh;
										
										// now add this item from stockard....
										$mysqli->query("INSERT INTO `stocklog` (
										`product_code`,promo,`product_description`,  `begining_balance`,
										`ending_balance`,  `transaction_date`, `created_by`,inventory_type,so)
										VALUES
										(
											'{$r->product}',
											'',
											'CANCEL SI # {$_POST['id']}','{$prev_stocks}','{$updated_stocks}',
											now(),'{$_SESSION['empid']}','In',{$_POST['id']}
										);");
				}
				
				
									
				
					
									
				
			}
			
			
		}
		
		
	}
    
    
	if($_POST['action'] == 'Update_Employee_Salary_Logs'){
		// print_r($_POST);
		
		
		foreach($_POST['id'] as $key => $v){
			//check first if the salary updated
			$old_salary = $mysqli->query("select salary from `{$_POST['Table']}` where company_id_no = {$v}")->fetch_object()->salary;
			if(trim($old_salary) != trim($_POST['salary'][$key])){
				// echo "select salary from `{$_POST['Table']}` where company_id_no = {$v}";
				// echo $old_salary."=".trim($_POST['salary'][$key]);
				// die();
				// stored the old salary..
				$mysqli->query("insert into salary_logs (employee,salary) values ('{$v}','{$_POST['salary'][$key]}')");
				$mysqli->query("update `{$_POST['Table']}` set salary = '{$_POST['salary'][$key]}' where company_id_no = '{$v}'");
			}
				
		}
		
	}
    
    if($_POST['action'] == 'Purchace_request'){
		$in_array_tablle = array('spare_parts','office_supply','office_supply_stock_logs','spare_parts_stock_logs');
        $q = $mysqli->query("SHOW FULL COLUMNS FROM {$_POST['Table']}");
        echo '<div class="row" id = "rowCrossCheckValidation">
				
				<div class="col-lg-12 Error-Message-Box" style="display:none;">
					<div class="alert alert-danger">
						<div class="Error-Message">Please insert field.</div>
					</div>
				</div>
				
				<div class="col-lg-12">
					<div class="panel panel-red">
						<div class="panel-heading">Parameter</div>
						
						<form role="form" name="AddEmployee">
							<div class="panel-body">';
							
								 if(in_array($_POST['Table'],$in_array_tablle)){
									 if(isset($_POST['type'])){
										 // echo $_POST['type'];
										 if($_POST['type'] == 'out'){
											 $in_array = array('id','soh','type','transaction_date','delivery_receipt',	
												'code','description','soh','below_min_soh','limit');


											 
										 }
									 }else{
										 $in_array = array('id','soh','type','transaction_date');										 
									 }
								 }else{
									 $in_array = array('id','transaction_date','inventory_id');
								 }
								 // price
								
                                while($r = $q->fetch_object()){
                                    $datepicker = '';
                                    if($r->Type == 'date'){
                                        $datepicker = "datepicker";
                                    }
                                   
                     
										
                                     if(!in_array($r->Field,$in_array)){
										 
										$check_tables_q = $mysqli->query("SHOW TABLES");
										$validated = 0;
										$tableoption = "";
										while($check_tables_r = $check_tables_q->fetch_object()){
											if($r->Field == $check_tables_r->Tables_in_pos){
												$validated = 1;
												$tableoption = $r->Field;
												break;
											}
											
											if($r->Field == 'driver'){
												$tableoption = 'employee';
												$validated = 1;
												break;
											}
											if($r->Field == 'employee_reference'){
												$tableoption = 'employee';
												$validated = 1;
												break;
											}
											
										}
										
										if($validated == 1){
												
												if($r->Field == 'driver'){
													$option_q = $mysqli->query("select * from `".$tableoption."` WHERE position  like '%driver%'");													
												}else{
													$option_q = $mysqli->query("select * from `".$tableoption."`");													
												}
												
												
												$options = "<option value = 0>[SELECT : HERE]</option>";
												
												
												
												if($option_q->num_rows > 0){
													
													if($tableoption == 'employee'){
														while($option = $option_q->fetch_object()){
															$selected = "";
															
															$options .= "<option {$selected} value = '{$option->company_id_no}'>{$option->first_name} {$option->last_name}</option>";
														}
													}else{
														while($option = $option_q->fetch_object()){
															$selected = "";
															if(isset($_POST[$tableoption])){
																if($_POST[$tableoption] == $option->id){
																	$selected = "selected";
																}
															}
															
															if($tableoption == 'motorcycle_master_list'){
																$options .= "<option {$selected} value = '{$option->body_no}-{$option->description}'>{$option->body_no}</option>";
															}else{
																$options .= "<option {$selected} value = '{$option->code}'>{$option->description}</option>";
															}
														}
													}
													
													$r->xField = $r->Field;
													if($r->Field == 'motorcycle_master_list'){
														$r->xField = 'body_no';
													}
													echo '<div class="row">
													<div class="col-lg-12">
														<div class="form-group">
															<label>'.strtoupper(str_replace('_',' ',$r->xField)).'</label>
															<select class = "form-control" name = "'.$r->Field.'">'.$options.'</select>
														</div>
													</div>
													</div>';
												}
												
												
												
												
										}else{
											
											if($r->Field == 'price'){
												if(isset($_POST['type'])){
													// if($_POST['type'] != 'out'){
														echo '<div class="row">
														<div class="col-lg-12">
															<div class="form-group">
																<label>'.strtoupper(str_replace('_',' ',$r->Field)).'</label>
																<input '.$datepicker.' type="text"  name="'.$r->Field.'" class="form-control '.$datepicker.'" value="" />
															</div>
														</div>
														</div>';
													// }
												}else{
														echo '<div class="row">
														<div class="col-lg-12">
															<div class="form-group">
																<label>'.strtoupper(str_replace('_',' ',$r->Field)).'</label>
																<input '.$datepicker.' type="text"  name="'.$r->Field.'" class="form-control '.$datepicker.'" value="" />
															</div>
														</div>
														</div>';
												}
											}else{
												$value = "";
												if($_POST['Table'] == 'inventory_master_list'){
													if($r->Field == 'aamlo_property_no'){
														$value = $mysqli->query("SELECT (MAX(ID) + 1) property_no FROM inventory_master_list")->fetch_object()->property_no;
														
													}
												}
												
												if($_POST['Table'] == 'spare_parts_stock_logs'){
													if($r->Field == 'ris_no'){
														$value = $mysqli->query("SELECT MAX(ris_no)+1 property_no FROM spare_parts_stock_logs")->fetch_object()->property_no;
														
													}
												}
												
												if($_POST['Table'] == 'motorcycle_master_list'){
													if($r->Field == 'body_no'){
														$value = $mysqli->query("SELECT body_no+1 body_no FROM motorcycle_master_list ORDER BY body_no+0 DESC LIMIT 1")->fetch_object()->body_no;
														
													}
												}
												
												echo '<div class="row">
												<div class="col-lg-12">
													<div class="form-group">
														<label>'.strtoupper(str_replace('_',' ',$r->Field)).'</label>
														<input '.$datepicker.' type="text"  name="'.$r->Field.'" class="form-control '.$datepicker.'" value="'.$value.'" />
													</div>
												</div>
												</div>';
											}
											
												
										}
										
                                        
                                    }
                                }
        
                                
								echo '</div>
								
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>';
    }
    
    if($_POST['action'] == 'Add'){
		$in_array_tablle = array('spare_parts','office_supply','office_supply_stock_logs','spare_parts_stock_logs','old_level','cpi');
        $q = $mysqli->query("SHOW FULL COLUMNS FROM {$_POST['Table']}");
        echo '<form role="form" name="AddEmployee"><div class="row" id = "rowCrossCheckValidation">
				
				<div class="col-lg-12 Error-Message-Box" style="display:none;">
					<div class="alert alert-danger">
						<div class="Error-Message">Please insert field.</div>
					</div>
				</div>
				
				<div class="col-lg-12">
					<div class="panel panel-red">
						<div class="panel-heading">Parameter</div>
						
						
							<div class="panel-body">';
							
								
									 $in_array = array('id','si','transaction_date','inventory_id',
									 
									 'additional_discount',
									 'outstanding_balance',
									 'due_date',
									 'begining_credit_limit',
									 'ending_credit_limit',
									 'created_by','vat','dealer_discount','status','cpi','old_level'
									 );
								 
								 // price
								
                                while($r = $q->fetch_object()){
                                    $datepicker = '';
                                    if($r->Type == 'date'){
                                        $datepicker = "datepicker";
                                    }
                                  
                                   
                     
									// echo $r->Field;
                                     if(!in_array($r->Field,$in_array)){
										 
										$check_tables_q = $mysqli->query("SHOW TABLES");
										$validated = 0;
										$tableoption = "";
										while($check_tables_r = $check_tables_q->fetch_object()){
											if($r->Field == $check_tables_r->Tables_in_pos){
												$validated = 1;
												$tableoption = $r->Field;
												break;
											}
											
											if($r->Field == 'driver'){
												$tableoption = 'employee';
												$validated = 1;
												break;
											}
											
											
											if($r->Field == 'employee_reference'){
												$tableoption = 'employee';
												$validated = 1;
												break;
											}
											
											if($r->Field == 'Recruiter_ID'){
												$tableoption = 'dealer';
												$validated = 1;
												break;
											}
											if($r->Field == 'Mother_ID'){
												
												$tableoption = 'dealer';
												$validated = 1;
												break;
											}
											
											if($r->Field == 'product_free'){
												
												$tableoption = 'product';
												$validated = 1;
												break;
											}
											
										}
										// echo $validated;
										if($validated == 1){
												
												
												$option_q = $mysqli->query("select * from `".$tableoption."`");													
												
												
												
												$options = "<option value = ''>[SELECT : HERE]</option>";
												
												
											
												if($option_q->num_rows > 0){
													
													if($tableoption == 'dealer'){
														while($option = $option_q->fetch_object()){
															$selected = "";
															$options .= "<option {$selected} 
															data-details = 'Dealer ID : {$option->id}<br /> Primary Address : {$option->primary_address}<br />
															Email Addresss : {$option->email_address}<br />
															Mobile Number : {$option->mobile_number}<br />
															Credit Limit : {$option->credit_limit}<br />'
															
															data-creditlimit = {$option->credit_limit}
															
															value = '{$option->id}'>{$option->first_name} {$option->last_name} -{$option->id}</option>";
														}
													}else{
														while($option = $option_q->fetch_object()){
															$selected = "";
															if(isset($_POST[$tableoption])){
																if($_POST[$tableoption] == $option->id){
																	$selected = "selected";
																}
															}
															
															if($tableoption == 'so'){
																$options .= "<option {$selected} value = '{$option->id}'>{$option->id}</option>";
															}else{
																$options .= "<option {$selected} value = '{$option->code}'>{$option->description}</option>";
															}
														}
													}
													
													$r->xField = $r->Field;
													if($r->Field == 'motorcycle_master_list'){
														$r->xField = 'body_no';
													}
													
													if($_POST['Table'] == 'so' || $tableoption == 'so'){
														echo '<div class="row">
															<div class="col-lg-6">
																<div class="form-group">
																	<label>'.strtoupper(str_replace('_',' ',$r->xField)).'</label>
																	<select 
																	onchange = "change_dealer();"
																	class = "form-control" name = "'.$r->Field.'">'.$options.'</select>
																</div> '.$r->Comment.'
															</div>
															<div class="col-lg-6">
																<div class="form-group">
																	<label>'.strtoupper(str_replace('_',' ',$r->xField)).' INFORMATION</label>
																	<p id = "information_details"></p>
																</div>
															</div>
															</div>';
														
													}else{
															
														if($_POST['Table'] == 'promo'){
														
															if($r->Field == 'product'){
																echo '<div class="row">
																	<div class="col-lg-6">
																		<div class="form-group dynamic_add">
																			<label>'.strtoupper(str_replace('_',' ',$r->xField)).'</label>
																			<select 
																			onchange = "change_dealer();"
																			class = "form-control " name = "'.$r->Field.'[]">'.$options.'</select>
																			'.$r->Comment.'
																			
																		<div class = "form-group append"></div></div>
																	</div>
																	<div class="col-lg-6">
																		<div class="form-group dynamic_add_price">
																			<label>'.strtoupper(str_replace('_',' ','Price')).'</label>
																			<input type="text" name="price[]" class="form-control " value="">
																			<input type="submit" disabled  value="+" class="btn btn-success" onclick="return dynamic_add()">
																			*Use this parameter for buy set promo / any promo
																			
																		<div class = "form-group append_price"></div></div>
																	</div>
																	</div>';
																	
																	// unset($r->Price);
																	
															}elseif($r->Field=='price'){echo "xx";}else{
																echo '<div class="row">
																<div class="col-lg-6">
																	<div class="form-group">
																		<label>'.strtoupper(str_replace('_',' ',$r->xField)).'</label>
																		<select 
																		onchange = "change_dealer();"
																		class = "form-control" name = "'.$r->Field.'">'.$options.'</select>'.$r->Comment.'
																	</div>
																</div>
																</div>';
															}
														}else{
															echo '<div class="row">
															<div class="col-lg-6">
																<div class="form-group">
																	<label>'.strtoupper(str_replace('_',' ',$r->xField)).'</label>
																	<select 
																	onchange = "change_dealer();"
																	class = "form-control" name = "'.$r->Field.'">'.$options.'</select>'.$r->Comment.'
																</div>
															</div>
															</div>';
														}
														
														
													}
													
												}
												
												
												
												
										}else{
											
											if($r->Field == 'price'){
												
												// if($_POST['Table'] != 'promo'){
												
													if(isset($_POST['type'])){
														// if($_POST['type'] != 'out'){
															echo '<div class="row">
															<div class="col-lg-12">
																<div class="form-group">
																	<label>'.strtoupper(str_replace('_',' ',$r->Field)).'</label>
																	<input '.$datepicker.' type="text"  name="'.$r->Field.'" class="form-control '.$datepicker.'" value="" />
																</div>
															</div>'.$r->Comment.'
															</div>';
														// }
													}else{
															echo '<div class="row">
															<div class="col-lg-12">
																<div class="form-group">
																	<label>'.strtoupper(str_replace('_',' ',$r->Field)).'</label>
																	<input '.$datepicker.' type="text"  name="'.$r->Field.'" class="form-control '.$datepicker.'" value="" />
																</div>'.$r->Comment.'
															</div>
															</div>';
													}
												// }
											}else{
												$value = "";
												if($_POST['Table'] == 'inventory_master_list'){
													if($r->Field == 'aamlo_property_no'){
														$value = $mysqli->query("SELECT (MAX(ID) + 1) property_no FROM inventory_master_list")->fetch_object()->property_no;
														
													}
												}
												
												if($_POST['Table'] == 'spare_parts_stock_logs'){
													if($r->Field == 'ris_no'){
														$value = $mysqli->query("SELECT MAX(ris_no)+1 property_no FROM spare_parts_stock_logs")->fetch_object()->property_no;
														
													}
												}
												
												if($_POST['Table'] == 'motorcycle_master_list'){
													if($r->Field == 'body_no'){
														$value = $mysqli->query("SELECT body_no+1 body_no FROM motorcycle_master_list ORDER BY body_no+0 DESC LIMIT 1")->fetch_object()->body_no;
														
													}
												}
												
												echo '<div class="row">
												<div class="col-lg-6">
													<div class="form-group">
														<label>'.strtoupper(str_replace('_',' ',$r->Field)).'</label>
														<input '.$datepicker.' type="text"  name="'.$r->Field.'" class="form-control '.$datepicker.'" value="'.$value.'" />
													'.$r->Comment.'
													</div>
												</div>
												</div>';
											}
											
											
											
												
										}
										
                                        
                                    }
                                }
        
                                
								echo '</div>
								
								
								
								
								
								
								</div>
							</div>
						
					</div>
				</div>
			</div>';
			
			
			if(isset($_POST['SecondTable'])){
				
				$desc = $mysqli->query("desc so_details");
				
				$header = "";
				while($r = $desc->fetch_object()){
					 if(!in_array($r->Field,$in_array)){
						$header .= "<th>".strtoupper(str_replace("_"," ",$r->Field))."</th>";
						
						
						
						
							$check_tables_q = $mysqli->query("SHOW TABLES");
							$validated = 0;
							$tableoption = "";
							while($check_tables_r = $check_tables_q->fetch_object()){
								if($r->Field == $check_tables_r->Tables_in_pos){
									$validated = 1;
									$tableoption = $r->Field;
									break;
								}
								
								
								
								
								
							}
							if($validated == 1){
												
									
									$option_q = $mysqli->query("select * from `".$tableoption."`");													
									
									
									
									$options = "<option value = ''>[SELECT : HERE]</option>";
									
									
								
									if($option_q->num_rows > 0){
										
										if($tableoption == 'employee'){
											while($option = $option_q->fetch_object()){
												$selected = "";
												
												$options .= "<option {$selected} value = '{$option->company_id_no}'>{$option->first_name} {$option->last_name}</option>";
											}
										}else{
											while($option = $option_q->fetch_object()){
												$selected = "";
												if(isset($_POST[$tableoption])){
													if($_POST[$tableoption] == $option->id){
														$selected = "selected";
													}
												}
												
												
												//promo check..
												
												$promo = $mysqli->query("select * from promo 
																	  where curdate() between date(date_start) and date(date_end) 
																	  and promo_type = 'SINGLE LINE' and product = '{$option->code}'");

												if($promo->num_rows > 0){
													$promo_fetch 		 = $promo->fetch_object();
													$option->price		 = $promo_fetch->price;
													$option->promo_code	 = $promo_fetch->promo_code;
												}
												
													$options .= "<option {$selected} 
													data-description = '{$option->description}'
													data-promocode = '{$option->promo_code}'
													data-price = {$option->price}
													value = '{$option->code}'>{$option->description}</option>";
												
											}
										}
										
										$r->xField = $r->Field;
										if($r->Field == 'motorcycle_master_list'){
											$r->xField = 'body_no';
										}
										
										// $selector	= '<select onchange = "product(1)"  placeholder = "select" class = "form-control" id="'.$r->Field.'1" name = "'.$r->Field.'[]">'.$options.'</select>';
										// $selectorx  = '<select onchange = "product(0)" placeholder = "select"  class = "form-control" id="'.$r->Field.'0" name = "'.$r->Field.'[]">'.$options.'</select>';
											
									}
									// for set promo...
									$promo_set = $mysqli->query("select * from promo where promo_condition = 'SET' and curdate() between date_start and date_end");
									if($promo_set->num_rows > 0){
										
										while($promo_set_rows =  $promo_set->fetch_object()){
											$options .= "<option 
													data-description = '{$promo_set_rows->promo_description}'
													data-promocode = '{$promo_set_rows->promo_code}'
													data-price = {$promo_set_rows->price}
													value = '{$promo_set_rows->promo_code}'>{$promo_set_rows->promo_description}</option>";
										}
									}
									
									
									// for b1t1 promo...
									$promo_set = $mysqli->query("SELECT *,
									(SELECT promob1t1.qty * price FROM product WHERE `code` = promob1t1.product) price
									FROM promob1t1 WHERE  CURDATE() BETWEEN date_start AND date_end");
									if($promo_set->num_rows > 0){
										
										while($promo_set_rows =  $promo_set->fetch_object()){
											$options .= "<option 
													data-description = '{$promo_set_rows->promo_description}'
													data-promocode = '{$promo_set_rows->promo_code}'
													data-price = {$promo_set_rows->price}
													value = '{$promo_set_rows->promo_code}'>{$promo_set_rows->promo_description}</option>";
										}
									}
									
										$selector	= '<select onchange = "product(1)"  placeholder = "select" class = "form-control" id="'.$r->Field.'1" name = "'.$r->Field.'[]">'.$options.'</select>';
										$selectorx  = '<select onchange = "product(0)" placeholder = "select"  class = "form-control" id="'.$r->Field.'0" name = "'.$r->Field.'[]">'.$options.'</select>';
										
									
								$detailsx .= "<td>".$selectorx."</td>";
								$details .= "<td>".$selector."</td>";
							}else{
								$disabled = "";
								if($r->Field =='qty'){
									$disabled = "onkeypress = add_line(event,1)";
									$disablexd = "onkeypress = add_line(event,0)";
								}else{
									$disabled = "readonly";
									$disablexd = "readonly";
								}
								
								if($r->Field == 'qty'){
									$detailsx .= "<td><input {$disablexd}  oninput=\"this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');\" class = 'form-control' type = 'text' value = '' name = '".$r->Field."[]' id = '".$r->Field."0' ></td>";
									$details .= "<td><input {$disabled}    oninput=\"this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');\" class = 'form-control' type = 'text' value = '' name = '".$r->Field."[]' id = '".$r->Field."1' ></td>";
								}else{
									$detailsx .= "<td><input {$disablexd} class = 'form-control' type = 'text' value = '' name = '".$r->Field."[]' id = '".$r->Field."0' ></td>";
									$details .= "<td><input {$disabled} class = 'form-control' type = 'text' value = '' name = '".$r->Field."[]' id = '".$r->Field."1' ></td>";
								}
								
								
							}
							
							
							
					 }
				}
				
				echo '<table id="fetch_data_so_details" class="table table-striped table-bordered table-hover">
						<thead><tr class="warning">'.$header.'</tr>
							</thead>
							<tbody>
							<tr class = "clone" style = "display:none;">
							'.$detailsx.'
							</tr>
							<tr>
							'.$details.'
							
							</tr>
							
							</tbody>
		</table> </form>';
			
			}
    }
    
	if($_POST['action'] == 'changestatus'){
		$mysqli->query("update `{$_POST['Table']}` set status = '{$_POST['status']}' where id = {$_POST['id']}");
		die(json_encode(array('response'=>'success')));
	}
    
    if($_POST['action'] == 'Leave_Add'){
        $q = $mysqli->query("SHOW FULL COLUMNS FROM {$_POST['Table']}");
        echo '<div class="row" id = "rowCrossCheckValidation">
				
				<div class="col-lg-12 Error-Message-Box" style="display:none;">
					<div class="alert alert-danger">
						<div class="Error-Message">Please insert field.</div>
					</div>
				</div>
				
				<div class="col-lg-12">
					<div class="panel panel-red">
						<div class="panel-heading">Parameter</div>
						
						<form role="form" name="AddEmployee">
							<div class="panel-body">';
								$in_array = array('id','employee_id');
                                while($r = $q->fetch_object()){
                                    $datepicker = '';
                                    if($r->Type == 'date'){
                                        $datepicker = "datepicker";
                                    }
                                   
                     
										
                                     if(!in_array($r->Field,$in_array)){
										 
										$check_tables_q = $mysqli->query("SHOW TABLES");
										$validated = 0;
										$tableoption = "";
										while($check_tables_r = $check_tables_q->fetch_object()){
											if($r->Field == $check_tables_r->Tables_in_pos){
												$validated = 1;
												$tableoption = $r->Field;
												break;
											}
										}
										
										if($validated == 1){
												$option_q = $mysqli->query("select * from ".$tableoption);
												$options = "<option value = 0>[SELECT : HERE]</option>";
												if($option_q->num_rows > 0){
													while($option = $option_q->fetch_object()){
														$options .= "<option value = '{$option->code}'>{$option->description}</option>";
													}
													echo '<div class="row">
													<div class="col-lg-12">
														<div class="form-group">
															<label>'.strtoupper(str_replace('_',' ',$r->Field)).'</label>
															<select class = "form-control" name = "'.$r->Field.'">'.$options.'</select>
														</div>
													</div>
													</div>';
												}
										}else{
											echo '<div class="row">
											<div class="col-lg-12">
												<div class="form-group">
													<label>'.strtoupper(str_replace('_',' ',$r->Field)).'</label>
													<input '.$datepicker.' type="text"  name="'.$r->Field.'" class="form-control '.$datepicker.'" value="" />
												</div>
											</div>
											</div>';	
										}
										
                                        
                                    }
                                }
        
                                
								echo '</div>
								
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>';
    }
    

    
	if($_POST['action'] == 'view_branch_logs'){
        // $q = $mysqli->query("select * from {$_POST['Table']} where id = {$_POST['id']}");
        
        echo '<div class="row" id = "rowCrossCheckValidation">
				
				<div class="col-lg-12 Error-Message-Box" style="display:none;">
					<div class="alert alert-danger">
						<div class="Error-Message">Please insert field.</div>
					</div>
				</div>
				
				<div class="col-lg-12">
					<div class="panel panel-red">
						<div class="panel-heading">Parameter</div>
						
						<form role="form" name="AddEmployee">
							<div class="panel-body">';
								echo 
								'<h1>'.$mysqli->query("select concat(first_name,' ',middle_name,'. ', last_name) full_name from employee where company_id_no = '{$_POST['id']}'")->fetch_object()->full_name.'</h1>
								<table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info">
                                    <thead>';
									
								echo '<tr role="row">
											<th>Branch Logs</th>
											<th>Effective Date</th>
											<th>Transaction Date</th>
										</tr>';
								
								
								$qq = $mysqli->query("select * from  employee_movement where employee  = '{$_POST['id']}'");
                                
								
								
                                    
									
								echo '</thead>
                                    <tbody>';
                                       if($qq->num_rows > 0){
											$soh = 0;
											while($rr = $qq->fetch_object()){
												echo '<tr class="gradeA odd" role="row">
															<td>'.$rr->branch.'</td>
															<td>'.$rr->date.'</td>
															<td>'.$rr->transaction_date.'</td>
														</tr>';
											}
									} 
                                   
										
								echo'</tbody>
                                </table>';
        
                                
								echo '</div>
								
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>';
    }

    
	if($_POST['action'] == 'view_department_logs'){
        // $q = $mysqli->query("select * from {$_POST['Table']} where id = {$_POST['id']}");
        
        echo '<div class="row" id = "rowCrossCheckValidation">
				
				<div class="col-lg-12 Error-Message-Box" style="display:none;">
					<div class="alert alert-danger">
						<div class="Error-Message">Please insert field.</div>
					</div>
				</div>
				
				<div class="col-lg-12">
					<div class="panel panel-red">
						<div class="panel-heading">Parameter</div>
						
						<form role="form" name="AddEmployee">
							<div class="panel-body">';
								echo 
								'<h1>'.$mysqli->query("select concat(first_name,' ',middle_name,'. ', last_name) full_name from employee where company_id_no = '{$_POST['id']}'")->fetch_object()->full_name.'</h1>
								<table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info">
                                    <thead>';
									
								echo '<tr role="row">
											<th>Department Logs</th>
											<th>Effective Date</th>
											<th>Transaction Date</th>
										</tr>';
								
								
								$qq = $mysqli->query("select * from  employee_movement_dept where employee  = '{$_POST['id']}'");
                                
								
								
                                    
									
								echo '</thead>
                                    <tbody>';
                                       if($qq->num_rows > 0){
											$soh = 0;
											while($rr = $qq->fetch_object()){
												echo '<tr class="gradeA odd" role="row">
															<td>'.$rr->branch.'</td>
															<td>'.$rr->date.'</td>
															<td>'.$rr->transaction_date.'</td>
														</tr>';
											}
									} 
                                   
										
								echo'</tbody>
                                </table>';
        
                                
								echo '</div>
								
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>';
    }
    
	if($_POST['action'] == 'employee_movement_accountgroup'){
        // $q = $mysqli->query("select * from {$_POST['Table']} where id = {$_POST['id']}");
        
        echo '<div class="row" id = "rowCrossCheckValidation">
				
				<div class="col-lg-12 Error-Message-Box" style="display:none;">
					<div class="alert alert-danger">
						<div class="Error-Message">Please insert field.</div>
					</div>
				</div>
				
				<div class="col-lg-12">
					<div class="panel panel-red">
						<div class="panel-heading">Parameter</div>
						
						<form role="form" name="AddEmployee">
							<div class="panel-body">';
								echo 
								'<h1>'.$mysqli->query("select concat(first_name,' ',middle_name,'. ', last_name,' - ',account) full_name from employee where company_id_no = '{$_POST['id']}'")->fetch_object()->full_name.'</h1>
								<table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info">
                                    <thead>';
									
								echo '<tr role="row">
											<th>Account Group Logs</th>
											<th>Effective Date</th>
											<th>Transaction Date</th>
										</tr>';
								
								
								$qq = $mysqli->query("select * from  employee_movement_accountgroup where employee  = '{$_POST['id']}'");
                                
								
								
                                    
									
								echo '</thead>
                                    <tbody>';
                                       if($qq->num_rows > 0){
											$soh = 0;
											while($rr = $qq->fetch_object()){
												echo '<tr class="gradeA odd" role="row">
															<td>'.$rr->account.'</td>
															<td>'.$rr->date.'</td>
															<td>'.$rr->transaction_date.'</td>
														</tr>';
											}
									} 
                                   
										
								echo'</tbody>
                                </table>';
        
                                
								echo '</div>
								
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>';
    }

    
	if($_POST['action'] == 'view_salary_logs'){
        // $q = $mysqli->query("select * from {$_POST['Table']} where id = {$_POST['id']}");
        
        echo '<div class="row" id = "rowCrossCheckValidation">
				
				<div class="col-lg-12 Error-Message-Box" style="display:none;">
					<div class="alert alert-danger">
						<div class="Error-Message">Please insert field.</div>
					</div>
				</div>
				
				<div class="col-lg-12">
					<div class="panel panel-red">
						<div class="panel-heading">Parameter</div>
						
						<form role="form" name="AddEmployee">
							<div class="panel-body">';
								echo 
								'<h1>'.$mysqli->query("select concat(first_name,' ',middle_name,'. ', last_name, ' - ', format(salary,2)) full_name from employee where company_id_no = '{$_POST['id']}'")->fetch_object()->full_name.'</h1>
								<table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info">
                                    <thead>';
									
								echo '<tr role="row">
											<th>Salary Logs</th>
											<th>Transaction Date</th>
										</tr>';
								
								
								$qq = $mysqli->query("select * from  salary_logs where employee  = '{$_POST['id']}'");
                                
								
								
                                    
									
								echo '</thead>
                                    <tbody>';
                                       if($qq->num_rows > 0){
											$soh = 0;
											while($rr = $qq->fetch_object()){
												echo '<tr class="gradeA odd" role="row">
															<td>'.number_format($rr->salary,2).'</td>
															<td>'.$rr->transaction_date.'</td>
														</tr>';
											}
									} 
                                   
										
								echo'</tbody>
                                </table>';
        
                                
								echo '</div>
								
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>';
    }
    
    
	if($_POST['action'] == 'Show Logs'){
        // $q = $mysqli->query("select * from {$_POST['Table']} where id = {$_POST['id']}");
        
        echo '<div class="row" id = "rowCrossCheckValidation">
				
				<div class="col-lg-12 Error-Message-Box" style="display:none;">
					<div class="alert alert-danger">
						<div class="Error-Message">Please insert field.</div>
					</div>
				</div>
				
				<div class="col-lg-12">
					<div class="panel panel-red">
						<div class="panel-heading">Parameter</div>
						
						<form role="form" name="AddEmployee">
							<div class="panel-body">';
								
								echo 
								'<h1>'.$mysqli->query("select description from ".str_replace("_stock_logs","",$_POST['Table'])." where code = '{$_POST['code']}'")->fetch_object()->description.' - Ending '.$mysqli->query("select soh description from ".str_replace("_stock_logs","",$_POST['Table'])." where code = '{$_POST['code']}'")->fetch_object()->description.'</h1>
								<table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info">
                                    <thead>';
									
								echo '<tr role="row">
											<th>Requested By</th>
											<th>Beginning Qty</th>
											<th>Price</th>
											<th>Total Price</th>
											<th>Type</th>
											<th>Ending Qty</th>
											<th>Transaction Date</th>
										</tr>';
								
								
								$qq = $mysqli->query("select * from `{$_POST['Table']}` where ".str_replace("_stock_logs","",$_POST['Table'])." = '{$_POST['code']}'");
                                
								
								
                                    
									
								echo '</thead>
                                    <tbody>';
                                       if($qq->num_rows > 0){
											$soh = 0;
											while($rr = $qq->fetch_object()){
												if($rr->type == 'in'){
													$soh += $rr->qty;													
												}else{
													$soh -= $rr->qty;													
												}
												
												if(isset($rr->motorcycle_master_list)){
													if($rr->motorcycle_master_list == '0'){
														if($rr->type == 'out'){
															$rr->motorcycle_master_list = 'OUT';
														}else{
															$rr->motorcycle_master_list = 'New Stock';
															
														}
													}
												}else{
													
													$xyz = $mysqli->query("select concat(first_name,' ',middle_name,', ',last_name) full_name 
																		  from employee where company_id_no = {$rr->employee}");
													if($xyz->num_rows > 0){
														$rr->motorcycle_master_list = $xyz->fetch_object()->full_name;														
													}else{
														if($rr->type == 'in'){
															$rr->motorcycle_master_list = "New Stock";
														}else{
															$rr->motorcycle_master_list = "OUT";															
														}
													}
												}
												
												
												echo '<tr class="gradeA odd" role="row">
															<td>'.$rr->motorcycle_master_list.'</td>
															<td>'.$rr->qty.'</td>
															<td>'.$rr->price.'</td>
															<td>'.($rr->qty * $rr->price).'</td>
															<td class="center">'.strtoupper($rr->type).'</td>
															<td class="center">'.$soh.'</td>
															<td class="center">'.$rr->transaction_date.'</td>
														</tr>';
											}
									} 
                                   
										
								echo'</tbody>
                                </table>';
        
                                
								echo '</div>
								
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>';
    }
    
    if($_POST['action'] == 'Edit'){
		if($_POST['Table']=='stocklog'){
			
			$q=$mysqli->query("

									SELECT * FROM (

									SELECT stocklog.*,dealer.first_name,dealer.middle_name,dealer.last_name FROM stocklog
									LEFT JOIN so_details ON so_details.si = stocklog.so 
									AND so_details.product = stocklog.product_code
									LEFT JOIN so ON so.id = so_details.si
									LEFT JOIN dealer ON dealer.id=so.dealer
									WHERE

									product_code = '{$_POST['product']}' 
									AND (dss = '' OR dss IS NULL) AND dealer.id IS NOT NULL

									UNION ALL 

									SELECT tbl.*,dealer.first_name,dealer.middle_name,dealer.last_name FROM (
									SELECT stocklog.* FROM stocklog
									LEFT JOIN so_details ON so_details.si = stocklog.so 
									AND so_details.product = stocklog.product_code
									LEFT JOIN so ON so.id = so_details.si
									LEFT JOIN dealer ON dealer.id=so.dealer
									WHERE
									product_code = '{$_POST['product']}' AND  (dss = '' OR dss IS NULL)
									AND dealer.id IS  NULL

									) tbl

									INNER JOIN promo ON promo.`promo_code` = tbl.promo
									INNER JOIN promo_details 
									ON promo_details.promo = promo.id AND  promo_details.`product` = tbl.product_code
									INNER JOIN so ON so.id = tbl.so
									INNER JOIN so_details ON so_details.`promo_code` = tbl.promo
									INNER JOIN dealer ON dealer.id = so.`dealer` 
									GROUP BY so,promo
									ORDER BY id ASC
									
									
									) tblb
								
									UNION ALL 

									SELECT * ,
									'' first_name,'' middle_name,'' last_name
									FROM stocklog WHERE dss > 0 AND product_code = '{$_POST['product']}' 
									#ORDER BY id ASC
									
									UNION ALL 
									
									SELECT tbl.*,dealer.first_name,dealer.middle_name,dealer.last_name FROM (
									SELECT stocklog.* FROM stocklog
									LEFT JOIN so_details ON so_details.si = stocklog.so 
									AND so_details.product = stocklog.product_code
									LEFT JOIN so ON so.id = so_details.si
									LEFT JOIN dealer ON dealer.id=so.dealer
									WHERE
									product_code = '{$_POST['product']}'  AND  (dss = '' OR dss IS NULL)
									AND dealer.id IS  NULL

									) tbl

									INNER JOIN promob1t1 ON promob1t1.`promo_code` = tbl.promo 
									#and promob1t1.`product` = tbl.product_code
									INNER JOIN so ON so.id = tbl.so
									INNER JOIN so_details ON so_details.`promo_code` = tbl.promo
									INNER JOIN dealer ON dealer.id = so.`dealer`  
									#where so = '1567'
									GROUP BY so,product_description
									ORDER BY id ASC

 
							
							");
							
			
			
			if($q->num_rows > 0){
				$cnt = 1;
				echo '<table id="fetch_data" class="table table-striped table-bordered table-hover">';
				echo '<thead><tr class="warning">
				<th>#</th>
				<th>Product Code</th>
				<th>Product Description</th>
				<th>Type</th>
				<th>Qty</th>
				<th>Begining Balance</th>
				<th>Ending Balance</th>
				<th>SO #</th>
				<th>DEALER</th>
				
				</tr>
				<tbody>';
				while($r=$q->fetch_object()){
					// echo $cnt;
					echo '<tr>
							<td>'.$cnt.'</td>
							<td>'.$r->product_code.'</td>
							<td>'.$r->product_description.'</td>
							<td>'.$r->inventory_type.'</td>
							<td>'.($r->ending_balance - $r->begining_balance).'</td>
							<td>'.$r->begining_balance.'</td>
							<td>'.$r->ending_balance.'</td>
							<td>'.$r->so.'</td>
							<td>'.$r->first_name.' '.$r->middle_name.' '.$r->last_name.'</td>
							</tr>';
					$cnt++;
					// die();
					
				}
				echo '</tbody></table>';
			}
			
		}else{
			$q = $mysqli->query("select * from {$_POST['Table']} where id = {$_POST['id']}");
        
        echo '<div class="row" id = "rowCrossCheckValidation">
				
				
				<div class="col-lg-12">
					<div class="panel panel-red">
						<div class="panel-heading">Parameter</div>
						
							<form role="form" name="AddEmployee">
								<div class="panel-body">';
									
									// $in_array = array('id');
								
									while($r = $q->fetch_object()){
									  
									   $datepicker = '';
									   $in_array = array('id');
										foreach($r as $f =>$v){
											if(!in_array($f,$in_array)){
												$check_tables_q = $mysqli->query("SHOW TABLES");
												$validated = 0;
												$tableoption = "";
												while($check_tables_r = $check_tables_q->fetch_object()){
													if($f == $check_tables_r->Tables_in_pos){
														$validated = 1;
														$tableoption = $f;
														break;
													}
													
													if($f == 'name_of_recommender'){
														$tableoption = $f;
														$validated = 1;
														break;
													}
													
													if($f == 'driver'){
														$tableoption = $f;
														$validated = 1;
														break;
													}
													
													if($f == 'Mother_ID'){
														$tableoption = $f;
														$validated = 1;
														break;
													}
													
													if($f == 'Recruiter_ID'){
														$tableoption = $f;
														$validated = 1;
														break;
													}
												}
												
												
												if($validated == 1){
													if($tableoption == 'Recruiter_ID'){
														// die('x');
														$option_q = $mysqli->query("select id code, concat(first_name,' ',middle_name,' ',last_name  ) description from `dealer`");
													}elseif($tableoption == 'Mother_ID'){
														// die('x');
														$option_q = $mysqli->query("select id code, concat(first_name,' ',middle_name,' ',last_name  ) description from `dealer` where level  like '%BOM%' order by first_name asc");
													}else{
														$option_q = $mysqli->query("select * from `{$tableoption}`");
													}
													// $option_q = $mysqli->query("select * from `{$tableoption}`");
													$options = "<option value = 0>[SELECT : HERE]</option>";
													
													if($option_q->num_rows > 0){
														if($tableoption == 'employee' || $tableoption=='name_of_recommender'|| $tableoption=='driver'){
															while($option = $option_q->fetch_object()){
																$selected = "";
																if($option->company_id_no == $v){
																	$selected = "selected";
																}
																$options .= "<option {$selected} value = '{$option->company_id_no}'>{$option->first_name} {$option->last_name}</option>";
															}
														}else{
															while($option = $option_q->fetch_object()){
																$selected = "";
																if($option->code == $v){
																	$selected = "selected";
																}
																$options .= "<option {$selected} value = '{$option->code}'>{$option->description}</option>";
															}
														}
														
														
														
														echo 	'<div class="row col-lg-4">
																	<div class="col-lg-10">
																		<div class="form-group">
																			<label>'.strtoupper(str_replace('_',' ',$f)).'</label>
																			<select class = "form-control" name = "'.$f.'">'.$options.'</select>
																		</div>
																	</div>
																</div>';
													}
												}else{
														
													// if($f=='note'){
															// echo '	<div class="row col-lg-4">
																		// <div class="col-lg-10">
																			// <div class="form-group">
																				// <label>'.strtoupper(str_replace('_',' ',$f)).'</label>
																				// <textarea placeholder = "* Use this for remarks only" name="'.$f.'" class="form-control">'.$v.'</textarea>
																			// </div>
																		// </div>
																	// </div>';
													// }else{
															echo 	'<div class="row col-lg-4">
																		<div class="col-lg-10">
																			<div class="form-group">
																				<label>'.strtoupper(str_replace('_',' ',$f)).'</label>
																				<input '.$datepicker.' type="text"  name="'.$f.'"  class="form-control '.$datepicker.'" value="'.$v.'" />
																			</div>
																		</div>
																	</div>';
													// }
												}
												
												
											
											}
										}
							   
										 
									}
			
									
						echo    '</div>
							</form>
								
						</div>
					</div>
				</div>';
		}
	   
    }
    
	if($_POST['action'] == 'ViewDTR'){
        $q = $mysqli->query("select concat(first_name,' ',middle_name,', ',last_name) name from employee where company_id_no = {$_POST['id']}");
        $res = $q->fetch_object();
		$validated = 0;
		
		if(isset($_POST['DateFrom']) && isset($_POST['DateTo'])){
			$datefrom = date("Y-m-d",strtotime($_POST['DateFrom']));
			$dateto = date("Y-m-d",strtotime($_POST['DateTo']));
			
			
			
			
			$query = $mysqli->query("
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
								WHERE employee_id = {$_POST['id']} and date(datetime) between '{$datefrom}' and '{$dateto}'
								GROUP BY DATE(t.`datetime`) ORDER BY DATETIME ASC 
							) tbl
						) tbla 
						INNER JOIN employee e ON tbla.employee_id = e.company_id_no ORDER BY tbla.Date ASC
					) tblb ORDER BY tblb.Date ASC");
			
			$validated = 1;
		}
		
        echo '<div class="row" id = "rowCrossCheckValidation">
				
				<div class="col-lg-12 Error-Message-Box" style="display:none;">
					<div class="alert alert-danger">
						<div class="Error-Message">Please insert field.</div>
					</div>
				</div>
				
				<div class="col-lg-12">
					<div class="panel panel-red">
						<div class="panel-heading">Parameter</div>
						
						<form role="form" name="DTRForm">
							<div class="panel-body">';
						   echo '
								<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label>'.$res->name.'</label>
										
									</div>
								</div>
								</div>
								<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label>Date From</label>
										<input type="text"  name="Date_From" class="form-control datepicker"  />
									</div>
								</div>
								</div>
								<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label>Date To</label>
										<input type="text"  name="Date_To" class="form-control datepicker"  />
									</div>
								</div>
								</div>
								
								
								<div class="table-responsive"><table id="fetch_data" class="table table-striped table-bordered table-hover">
					<thead>
						<tr class="warning">
							<th>IsOT</th>
							<th>Date</th>
							<th>Day</th>
							<th>Time In</th>
							<th>Time Out</th>
							<th>Total Hours</th>
							<th>Over Time</th>
							<th>Undertime Lates</th>
							<th>Status</th>
							<th>Salary per Day</th>
						</tr>
					</thead>
					<tbody>';
					if($validated == 1){
						if($query->num_rows > 0){
							$TotalAmount = 0;
							while($row = $query->fetch_object()){
								$checked = "";
								$overtime = 0;
								$lates = 0;
								$totalhours = ($row->TotalHours - 1);
								if($row->IsOT == 1){
									$value = "OT";
									$checked = "checked";
									$totalhours = 0;
									$overtime = ($row->TotalHours - 1);
								}else{
									if($totalhours < 9){
										$lates = 9 - $totalhours;
									}
									$value = "Regular";
								}
								
								if($row->valuefour == 1){
									$value = "Leave";

								}
							echo '<tr>
									<td align="center"><input type = "checkbox" '.$checked.' name = "timeinid[]" value = "'.$row->id.'"></td>
									<td align="center">'.$row->Date.'</td>
									<td align="center">'.$row->Day.'</td>
									<td align="center">'.$row->TimeInFormat.'</td>
									<td align="center">'.$row->TimeOutFormat.'</td>
									<td align="center">'.$totalhours.'</td>
									<td align="center">'.$overtime.'</td>
									<td align="center">'.$lates.'</td>
									<td align="center">'.$value.'</td>
									<td align="center">'.$row->SalaryPerDay.'</td>
								  </tr>';
								  $TotalAmount += str_replace(',','',$row->SalaryPerDay);
							}
							echo '<tr>
									
									<td align="center" colspan = 6>Total Amount</td>
									<td align="center">'.number_format($TotalAmount,2).'</td>
								  </tr>';
						}
						
						
					}else{
						echo '<tr><td colspan = 1000 align="center">No Record found(s)</td></tr>';
					}
					

					echo'</table></div>';
					
                                
							echo '</div>
								
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>';
    }
    
	
    if($_POST['action'] == 'savetimeinoutOT'){
		//print_r($_POST);
		
		/*
		Array
			(
				[Date_From] => 
				[Date_To] => 
				[timeinid] => Array
					(
						[0] => 13218
					)

				[Table] => timeinout
				[action] => savetimeinoutOT
			)
		*/
		
		foreach($_POST['timeinid'] as $k => $v){
			$mysqli->query("update timeinout set IsOT = 1 where id = {$v}");
		}
		$resp=array();
		$resp['response'] = 'success';
		
		die(json_encode($resp));
		
	}
    
	if($_POST['action'] == 'Upload'){
        
        
        echo '<div class="row" id = "rowCrossCheckValidation">
			<div class="col-lg-12">
				<div class="panel panel-red">
					<div class="panel-heading">
						Parameter
					</div>
					
					 <form class="form-horizontal" role="form" name="DateUploaderForm" enctype="multipart/form-data">
						<div class="panel-body">
						
							<div class="col-lg-12 Error-Message-Box" style="display:none;">
								<div class="alert alert-danger">
									<div class="Error-Message">Please insert field.</div>
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-lg-2">Selection : </label>
								<div class="col-lg-3">
									<select name="Selection" class="form-control">
										<option value="1">Upload Employee</option>
										<option value="2">Upload DTR ( Daily Time Record )</option>
										<option value="3">Update Tin, SSS & Pagibig no</option>
										<option value="4">Upload No In and Out</option>
										<option value="5">Upload Ovetime</option>
                                    </select>
								</div>
							</div>
							
							
							<div class="update" style="display:none;">
								<div class="form-group">
									<label class="control-label col-lg-2">Date Uploaded : </label>
									<div class="col-lg-3">
										<input type="text" name="DateUploaded" placeholder="<?=date("m/d/Y");?>" class="form-control" />
									</div>
									<div class="col-lg-2">
										<p class="form-control-static"><i>e.g. MM/DD/YYYY</i></p>
									</div>
								</div>
							</div>
							
							<div class="form-group upload">
								<label class="control-label col-lg-2">Upload File : </label>
								<div class="col-lg-6">
									<input type="file" data-desc="Service Icon Required" name="FileToUpload"  class="form-control" />
								</div>
							</div>
							
							
						</div>
						<div class="panel-footer">
							<a a href="download/hr.csv" download><span class="glyphicon glyphicon-edit"></span> <b>Download Format</b> </a>
							<br />
							<!-- i><span class="fa fa-warning"></span> * Note : Please download the procedure. c/o Emma Lasala & Joy Villaruel</i -->
							
						</div>
					</form>
				</div>
				
				<div class="panel panel-green editdltable" style="display:none;">
					<div class="panel-heading">
						DL Information
					</div>
					<div class="panel-body">
						<table class="table table-bordered">
							<tr><td>No result found...</td></tr>
						</table>
					</div>
				</div>
			</div>
		</div>';
        
    }
    
    
    if($_POST['action']=='Save'){
        
        $field = array();
        $value = array();
        $in_array = array('Save','array');
        
		$table_q = $mysqli->query("SHOW TABLES");
		if($table_q->num_rows > 0){
			while($table_r = $table_q->fetch_object()){
				$in_array[] = $table_r->Tables_in_pos;
			}
		}
		
		if(isset($_POST['date'])){
			$_POST['date'] = date("Y-m-d",strtotime($_POST['date']));
		}
		if(isset($_POST['date_start'])){
			$_POST['date_start'] = date("Y-m-d",strtotime($_POST['date_start']));
			$_POST['date_end'] = date("Y-m-d",strtotime($_POST['date_end']));
		}
		
		
		
		foreach($_POST as $f => $v){
					
					
					
            if($f != 'transfer'){
				
				if(!in_array($v,$in_array)){
					
					
					
					// echo count($v);
					if($_POST['Table'] == 'promo'){
							if($f == 'product'){
								if(count($_POST[$f]) == 1){
									$field[] = "`{$f}`";
									$value[] = "'{$_POST[$f][0]}'";   
								}
								
							}elseif($f == 'price'){
								if(count($_POST[$f]) == 1){
									$field[] = "`{$f}`";
									
									if($_POST['promo_condition'] == ''){
										$value[] = "'{$_POST[$f][0]}'";   
									}else{
										$value[] = "'{$_POST[$f]}'";   
									}
									
									
								}
							}else{
								$field[] = "`{$f}`";
								$value[] = "'{$v}'";   
							}
					}else{
						$field[] = "`{$f}`";
						$value[] = "'{$v}'";   
					}
				
					
					
					
				}
			}
			
        }
		// echo "insert into {$_POST['Table']} (".implode(',',$field).") values (".implode(',',$value).")";
		
		if(isset($_POST['code'])){
			//for validation..
			$check = $mysqli->query("select * from {$_POST['Table']} where code = '{$_POST['code']}'")->num_rows;
			if($check > 0){
				die(json_encode(array("response"=>"failed")));				
			}
		}
		
		// office_supply_stock_logs
		if($_POST['Table'] =='so'){
			//dealer
			$dealer_info = $mysqli->query("select * from dealer where id = '{$_POST['dealer']}'")->fetch_object();
			$level_info = $mysqli->query("select * from level where code = '{$dealer_info->level}'")->fetch_object();
			
			$Date = date("Y-m-d",strtotime($_POST['delivery_date']));
			$credit_limit = $dealer_info->credit_limit;
			
			// echo $Date;
			
			$due_date = date("Y-m-d",strtotime($Date.' + '.$level_info->Terms.' days'));
			// $dealer_discount = 
			$additional_discount = 0;
			$dealer_discount = $_POST['total_price'] * ($level_info->discount / 100);

			$outstanding_balance = $_POST['total_price'] - $dealer_discount;
			$credit_limit_logs = $credit_limit;
			$available_credit_limit = $credit_limit - $outstanding_balance;
			// echo $available_credit_limit;
			// promo
			
			if($available_credit_limit > 0){
				$_POST['vat'] = 0.00;
				// transaction_date
				$mysqli->query("insert into so 
								(dealer,si,total_price,vat,additional_discount,outstanding_balance,due_date,begining_credit_limit,
								 ending_credit_limit,created_by,dealer_discount,transaction_date,delivery_date) values
								({$_POST['dealer']},0,{$_POST['total_price']},{$_POST['vat']},{$additional_discount},
								{$outstanding_balance},
								 '{$due_date}',
								{$credit_limit_logs},
								{$available_credit_limit},
								{$_SESSION['empid']},
								{$dealer_discount},now(),'{$Date}')");
								
				$_POST['so'] = $mysqli->insert_id;

				
				


				$mysqli->query("UPDATE so SET  vat = 
								(total_price  - (dealer_discount+additional_discount))-  ((total_price - (dealer_discount+additional_discount))/1.12) 
								where  id = {$_POST['so']}");

				for($x = 0; count($_POST['qty']) > $x; $x++){
					if($_POST['qty'][$x] != "" || $_POST['qty'][$x] != 0 ){
						
						$mysqli->query("INSERT INTO `so_details` (
						`si`,`product`,`product_description`,`qty`,`unit_price`,`sub_total`,promo_code)
						VALUES
						({$_POST['so']},'{$_POST['product'][$x]}','{$_POST['product_description'][$x]}','{$_POST['qty'][$x]}','{$_POST['unit_price'][$x]}',
						'{$_POST['sub_total'][$x]}','{$_POST['promo_code'][$x]}'
						);");
						
						
						//now validate the promo set ...
						$promo_set = $mysqli->query("SELECT * FROM promo 
						WHERE promo_code = '{$_POST['promo_code'][$x]}' AND promo_condition = 'SET'");
						
						//now validate the promo b1t1 ...
						$promo_set_set_free_offer = $mysqli->query("SELECT * FROM promob1t1 WHERE promo_code = '{$_POST['promo_code'][$x]}'");
						
						
						if($promo_set->num_rows > 0){
							$promo_id = $promo_set->fetch_object()->id;
							
							//now create a logs for promo set..
							//get_the original soh..
							$product_info_q = $mysqli->query("SELECT product.* FROM product 
							INNER JOIN promo_details ON product.code = promo_details.product WHERE promo_details.`promo` = '{$promo_id}'");
							
							
							if($product_info_q->num_rows > 0){
								while($product_info_r = $product_info_q->fetch_object()){
									//get_the original soh..
									$product_info = $mysqli->query("select * from product 
									where code = '{$product_info_r->code}'")->fetch_object();
									
							
									//now decrease stocks
									$mysqli->query("update product set soh = soh - {$_POST['qty'][$x]} where code = '{$product_info_r->code}'");
									$updated_stocks = $mysqli->query("select soh from product where 
									code = '{$product_info_r->code}'")->fetch_object()->soh;
									
									// now add this item from stockard....
									$mysqli->query("INSERT INTO `stocklog` (
									`product_code`,promo,`product_description`,  `begining_balance`,
									`ending_balance`,  `transaction_date`, `created_by`,inventory_type,so)
									VALUES
									(
										'{$product_info->code}',
										'{$_POST['promo_code'][$x]}',
										'{$product_info->description} SET PROMO','{$product_info->soh}','{$updated_stocks}',
										now(),'{$_SESSION['empid']}','Out',{$_POST['so']}
									);");
							
								}
							}
							
							
							
						}elseif($promo_set_set_free_offer->num_rows > 0){
							
							
							
							$promo_id = $promo_set_set_free_offer->fetch_object()->id;
							
							//now create a logs for promo set..
							//get_the original soh..
							$product_info_q = $mysqli->query("SELECT promob1t1.* FROM product 
							INNER JOIN promob1t1 ON product.code = promob1t1.product WHERE promob1t1.`id` = '{$promo_id}'");
							
							
							
							if($product_info_q->num_rows > 0){
								while($product_info_r = $product_info_q->fetch_object()){
									//get_the original soh..
									$product_info = $mysqli->query("select * from product 
									where code = '{$product_info_r->product}'")->fetch_object();
									
							
									//now decrease stocks
									$mysqli->query("update product set soh = soh - ({$_POST['qty'][$x]} * {$product_info_r->qty}) 
									where code = '{$product_info_r->product}'");
									
									$updated_stocks = $mysqli->query("select soh from product where 
									code = '{$product_info_r->product}'")->fetch_object()->soh;
									
									// now add this item from stockard....
									
									$mysqli->query("INSERT INTO `stocklog` (
									`product_code`,promo,`product_description`,  `begining_balance`,
									`ending_balance`,  `transaction_date`, `created_by`,inventory_type,so)
									VALUES
									(
										'{$product_info_r->product}',
										'{$_POST['promo_code'][$x]}',
										'{$product_info->description}','{$product_info->soh}','{$updated_stocks}',
										now(),'{$_SESSION['empid']}','Out',{$_POST['so']}
									);");
									
									
									// free items..
									
									//get_the original soh..
									$product_info = $mysqli->query("select * from product 
									where code = '{$product_info_r->product_free}'")->fetch_object();
									
							
									//now decrease stocks
									$mysqli->query("update product set soh = soh - ({$_POST['qty'][$x]} * {$product_info_r->qty_free}) 
									where code = '{$product_info_r->product_free}'");
									
									$updated_stocks = $mysqli->query("select soh from product where 
									code = '{$product_info_r->product_free}'")->fetch_object()->soh;
									
									// now add this item from stockard....
									$mysqli->query("INSERT INTO `stocklog` (
									`product_code`,promo,`product_description`,  `begining_balance`,
									`ending_balance`,  `transaction_date`, `created_by`,inventory_type,so)
									VALUES
									(
										'{$product_info_r->product_free}',
										'{$_POST['promo_code'][$x]}',
										'{$product_info->description} FREE ITEM','{$product_info->soh}','{$updated_stocks}',
										now(),'{$_SESSION['empid']}','Out',{$_POST['so']}
									);");
									
							
								}
							}
							
							
							
						}else{
							//get_the original soh..
							$product_info = $mysqli->query("select * from product where code = '{$_POST['product'][$x]}'")->fetch_object();
							
							
							//now decrease stocks
							$mysqli->query("update product set soh = soh - {$_POST['qty'][$x]} where code = '{$_POST['product'][$x]}'");
							$updated_stocks = $mysqli->query("select soh from product where code = '{$_POST['product'][$x]}'")->fetch_object()->soh;
							
							// now add this item from stockard....
							$mysqli->query("INSERT INTO `stocklog` (
									`product_code`,promo,`product_description`,  `begining_balance`,
									`ending_balance`,  `transaction_date`, `created_by`,inventory_type,so)
									VALUES
									(
										'{$product_info->code}',
										'{$_POST['promo_code'][$x]}',
										'{$product_info->description}','{$product_info->soh}','{$updated_stocks}',
										now(),'{$_SESSION['empid']}','Out',{$_POST['so']}
									);");
						}
						
						
						
					}
				}
				
				//cpi..
				
				$mysqli->query("
								UPDATE 
								so  SET 
								cpi = IFNULL((SELECT SUM(sub_total) FROM so_details 
								INNER JOIN product ON product.code = so_details.product 
								AND product.`is_nontrade` = 1
								WHERE si = so.id),0)
								WHERE `status` = 'confirmed'
								and id = {$_POST['so']}
				");
				
				
				
				// for non-trade..
				
				$additional_discount_q = $mysqli->query("SELECT SUM(sub_total) subtotal FROM so_details 
													WHERE product 
													IN (
														SELECT Code FROM product WHERE is_nontrade = 1
													) AND si = {$_POST['so']}");
													
				if($additional_discount_q->num_rows > 0){
					while($additional_discount_r= $additional_discount_q->fetch_object()){
						$additional_discount = $additional_discount_r->subtotal;
						$additional_discount_get_dealer_discount = $additional_discount_r->subtotal * .20;
						
					}
				}
				
				// echo "update so set additional_discount = additional_discount - {$additional_discount_get_dealer_discount} where id = {$_POST['so']}";
				// echo $additional_discount_get_dealer_discount;
				// die();
				
				$mysqli->query("update so set dealer_discount = dealer_discount - {$additional_discount_get_dealer_discount}, outstanding_balance = outstanding_balance +  {$additional_discount_get_dealer_discount} where id = {$_POST['so']}");
				
				
				
				
				$non_trade = $mysqli->query("
				
						SELECT IFNULL(SUM(sub_total),0) non_trade FROM so_details
						WHERE si IN 
						(
							SELECT id
							FROM so 
							WHERE dealer = {$_POST['dealer']} AND
							MONTH(transaction_date) = MONTH(CURDATE()) 
							AND YEAR(transaction_date) = YEAR(CURDATE()) 
							AND STATUS = 'confirmed'
						) AND 
						product 
						IN (
							SELECT Code FROM product WHERE is_nontrade = 1
						)
				")->fetch_object()->non_trade;
				
				
				// $mysqli->query("update so set 
				// dealer_discount = dealer_discount + {$additional_discount_get_dealer_discount} 
				// where id = {$_POST['so']}");
				
				// additional discount for non-trade 
				
				
													
				// if($additional_discount_q->num_rows > 0){
					// while($additional_discount_r= $additional_discount_q->fetch_object()){
						// $additional_discount = $additional_discount_r->subtotal;
						// $additional_discount_get_dealer_discount = $additional_discount_r->subtotal * .20;
						
					// }
				// }
				
				
				
				
				// for additional_discount routines..
				$addtional_discount_amount = 0;
				/*
					SELECT SUM(total_price) FROM so WHERE dealer = '1' AND MONTH(transaction_date) = MONTH(CURDATE()) AND YEAR(transaction_date) = YEAR(CURDATE())
					SELECT * FROM additional_discount WHERE 5600 BETWEEN amount_from AND amount_to			
				*/
				
				$total_gross_sales_q = $mysqli->query("SELECT ifnull(SUM(total_price) - SUM(dealer_discount),0) total_gross_sales
							   FROM so 
							   WHERE dealer = '{$_POST['dealer']}' 
							   AND MONTH(transaction_date) = MONTH(CURDATE()) 
							   AND YEAR(transaction_date) = YEAR(CURDATE()) 
							   and status = 'confirmed'");
				
				if($total_gross_sales_q->num_rows > 0){
					$total_gross_sales = $mysqli->query("SELECT ifnull(SUM(total_price) - SUM(dealer_discount),0) total_gross_sales
							   FROM so 
							   WHERE dealer = '{$_POST['dealer']}' 
							   AND MONTH(transaction_date) = MONTH(CURDATE()) 
							   AND YEAR(transaction_date) = YEAR(CURDATE()) 
							   and status = 'confirmed'")->fetch_object()->total_gross_sales;
				}else{
					$total_gross_sales = 0;
				}
				// dealer_discount
				$total_gross_sales -= $non_trade;
				
				//now check here if passed the additional discount
				$additional_discount_query = $mysqli->query("SELECT * 
				FROM additional_discount WHERE {$total_gross_sales} BETWEEN amount_from AND amount_to");
				
				
				
				$additional_discount = 0;
				if($additional_discount_query->num_rows > 0){
					
					$additional_discount = $total_gross_sales * ($additional_discount_query->fetch_object()->percent / 100);
					// additional discount.. 
					
					$additional_discount_existing = $mysqli->query("SELECT ifnull(SUM(additional_discount),0.00)  additional_discount
							   FROM so 
							   WHERE dealer = '{$_POST['dealer']}' 
							   AND MONTH(transaction_date) = MONTH(CURDATE()) 
							   AND YEAR(transaction_date) = YEAR(CURDATE()) and status = 'confirmed'");
							   
					if($additional_discount_existing->num_rows > 0){
						$additional_discount_existing = $additional_discount_existing->fetch_object()->additional_discount;
					}else{
						$additional_discount_existing = 0;
					}
					
					$additional_discount -= $additional_discount_existing;
					
					
				}
				// $_POST['so']
				$mysqli->query("update so set additional_discount = {$additional_discount}  where id = {$_POST['so']}");
				$mysqli->query("update so set outstanding_balance =  outstanding_balance - additional_discount where id = {$_POST['so']}");
				
				//update vat..
				// $additional_discount_get_dealer_discount
				
				
				// $dealer_discount
				$discounts = $additional_discount + $dealer_discount;
				//get vat..
				// net_of_vat = parseFloat(total_subtotal) - (parseFloat(total_subtotal)  / parseFloat(1.12) );
				// $less_vat = 	($_POST['total_price'] - $discounqts) / 1.12;
				// $vat_gross_sales_less_discounts = $_POST['total_price'] - $less_vat
				// $_POST['total_price'] -= ( $discounts)
				// $mysqli->query("update so set outstanding_balance =  {$vat_gross_sales_less_discounts} where id = {$_POST['so']}");
				
				
				
			
				$outstanding_balance = $mysqli->query("select outstanding_balance from so where id = '{$_POST['so']}'")->fetch_object()->outstanding_balance;
				//now update dealer credit_limit..
				$mysqli->query("update dealer set credit_limit = credit_limit-{$outstanding_balance} where id = '{$_POST['dealer']}'");
				
				//end here.. 
				die(json_encode(array("id"=>$_POST['so'])));
			}else{
				die(json_encode(array("id"=>0)));
			}
			
			
		}elseif($_POST['Table'] =='promo'){
			  
			  
			  if($_POST['promo_type'] == 'SINGLE LINE'){
				  foreach($_POST['product'] as $key => $value){
						$mysqli->query("insert into {$_POST['Table']}  
						(promo_code,promo_description,promo_type,promo_condition,any,date_start,date_end,product,price,transaction_date)
						values 
						(	'{$_POST['promo_code']}',
							'{$_POST['promo_description']}',
							'{$_POST['promo_type']}',
							'{$_POST['promo_condition']}',
							'{$_POST['any']}',
							'{$_POST['date_start']}',
							'{$_POST['date_end']}',
							'{$value}',
							'{$_POST['price'][$key]}',
							now()
						)");
				  }
			  }else{
				   // if($_POST['product'] == 1){
						 
							$mysqli->query("insert into {$_POST['Table']} (".implode(',',$field).") values (".implode(',',$value).")");				 
					 // }
						$_POST['promo'] = $mysqli->insert_id;
						
						if(count($_POST['product']) > 1){
							foreach($_POST['product'] as $key => $value){
								$mysqli->query("insert into {$_POST['Table']}_details values (null,{$_POST['promo']},'{$value}','{$_POST['price'][$key]}')");	
							}
						}
			  }
		
			
				
			
			
		}elseif($_POST['Table'] =='official_receipt'){
			   
			 
			   
			   /*Array ( 
			   [dealer] => 1 [date] => 2020-07-29 
			   [mode_of_payment] => CASH 
			   [amount] => 500 
			   [particulars] => s 
			   [action] => Save 
			   [Table] => official_receipt )*/
			   $amount = $_POST['amount'];
			   
			   $so = $mysqli->query("select * from so where dealer = '{$_POST['dealer']}' and status = 'confirmed' and outstanding_balance > 0 order by due_date asc");
			   $mysqli->query("insert into {$_POST['Table']} (".implode(',',$field).") values (".implode(',',$value).")");
			   $_POST['last_isert_id'] = $mysqli->insert_id;
			   
			   if($so->num_rows > 0){
				   while($so_r = $so->fetch_object()){
					   if($amount == $so_r->outstanding_balance ){
						   $mysqli->query("update so set outstanding_balance = 0 where id = {$so_r->id}");
						   
						   $mysqli->query("insert into official_receipt_details 
										   (official_receipt,so,amount)
										   values
										   ({$_POST['last_isert_id']},{$so_r->id},{$so_r->outstanding_balance});
										");
						   
						   
						   $amount = 0;
						   break;
					   }elseif($amount < $so_r->outstanding_balance){
						   // $amount = 0;
						   $mysqli->query("update so set outstanding_balance = outstanding_balance - {$amount} where id = {$so_r->id}");
						   // $amount = $so_r->outstanding_balance - $amount;
						   $mysqli->query("insert into official_receipt_details 
										   (official_receipt,so,amount)
										   values
										   ({$_POST['last_isert_id']},{$so_r->id},{$amount});
										");
						   $amount = 0;
						   break;
					   }else{
						   $mysqli->query("update so set outstanding_balance = 0  where id = {$so_r->id}");
						   
						   $mysqli->query("insert into official_receipt_details 
										   (official_receipt,so,amount)
										   values
										   ({$_POST['last_isert_id']},{$so_r->id},{$so_r->outstanding_balance}); ");
										   
						   $amount -= $so_r->outstanding_balance;
						   
						   
					   }
				   }
				   
				   $mysqli->query("update {$_POST['Table']} set change = {$amount} where id = {$_POST['last_isert_id']}");
				   $mysqli->query("UPDATE dealer SET credit_limit = credit_limit + {$_POST['amount']} WHERE id = '{$_POST['dealer']}'");
				   
				   
			   }
			   
			   
			  
			   // for inventory and supply..
			
			
			
			
		}elseif($_POST['Table'] =='dss'){
			$mysqli->query("insert into {$_POST['Table']} (".implode(',',$field).") values (".implode(',',$value).")");
			$_POST['last_isert_id'] = $mysqli->insert_id;
			$product = $mysqli->query("select * from product where code = '{$_POST['product']}'")->fetch_object();
			 
			 if($_POST['inventory_type'] == 'In'){
				$updated_soh = $product->soh + $_POST['qty'];
				
				
				
				$mysqli->query("
									
									INSERT INTO `pos`.`stocklog` (
										  `product_code`,
										  `product_description`,
										  `promo`,
										  `begining_balance`,
										  `ending_balance`,
										  `transaction_date`,
										  `created_by`,
										  `inventory_type`,
										  `dss`
										)
										VALUES
										  (
											'{$product->code}',
											'{$product->description}',
											'',
											'{$product->soh}',
											'{$updated_soh}',
											now(),
											{$_SESSION['empid']},
											'In',
											'{$_POST['last_isert_id']}')");
											
				$mysqli->query("update product set soh = soh + {$_POST['qty']}  where code = '{$_POST['product']}'");
				
			 }else{
				$updated_soh = $product->soh - $_POST['qty'];
				
				$mysqli->query("
									
									INSERT INTO `pos`.`stocklog` (
										  `product_code`,
										  `product_description`,
										  `promo`,
										  `begining_balance`,
										  `ending_balance`,
										  `transaction_date`,
										  `created_by`,
										  `inventory_type`,
										  `dss`
										)
										VALUES
										  (
											'{$product->code}',
											'{$product->description}',
											'',
											'{$product->soh}',
											'{$updated_soh}',
											now(),
											{$_SESSION['empid']},
											'Out',
											'{$_POST['last_isert_id']}')");
											
				 $mysqli->query("update product set soh = soh - {$_POST['qty']} where code = '{$_POST['product']}'");
			 }
			
			
		}elseif($_POST['Table'] =='creditline'){
			$action_btn= 0;
			
			
			$mysqli->query("insert into {$_POST['Table']} (".implode(',',$field).") values (".implode(',',$value).")");
			$_POST['last_isert_id'] = $mysqli->insert_id;
			
			$mysqli->query("update dealer set approved_credit_limit = approved_credit_limit + {$_POST['credit_line']}
			,credit_limit = credit_limit + {$_POST['credit_line']}  where id = '{$_POST['dealer']}'");
				
			 
			
			
		}else{
			
			if($_POST['Table'] == 'dealer'){
				//check the dealer if exist..
				$validate_dealer = $mysqli->query("SELECT * FROM dealer WHERE first_name = '{$_POST['first_name']}' AND middle_name = '{$_POST['middle_name']}' AND last_name = '{$_POST['last_name']}'")->num_rows;
				if($validate_dealer > 0){
					// die('x');
					die(json_encode(array("response"=>"failed")));		
				}
			}
			
			
			$mysqli->query("insert into {$_POST['Table']} (".implode(',',$field).") values (".implode(',',$value).")");
			$_POST['last_isert_id'] = $mysqli->insert_id;
			// for inventory and supply..
			
		}
		
				

		die(json_encode(array("response"=>"success")));		
    }
    
    if($_POST['action']=='Update'){
        
        $field = array();
        $value = array();
        $in_array = array();
        $in_array[] = 'Update';
        
		if(isset($_POST['date'])){
			$_POST['date'] = date("Y-m-d",strtotime($_POST['date']));
		}
		if(isset($_POST['date_start'])){
			$_POST['date_start'] = date("Y-m-d",strtotime($_POST['date_start']));
			$_POST['date_end'] = date("Y-m-d",strtotime($_POST['date_end']));
		}
		
		$table_q = $mysqli->query("SHOW TABLES");
		if($table_q->num_rows > 0){
			while($table_r = $table_q->fetch_object()){
				$in_array[] = $table_r->Tables_in_pos;
			}
		}
		
        foreach($_POST as $f => $v){
            if(!in_array($v,$in_array)){

                $field[] = "`{$f}` = '{$v}'";   
            }
        }
        $mysqli->query("update {$_POST['Table']}  set ".implode(',',$field)." where id = ".$_POST['id']);
    }
    
    if($_POST['action']=='UploadDataEmployee'){
       
       if($_POST['Selection'] == "undefined" || !isset($_POST['Selection'])){
			$_POST['Selection'] = 1;
		}
        try{
			$xxxcnt = 0;
			if(isset($_FILES['file']['tmp_name'])){
                $counter = 0;
				if($_POST['Selection'] != 2){
					
					// $line = fgetcsv($file, 0, ",");
				}else{
					$handle = fopen($_FILES['file']['tmp_name'], 'r');
					if ($handle){
						while (($line = fgets($handle)) !== false) {
							// f the line read.
							 $explodeone = explode('	',$line);
							 $value = array();
							 foreach($explodeone as $k => $v){
								 $value[] = "'".trim($v)."'";
							 }
							 // echo "insert into timeinout values(NULL,".@implode(',',$value).")";
							 // die();
							 $mysqli->query("insert into timeinout values(NULL,".@implode(',',$value).",0)");
							 
							 // echo "insert into timeinout values(NULL,".@implode(',',$value).") <br />";
							 $counter++;
						}
						fclose($handle);
						
						$result["ErrorMessage"] = "Data successfully loaded to database. No of record(s) ".$counter;
						die(json_encode($result));
					} else {
					// error opening the file.
					} 
					// die('x');
					 
				}
                $file = fopen($_FILES['file']['tmp_name'], 'r');   
				// print_r(fgetcsv($file));
				// die();
				while(!feof($file)){
						$field = array();
						// print_r($file);
						$line = fgetcsv($file, 0, ",");
						// print_r($line);
						
						if($_POST['Selection'] == 1){
                            
                            // starts here..
							if($xxxcnt == 0){
                               
                                $header = array();
                                foreach($line as $val){
                                    //$field[] = $mysqli->real_escape_string($val);
                                    $get_headers = $mysqli->query("SHOW FULL COLUMNS FROM `{$_POST['table']}`");
                                    while($get_headers_r = $get_headers->fetch_object()){
                                        if(trim($get_headers_r->Field) == trim($val)){
                                            $header[] = "`{$get_headers_r->Field}`";
                                        }
                                    }
                                }
                                
                                
                              
                                
                            }
                            
                           //echo $xxxcnt;
                                
                            if($xxxcnt>0){
                               
                                foreach($line as $val){
                                    $field[] = $mysqli->real_escape_string($val);
                                }

                                $strdata = implode("','", $field);
                                if($field[0] != ""){
                                   
                                    if(!$mysqli->query("INSERT INTO `{$_POST['table']}` (".@implode(',',$header).")VALUES( '".$strdata."')")){

                                        throw new Exception("Error : {$mysqli->error} count: {$counter} IINSERT INTO `{$_POST['table']}` (".@implode(',',$header).")VALUES( '".$strdata."')");
                                    }
                                    $counter++;
                                    $result["ErrorMessage"] = "Data successfully loaded to database. No of record(s) ".$counter;
                                }
                                

                            }
                            
                            $xxxcnt++;
                            //end here..
                            
                            
						}elseif($_POST['Selection'] == 3){ // update ids
							foreach($line as $val){
								$field[] = $mysqli->real_escape_string($val);
							}
							// print_r($field);
							if($field[0] != ""){
								  
									if(!$mysqli->query("UPDATE employee 
														set tin_no = trim('{$field[1]}'), 
														sss_no = trim('{$field[2]}'),
														pag_ibig_no = trim('{$field[3]}'),
														philhealth_no = trim('{$field[4]}') 
														where 
														company_id_no = trim('{$field[0]}')")){
															
										throw new Exception("Error : {$mysqli->error}");
									}
							 }
                            
                            
							$counter++;
							$result["ErrorMessage"] = "TIN SSS and PAG IBIG NO Data successfully loaded to database. No of record(s) ".$counter;
							
							
						}elseif($_POST['Selection'] == 4){ // update ids
							
							foreach($line as $val){
								$field[] = $mysqli->real_escape_string($val);
								// echo $val;
							}
							
							
							if($counter > 0){
								if($field[0] != ""){
									$datetime = date("Y-m-d H:i:s",strtotime($field[1]."".$field[2]));
									if(!$mysqli->query("insert into timeinout 
														(employee_id,datetime) values 
														(trim('{$field[0]}'), trim('{$datetime}'))")){
															
												throw new Exception("Error : {$mysqli->error}");
											}
											// die();
									 }
							}
							
                            
                            
							$counter++;
							$result["ErrorMessage"] = "Data successfully loaded to database. No of record(s) ".$counter;
							
							
						}elseif($_POST['Selection'] == 5){ // OT
							
							foreach($line as $val){
								$field[] = $mysqli->real_escape_string($val);
								// echo $val;
							}
							
							
							if($counter > 0){
								if($field[0] != ""){
									$datetime = date("Y-m-d",strtotime($field[1]));
									
									if(!$mysqli->query("insert into ot 
														(employee,date,ot_hours) values 
														(trim('{$field[0]}'), trim('{$datetime}'),'{$field[2]}')")){
															
												throw new Exception("Error : {$mysqli->error}");
											}
									 }
							}
							
                            
                            
							$counter++;
							$result["ErrorMessage"] = "Overtime NO Data successfully loaded to database. No of record(s) ".$counter;
							
							
						}
						
				$result["Success"] = 1;
			}
                
            }else{
				throw new Exception("Please select file to upload.");
			}
			
			
			
		}catch(Exception $e){
			
			mysqli_rollback($mysqli);
			$result["Success"] = 0;
			$result["ErrorMessage"] = $e->getMessage();
			
		}
		
		die(json_encode($result));
        
    }
    
    if($_POST['action'] == 'generatepayslip'){
       // print_r($_POST);
        /*
            [date_form] => 07/18/2018
            [date_to] => 07/18/2018
        */
        
        $date_from = date("Y-m-d",strtotime($_POST['date_from']));
        $date_to = date("Y-m-d",strtotime($_POST['date_to']));
        
        
        $mysqli->query("insert into payslips select id, '{$date_from}','{$date_to}',1,null from employee where status = 'Hired'");
        
        $result=array();
        $result['message'] = "Generation Successful.";
        die(json_encode($result));
    }
	
	// for employee module..

	if($_POST['action'] == 'Information'){
		// echo print_r($_SESSION);
		$html = "";
		$html = '<table id = "fetch_data" class="table table-striped table-bordered table-hover">';
		$q = $mysqli->query("select * from `{$_POST['Table']}` where id = {$_SESSION['employee_id']}");
		if($q->num_rows > 0){
			while($r = $q->fetch_object()){
				// echo print_r($r);
				foreach($r as $k => $v){
					$html .= "<tr>";
						$html .= "<th>".strtoupper(str_replace('_',' ',$k))."</th><td>{$v}</td>";
					$html .= "</tr>";
				}
			}
		}
		$html .= "</table>";
		$result['Details'] = $html;
		die(json_encode($result));
	}
    
    if($_POST["action"] == "emeployee_pagination"){
		$row =    25;
		$page = $_POST['page'];
		$start = ($page > 1) ? (($page-1) * $row) : 0;
		
		$userid = $_SESSION['empid'];
        $where = array();
		
		if($_POST['Table'] == 'employee'){
			$where[] = " status = 'Hired'";
			if($_POST['employee_id'] != ""){
				$where[] = " company_id_no = {$_POST['employee_id']}";
			}
			if($_POST['last_name'] != ""){
				$where[] = " last_name = '{$_POST['last_name']}'";
			}
			
			if($_POST['position'] != ""){
				$where[] = " position = '{$_POST['position']}'";
			}
			
			if($_POST['account'] != ""){
				$where[] = " account_name = '{$_POST['account']}'";
			}
			
			if($_POST['branch'] != ""){
				$where[] = " branch = '{$_POST['branch']}'";
			}
			
		}
		$wherecond = "";
		if(count($where) > 0)
		{
			$wherecond = "where ".@implode(' and ',$where)."";
		}
		
		// echo "SELECT * FROM {$_POST['Table']} {$wherecond}";
		
        $query = $mysqli->query("SELECT * FROM `{$_POST['Table']}` {$wherecond}  LIMIT $start, $row");
		$queryTotal = $mysqli->query("SELECT * FROM `{$_POST['Table']}` {$wherecond}");
		
		$total = $queryTotal->num_rows;
	
        
        
		$html = '<table id = "fetch_data" class="table table-striped table-bordered table-hover">
					<thead>';
						
       
        $q = $mysqli->query("SHOW FULL COLUMNS FROM `{$_POST['Table']}`");
        while($r = $q->fetch_object()){
            if($r->Field != 'id'){
                $html.= '<th>'.strtoupper(str_replace('_',' ',$r->Field)).'</th>';   
            }
        }
        
        
		$html .='         </tr>
					</thead>
					<tbody>';
        
        

				if($query->num_rows){
					while($res = mysqli_fetch_object($query)){
						
							
                        $in_array = array('id');
                        foreach($res as $k => $v){
                            if(!in_array($k,$in_array)){
                                $html.= '<td>'.strtoupper($v).'</td>';
                            }
                        }
                    $html .= '</tr>';
					}
				}else{
					$html .= '<tr>
						<td colspan="100" align="center">No record found</td>
					</tr>';
				}
			
			$html .= '</tbody>
		</table>';
		
		$result["Details"] = $html;
		$result["Pagination"] = AddPagination($row, $total, $page, "showPage");
		die(json_encode($result));
	}
	
	
	if($_POST['action'] == 'Employee_Add'){
        $q = $mysqli->query("SHOW FULL COLUMNS FROM `{$_POST['Table']}`");
        echo '<div class="row" id = "rowCrossCheckValidation">
				
				<div class="col-lg-12 Error-Message-Box" style="display:none;">
					<div class="alert alert-danger">
						<div class="Error-Message">Please insert field.</div>
					</div>
				</div>
				
				<div class="col-lg-12">
					<div class="panel panel-red">
						<div class="panel-heading">Parameter</div>
						
						<form role="form" name="AddEmployee">
							<div class="panel-body">';
								$in_array = array('id','status','employee_id','transaction_date');
                                while($r = $q->fetch_object()){
                                    $datepicker = '';
                                    if($r->Type == 'date'){
                                        $datepicker = "datepicker";
                                        
                                    }
                                   
                     
										
                                     if(!in_array($r->Field,$in_array)){
										 
										$check_tables_q = $mysqli->query("SHOW TABLES");
										$validated = 0;
										$tableoption = "";
										while($check_tables_r = $check_tables_q->fetch_object()){
											if($r->Field == $check_tables_r->Tables_in_pos){
												$validated = 1;
												$tableoption = $r->Field;
												break;
											}
										}
										
										if($validated == 1){
												$option_q = $mysqli->query("select * from ".$tableoption);
												$options = "<option value = 0>[SELECT : HERE]</option>";
												if($option_q->num_rows > 0){
													while($option = $option_q->fetch_object()){
														$options .= "<option value = '{$option->code}'>{$option->description}</option>";
													}
													echo '<div class="row">
													<div class="col-lg-12">
														<div class="form-group">
															<label>'.strtoupper(str_replace('_',' ',$r->Field)).'</label>
															<select class = "form-control" name = "'.$r->Field.'">'.$options.'</select>
														</div>
													</div>
													</div>';
												}
										}else{
											echo '<div class="row">
											<div class="col-lg-12">
												<div class="form-group">
													<label>'.strtoupper(str_replace('_',' ',$r->Field)).'</label>
													<input '.$datepicker.' type="text"  name="'.$r->Field.'" class="form-control '.$datepicker.'" value="" />
												</div>
											</div>
											</div>';	
										}
										
                                        
                                    }
                                }
        
                                
								echo '</div>
								
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>';
    }
	
	
	if($_POST['action']=='Employee_Save'){
        
        $field = array();
        $value = array();
        $in_array = array('Save','employee','employeerelocation','Employee_Save','travel','leave');
        $_POST['status'] = 'pending';
        $_POST['employee_id'] = $_SESSION['employee_id'];
		
        foreach($_POST as $f => $v){
            if(!in_array($v,$in_array)){

                $field[] = "`{$f}`";
                $value[] = "'{$v}'";   
            }
        }
		// echo "insert into {$_POST['Table']} (".implode(',',$field).") values (".implode(',',$value).")";
        $mysqli->query("insert into `{$_POST['Table']}` (".implode(',',$field).") values (".implode(',',$value).")");
		die("success");
    }
	
	if($_POST['action'] == 'Promote_Dealer'){
		//explode this record to get old level...
		$old_level = explode('|',$_POST['id']);
		
		//add logs..
		$mysqli->query("INSERT INTO `dealer_level_logs` (  `date`,  `dealer`,  `old_level`,  `level`) VALUES
		('{$_POST['date']}',    '{$_POST['dealer']}', '{$old_level[1]}','{$_POST['level']}');");
		
		//update to master list..
		$mysqli->query("update dealer set level = '{$_POST['level']}' where id = {$_POST['dealer']}");
		
	}
}

?>