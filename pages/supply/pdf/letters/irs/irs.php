<?php 

	session_start();
	require('../../../../../class/config.php');
	require("../../../../../class/PDFGeneratorSupervisor.php");
	$pdf = new PDF('P', 'mm', 'Letter');
	$pdf->AddPage();
	$pdf->ln(50);
	// print_r($_POST);
	// die();
	
	$q = $mysqli->query("select * from spare_parts_stock_logs where ris_no = {$_POST['ris_no']} and type = 'out'");
	$result = $mysqli->query("select * from spare_parts_stock_logs where ris_no = {$_POST['ris_no']} and purpose is not null and type = 'out' limit 1")->fetch_object();
	$xplode_driver = explode('-',$result->motorcycle_master_list);
	$resultx = $mysqli->query("SELECT * FROM motorcycle_master_list WHERE body_no = {$xplode_driver[0]}")->fetch_object();
	// echo "SELECT * FROM motorcycle_master_list WHERE body_no = {$xplode_driver[0]}";
	$pdf->SetFont('', 'B', 9);
	$pdf->Cell(125, 4, "OFFICE: MAIN",0);
	$pdf->Cell(50, 4, "RIS NO: MV-{$_POST['ris_no']}",0);
	$pdf->ln(5);
	$pdf->Cell(125, 4, "",0);
	$pdf->Cell(50, 4, "PLATE #: {$resultx->plate_no}",0);
	$pdf->ln(5);
	$pdf->Cell(125, 4, "",0);
	$pdf->Cell(50, 4, "BODY #: {$xplode_driver[0]}",0);
	$pdf->SetFont('', '', 9);
	$pdf->ln(10);
	if($q->num_rows > 0){
		$pdf->SetFont('', 'B', 9);
		$pdf->Cell(10, 5, "QTY",1);
		$pdf->Cell(20, 5, "UNIT",1);
		$pdf->Cell(70, 5, "DESCRIPTION",1);
		$pdf->Cell(30, 5, "UNIT PRICE",1);
		$pdf->Cell(40, 5, "REMARKS",1);
		$pdf->SetFont('', '', 9);
		$pdf->ln(5);
		while($r=$q->fetch_object()){
			// $pdf->Cell(50, 4, "RIS NO: MV-{$_POST['ris_no']}",0);
			$pdf->Cell(10, 5, $r->qty,1);
			$type = "PC";
			if($r->qty > 1){
				$type = "PCS";
			}
			
			$qq = $mysqli->query("select * from spare_parts_stock_logs 
								  where 
								  motorcycle_master_list = '{$result->motorcycle_master_list}' 
								  and spare_parts = '{$r->spare_parts}' 
								  and ris_no != {$_POST['ris_no']}
								  limit 1");
			
			$last_transaction = "0";
			if($qq->num_rows > 0){
				$last_transaction = $qq->fetch_object()->transaction_date;
			}
			$pdf->Cell(20, 5, $type,1);
			// $mysqli->query("")
			$pdf->Cell(70, 5, ($mysqli->query("select description from spare_parts where code = '{$r->spare_parts}'")->fetch_object()->description),1);
			$pdf->Cell(30, 5, "",1);
			$pdf->Cell(40, 5, $last_transaction,1);
			$pdf->ln(5);
		}
	}
	$pdf->ln(5);
	$pdf->Cell(125, 4, "Purpose/s : {$result->purpose}",0);
	$pdf->ln(10);
	$pdf->Cell(82, 4, "",0);
	$pdf->Cell(100, 4, "Checked By : ",0);
	$pdf->ln(5);
	$pdf->Cell(100, 4, "",0);
	$pdf->Cell(100, 4, "GEMMA G. LLEMA/ KEVIN MARK SORA",0);
	$pdf->ln(3);
	$pdf->Cell(115, 4, "",0);
	$pdf->Cell(100, 4, "Supply Officer Aide",0);
	$pdf->ln(10);
	$pdf->Cell(82, 4, "Received by : ".$mysqli->query('select concat(first_name," ",middle_name," ",last_name) full_name from employee where company_id_no = '.$resultx->driver)->fetch_object()->full_name,0);
	$pdf->Cell(100, 4, "Approved:",0);
  	$pdf->ln(5);
	$pdf->Cell(18, 4, "",0);
	$pdf->Cell(82, 4, "Signature Over Printed Name",0);
	$pdf->ln(5);
	$pdf->Cell(100, 4, "",0);
	$pdf->Cell(100, 4, "PLUTARCO A. MOLAER JR.",0);
	$pdf->ln(3);
	$pdf->Cell(110, 4, "",0);
	$pdf->Cell(100, 4, "Supply Officer",0);
	$pdf->Output();

?>