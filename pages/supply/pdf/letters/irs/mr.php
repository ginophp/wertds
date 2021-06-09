<?php 

	session_start();
	require('../../../../../class/config.php');
	require("../../../../../class/PDFGeneratorSupervisor.php");
	$pdf = new PDF('P', 'mm', 'Letter');
	$pdf->header = 0;
	$pdf->AddPage();
	$pdf->ln(20);
	
	
	// $pdf->SetMargins(20, 0, 20);
	$pdf->SetAutoPageBreak(true, 0);
	// $pdf->Image('../../../../../img/irs.jpg', 0, 0, $pdf->w, $pdf->h);
	$pdf->Image('../../../../../img/mr.jpg', 0, 0, $pdf->w, $pdf->h);
	$pdf->ln(5);
	if(isset($_GET['action'])){
		$mysqli->query("update inventory_master_list set  employee = {$_GET['employee']} where id in (".implode(',',$_GET['transfer']).") ");
		
		$q = $mysqli->query("select *,
							(SELECT remarks FROM `mrprocessinventory` 
							 where inventory_id in (".implode(',',$_GET['transfer']).")  and employee = inv.employee order by ID desc limit 1) remarks
							  from inventory_master_list inv
							 inner join employee e on inv.employee = e.company_id_no
							 where inv.id in(".implode(',',$_GET['transfer']).")");
	}else{
			$q = $mysqli->query("select concat(b.account,' - ', b.branch) branch,a.description,
				a.date_acquired,a.body_no,a.engine_no,a.chassis_no,a.mv_file_no,a.plate_no,
				concat(b.first_name,' ',b.middle_name,' ',b.last_name) driver_name, b.position,
				a.remark
				from motorcycle_master_list a inner join employee b on b.company_id_no = a.driver where a.id = {$_GET['id']}");
	}

	$res = $q->fetch_object();
	
	$pdf->SetFont('', 'B', 9);
	$pdf->Cell(0, 15, "Memorandum Receipt for Equipment, Semi-Expendable and Non- Expendable Property ",1,1,'C');
	$pdf->SetFont('', '', 9);
	$pdf->Cell(150, 25, " ",1,0,'C');
	$pdf->Cell(46, 25, " ",1,1,'C');
	$pdf->ln(-22);
	$pdf->Cell(46, 10, " Office/Branch: ",0,1,'L');
	// $pdf->ln(-10);
	$pdf->Cell(150, 10, " AAMLO Main, Cubao ",0,1,'C');
	$pdf->ln(-30);
	$pdf->Cell(150, 25, " ",0,0,'C');
	$pdf->Cell(46, 25, " Date: ",0,1,'L');
	$pdf->ln(-14);
	$pdf->Cell(150, 25, " ",0,0,'C');
	$pdf->Cell(46, 25,date("F d, Y"),0,1,'C');
	$pdf->ln(-4);
	$pdf->Cell(0, 35, " ",'L R',1,'C');
	$pdf->ln(-45);
	$pdf->Cell(20, 35, "",0,0,'L');
	$pdf->Cell(65, 35, "I acknowledge to have received from  ",0,0,'L');
	$pdf->Cell(50, 35, "PLUTARCO A. MOLAER JR.",0,1,'L');
	$pdf->ln(-15);
	$pdf->Cell(80, 35, "",0,0,'L');
	$pdf->Cell(50, 0, "",1,1,'L');
	$pdf->Cell(82, 35, "",0,0,'L');
	$pdf->Cell(50, 5, "(Name of Accountable Officer)",0,1,'L');
	$pdf->ln(-10);
	$pdf->Cell(10, 35, "",0,0,'L');
	$pdf->Cell(82, 35, "Supply Officer/Property Custodian  , the following property / ies which will be used in",0,1,'L');
	$pdf->ln(-15);
	
	$pdf->Cell(10, 0, "",0,0,'L');
	$pdf->Cell(55, 0, "",1,1,'L');
	$pdf->Cell(25, 3, "",0,0,'L');
	$pdf->Cell(55, 3, "Designation",0,1,'L');
	$pdf->ln();
	$pdf->Cell(0, 5, "",'L B',1,'L');
	$pdf->ln(-5);
	$pdf->Cell(25, 0, "",0,0,'L');
	$pdf->Cell(19, 3, "{$res->branch}  and for which I am accountable.",'B',1,'L');
	$pdf->ln(2);
	$pdf->SetFont('', 'B', 9);
	$pdf->Cell(16, 10, "QTY",1,0,'L');
	$pdf->Cell(20, 10, "Unit",1,0,'L');
	$pdf->Cell(80, 10, "Name and Description",1,0,'L');
	$pdf->Cell(30, 10, "Date Acquired",1,0,'L');
	$pdf->Cell(30, 10, "Property No.",1,0,'L');
	$pdf->Cell(20, 10, "Unit Value",1,1,'L');
	
	
	if(isset($_GET['action'])){
		$pdf->SetFont('', '', 9);
		
		
		
		$qq = $mysqli->query("select * from inventory_master_list inv
							 inner join employee e on inv.employee = e.company_id_no
							 where inv.id in(".implode(',',$_GET['transfer']).")");
							 
		while($rr = $qq->fetch_object()){
				$qty = 'PC';
				if($rr->qty > 1){
					$qty = 'PCS';
				}
				$pdf->Cell(16, 10, $rr->qty,1,0,'L');
				$pdf->Cell(20, 10, $qty,1,0,'L');
				$pdf->Cell(80, 10, $rr->description,1,0,'L');
				$pdf->Cell(30, 10, $rr->date_purchased,1,0,'L');
				$pdf->Cell(30, 10, $rr->aamlo_property_no,1,0,'L');
				$pdf->Cell(20, 10, $rr->unit_cost,1,1,'L');
		}
		
		
		
		$pdf->Cell(0, 25, "Remarks {$res->remarks}",1,1,'L');
		$pdf->Cell(150, 25, "",1,0,'L');
		$pdf->Cell(46, 25, "",1,1,'L');
		$pdf->ln(-15);
		$pdf->Cell(46, 1, $res->first_name." ".$res->middle_name." ".$res->last_name,0,1,'L');
		$pdf->ln(3);
		$pdf->Cell(46, 1, "Name and Signature",0,1,'L');
		$pdf->ln(-5);
		$pdf->Cell(150);
		$pdf->Cell(46, 1, $res->position,0,1,'L');
		$pdf->ln(3);$pdf->Cell(150);
		$pdf->Cell(46, 1, "Position",0,1,'L');
			
	}else{
	
	$pdf->SetFont('', '', 9);
	$pdf->Cell(16, 10, "1",1,0,'L');
	$pdf->Cell(20, 10, "UNIT",1,0,'L');
	$pdf->Cell(80, 10, "{$res->description}",1,0,'L');
	$pdf->Cell(30, 10, date("m/d/Y",strtotime($res->date_acquired)),1,0,'L');
	$pdf->Cell(30, 10, "{$res->body_no}",1,0,'L');
	$pdf->Cell(20, 10, "",1,1,'L');
	
	$pdf->Cell(16, 10, "",1,0,'L');
	$pdf->Cell(20, 10, "",1,0,'L');
	$pdf->Cell(80, 10, "Engine no : {$res->engine_no}",1,0,'L');
	$pdf->Cell(30, 10, "",1,0,'L');
	$pdf->Cell(30, 10, "",1,0,'L');
	$pdf->Cell(20, 10, "",1,1,'L');
	
	$pdf->Cell(16, 10, "",1,0,'L');
	$pdf->Cell(20, 10, "",1,0,'L');
	$pdf->Cell(80, 10, "Chassis no : {$res->chassis_no}",1,0,'L');
	$pdf->Cell(30, 10, "",1,0,'L');
	$pdf->Cell(30, 10, "",1,0,'L');
	$pdf->Cell(20, 10, "",1,1,'L');
	
	$pdf->Cell(16, 10, "",1,0,'L');
	$pdf->Cell(20, 10, "",1,0,'L');
	$pdf->Cell(80, 10, "MV File No.: {$res->mv_file_no}",1,0,'L');
	$pdf->Cell(30, 10, "",1,0,'L');
	$pdf->Cell(30, 10, "",1,0,'L');
	$pdf->Cell(20, 10, "",1,1,'L');
	
	$pdf->Cell(16, 10, "",1,0,'L');
	$pdf->Cell(20, 10, "",1,0,'L');
	$pdf->Cell(80, 10, "",1,0,'L');
	$pdf->Cell(30, 10, "",1,0,'L');
	$pdf->Cell(30, 10, "",1,0,'L');
	$pdf->Cell(20, 10, "",1,1,'L');
	
	$pdf->Cell(16, 10, "",1,0,'L');
	$pdf->Cell(20, 10, "",1,0,'L');
	$pdf->Cell(80, 10, "Plate No.: {$res->plate_no}",1,0,'L');
	$pdf->Cell(30, 10, "",1,0,'L');
	$pdf->Cell(30, 10, "",1,0,'L');
	$pdf->Cell(20, 10, "",1,1,'L');
	
	$pdf->Cell(0, 25, "Remarks {$res->remark}",1,1,'L');
	$pdf->Cell(150, 25, "",1,0,'L');
	$pdf->Cell(46, 25, "",1,1,'L');
	$pdf->ln(-15);
	$pdf->Cell(46, 1, $res->driver_name,0,1,'L');
	$pdf->ln(3);
	$pdf->Cell(46, 1, "Name and Signature",0,1,'L');
	$pdf->ln(-5);
	$pdf->Cell(150);
	$pdf->Cell(46, 1, $res->position,0,1,'L');
	$pdf->ln(3);$pdf->Cell(150);
	$pdf->Cell(46, 1, "Position",0,1,'L');
	
	}
	$pdf->Output();

?>