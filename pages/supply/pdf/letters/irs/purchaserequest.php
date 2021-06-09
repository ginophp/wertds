<?php 
	// print_r($_POST);
	session_start();
	require('../../../../../class/config.php');
	require("../../../../../class/PDFGeneratorSupervisor.php");
	$pdf = new PDF('P', 'mm', 'Letter');
	$pdf->AddPage();
	$settings = $mysqli->query("select * from settings where code = 'PR'")->fetch_object();
	$mysqli->query("update settings set incremental_id  = incremental_id + 1 where code = 'PR'");
	$pdf->ln(25);
	$pdf->SetFont('', 'B', 15);
	$pdf->Cell(25, 4, "",0,0,'C');
	$pdf->Cell(125, 4, "Purchase Request",0,0,'C');
	$pdf->ln(25);
	// print_r($_POST);
	// die();
	
	$q = $mysqli->query("
						SELECT `limit` - `soh` qty,  
						IF(`limit` - `soh` = 1,'PC','PCS') Unit,
						description,IFNULL(canvas_amount,0) Unit_Cost,  (`limit` - `soh`) * IFNULL(canvas_amount,0) 
						total_unit_cost
						FROM spare_parts WHERE spare_type = '{$_POST['spare_type']}' 
						AND soh < below_min_soh");
	// $result = $mysqli->query("select * from spare_parts_stock_logs where ris_no = {$_POST['ris_no']} and purpose is not null and type = 'out' limit 1")->fetch_object();
	// $xplode_driver = explode('-',$result->motorcycle_master_list);
	// $resultx = $mysqli->query("SELECT * FROM motorcycle_master_list WHERE body_no = {$xplode_driver[0]}")->fetch_object();
	// echo "SELECT * FROM motorcycle_master_list WHERE body_no = {$xplode_driver[0]}";
	$pdf->SetFont('', 'B', 9);
	$pdf->Cell(50, 4, "OFFICE: MAIN",0);
	$pdf->Cell(50, 4, "PR Number :  ".$settings->incremental_id,0);
	$pdf->Cell(50, 4, "DATE : ".date("m/d/Y"),0);
	// $pdf->Cell(50, 4, "RIS NO: MV-{$_POST['ris_no']}",0);
	$pdf->ln(5);
	$pdf->Cell(125, 4, "",0);
	// $pdf->Cell(50, 4, "PLATE #: {$resultx->plate_no}",0);
	$pdf->ln(5);
	$pdf->Cell(125, 4, "",0);
	// $pdf->Cell(50, 4, "BODY #: {$xplode_driver[0]}",0);
	$pdf->SetFont('', '', 9);
	$pdf->ln(10);
	// if($q->num_rows > 0){
		$pdf->SetFont('', 'B', 9);
		$pdf->Cell(10, 5, "QTY",1);
		$pdf->Cell(20, 5, "UNIT",1);
		$pdf->Cell(70, 5, "DESCRIPTION",1);
		$pdf->Cell(30, 5, "UNIT COST",1);
		$pdf->Cell(40, 5, "TOTAL COST",1);
		$pdf->SetFont('', '', 9);
		$pdf->ln(5);
		$pdf->SetFont('', '', 9);
		while($r=$q->fetch_object()){
			$pdf->Cell(10, 5, $r->qty,1,0);
			$pdf->Cell(20, 5, $r->Unit,1,0);
			$pdf->Cell(70, 5, $r->description,1,0);
			$pdf->Cell(30, 5, $r->Unit_Cost,1,0);
			$pdf->Cell(40, 5, $r->total_unit_cost,1,1);
			
			// $pdf->Cell(40, 5, $last_transaction,1);
			// $pdf->ln(5);
		}
	// }
	$pdf->ln(5);
	$pdf->Cell(170, 15, "Purpose/s : ",1);
	$pdf->ln(15);
	$pdf->Cell(85, 25, "",1);
	$pdf->Cell(85, 25, "",1);
	// $pdf->Cell(100, 4, "Checked By : ",0);
	$pdf->ln(5);
	
	// $pdf->Cell(82, 4, "Received by : ".$mysqli->query('select concat(first_name," ",middle_name," ",last_name) full_name from employee where company_id_no = '.$resultx->driver)->fetch_object()->full_name,0);
	$pdf->Cell(100, 4, "Requested By:",0);
  	$pdf->ln(5);
	$pdf->Cell(18, 4, "",0);
	$pdf->Cell(82, 4, "Signature Over Printed Name",0);
	$pdf->ln(-7);
	$pdf->Cell(90, 4, "",0);
	$pdf->Cell(100, 4, "FOR IT:",0);
	$pdf->ln(15);
	$pdf->Cell(90, 4, "",0);
	$pdf->Cell(100, 4, "NATHANIEL F. BALOSCO",0);
	$pdf->Cell(110, 4, "",0);
	$pdf->Cell(100, 4, "Supply Officer",0);
	$pdf->Output();

?>