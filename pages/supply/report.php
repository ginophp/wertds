<?php
session_start();
require('../../class/config.php');
require('../../library/pagination.php');
error_reporting(0);
$CreatedBy = $_SESSION['empid'];


	

	require("../../library/pdf/fpdf.php");
	require("../../library/pdf/mc_table.php");
	$datefrom =  date("Y-m-d",strtotime($_GET['DateFrom']));
	$dateto =	 date("Y-m-d",strtotime($_GET['DateTo']));
	
	if($_GET['action'] == 'printinventoryinlogs'){
		$q = $mysqli->query("SELECT ifnull(date_in_or_out,'N/A') `Date`, office_supply Supply_Code,qty Qty, Price, Remarks, transaction_date Date_Encoded 
							FROM `office_supply_stock_logs` WHERE `type`  = 'in' and office_supply = '{$_POST['office_supply']}'");
	}elseif($_GET['action'] == 'runningsoh'){
		// echo "SELECT code,brand,description,soh FROM `office_supply`";
		// die();
		$q = $mysqli->query("SELECT code,brand,description,soh FROM `office_supply` order by soh desc");
	}else{
				
		$q = $mysqli->query("SELECT c.`description`, b.`description`,a.`qty`,a.`remarks`,a.`transaction_date`
							FROM `office_supply_stock_logs` a
							INNER JOIN office_supply b ON b.code=a.`office_supply`
							INNER JOIN account c ON a.`account` = c.`code` 
							where date(a.`transaction_date`) between '{$_POST['DateFrom']}' and  '{$_POST['DateTo']}' and a.Account = '{$_POST['Account']}'");
	
	
	}

	$pdf = new PDF_MC_Table('L', 'mm', array(200,480));
	// $monthName = date("F", mktime(null, null, null, $_POST['Month']));
	
	
		
	if($_GET['type']=='pdf'){
		
	}else{
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		date_default_timezone_set('Asia/Manila');

		if (PHP_SAPI == 'cli')
			die('This example should only be run from a Web Browser');

		/** Include PHPExcel */
		require_once '../../library/excel/Classes/PHPExcel.php';


		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									 ->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Test result file");
									 
		$row = 1;
		$line = 0;
		
		if($q->num_rows > 0){
			$line_count=0;
			$header_s = array();
			
			while($r = $q->fetch_object()){
				$details_s = array();
				// $row = 1;
				$line = 0;
				if($line_count == 0){
						
						foreach($r as $s=>$t){
							$header_s[] = $s;
						}
						
						foreach($header_s as $k=>$v){
							
							
							$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($line,$row,$v);
							$line++;
						}
						$row++;
				}
				
				foreach($r as $y=>$z){
					$details_s[] = $z;
				}
				$line = 0;
				foreach($details_s as $k=>$v){
					
						// echo $line ."=>". $v."<br />";
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($line,$row,$v);
						$line++;
				}
				$row++;
				$line = 0;
				// $details_s
				$line_count++;
			}
		}else{
				// $pdf->SetWidths(array(385));
				// $pdf->Row(array("No Record Found(.s)"));
		}
		
		
		
		
		
		
		// $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'Barcode No.');
		
		  // Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		if(!isset($_POST['Account'])){
			if(!isset($_POST['office_supply'])){
				$_POST['Account'] = 'running_soh';
			}else{
				$_POST['Account'] = $_POST['office_supply'];
			}
		}
		header('Content-Disposition: attachment;filename="'.$_POST['Account'].'_'.date("mdY").'.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}
	


?>