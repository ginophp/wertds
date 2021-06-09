<?php 

	session_start();
	require('../../../../../class/config.php');
	require("../../../../../class/PDFGeneratorSupervisor.php");
	require("../../../../../class/notowords.php");
	
	$userid = $_SESSION["empid"];
	$dlid = explode(",", $_GET["dlid"]);
	$dltypequery = $mysqli->query("SELECT ID FROM dltype WHERE Code = '".$_GET['DLType']."'");
	$dltype = mysqli_fetch_object($dltypequery);
	
	$userquery = $mysqli->query("SELECT * FROM user WHERE ID = {$userid}");
	$user = mysqli_fetch_object($userquery);
	
	$pdf = new PDF('P', 'mm', 'Letter');
	
    $xCounter = 1;
    $Counter = 1;
	foreach($dlid as $id){
		$query = $mysqli->query("SELECT * FROM demandletter_anchor WHERE ID = $id AND CreatedBy = $userid");
		$res = mysqli_fetch_object($query);
		// echo "<pre>";
		// print_r($res);
		// echo "</pre>";
		// die();
		
		$collectorquery = $mysqli->query("SELECT * FROM collectors WHERE Code = '{$res->Collector}'");
		$userName = "";
		$collectorNumber = "";
		$collectorEmailAddress = "";
		
		if($collectorquery->num_rows){
			$collector = mysqli_fetch_object($collectorquery);
			$userName = str_replace(" ", "   ", $collector->Title." ".$collector->Name);
			$collectorNumber = $collector->Number;
			$collectorEmailAddress = $collector->EmailAddress;
		}
		
		$OB = number_format((float)$res->OB, 2, '.', ',');
		$DateEndoresed =  date("F d, Y",strtotime($res->DateEndoresed));
		$CardNumber = $res->AccountNo;
		$ACAOB1 = number_format($res->ACAOB1,2);
		$OPT1 = number_format($res->OPT1,2);
		$OPT2 = number_format($res->OPT2,2);

		$pdf->header = 1;
		$pdf->AddPage();
		$pdf->Barcode($id, $dltype->ID);
		if($Counter == 1){ 
            $pdf->Ln(55);
            $Counter++;
        }else{
            $pdf->Ln(75);
        }
		// $pdf->Cell(100, 4);
		$pdf->Cell(0, 4, date("F d, Y"));
		$pdf->Ln(8);
		//romeo piocos
		$addressx = array();
		
		$addresses = array($res->Address1);
		$addressx = array();
		// $name = ($res->Middlename == "") ? "{$res->Firstname} {$res->Middlename} {$res->Lastname}" : "{$res->Firstname} {$res->Lastname}";
		$name = $res->FullName;
		
		//$pdf->Cell(140, 4, $res->Counter);
        $pdf->Cell(140, 4, $xCounter." | ".$id,0,1);
		$pdf->WriteHTML("<b>".$res->Title." ".$name."</b><br />");
		foreach($addresses as $address){
			//if(!empty($address)){
				$addressx[] = $address;
			//}
		}
		
		$count = 1;
		// foreach($addressx as $addr){
			// $add = ($count != count($addressx)) ? $addr : $addr;
			// $lengaddress = strlen($res->Address1);
			
			$pdf->Cell(140, 4, substr($res->Address1,0,35), 0, 1);
			$pdf->Cell(140, 4, substr($res->Address1,35,70), 0, 1);
			// $count++;
		// }
		$pdf->SetFont('', '', 5);
        $pdf->Cell(140, 4,"RAL ".$res->DateEndoresed," {$userName}", 0, 1);			
        $pdf->SetFont('', '', 9);
        
        
        $pdf->ln(10);
		
		$pdf->SetFont('', 'B');
        $pdf->cell(0,5,"RE: RCBC-AUTO LOAN",0,1,'C');
        $pdf->cell(0,5,"ACCOUNT NO. {$CardNumber}",0,1,'C');
        $pdf->cell(0,5,"UNIT TYPE: {$res->Collateral}",0,1,'C');
        $pdf->cell(0,5,"MOTOR #: {$res->MotorNo}",0,1,'C');
        $pdf->cell(0,5,"Serial No. {$res->SerialNo}",0,1,'C');
        
        $pdf->SetFont('', '');
		//{$CardNumber}
		$pdf->ln(5);
		$pdf->WriteHTML("Dear Sir/Ma’am:<br /><br />");
		
        $pdf->WriteHTML("<p align='justify'>Our client RCBC Savings Bank has referred to us for collection subject account.  To spare you of the inconvenience and cost of a legal suit, Anchor Collection Services, Inc., as the Authorized Collection Agent of RCBC Savings Bank, is giving you this final opportunity to settle your obligation within five (5) days upon receipt hereof, under the following options:</p><br /><br />");
        $pdf->WriteHTML("<p align='justify'>Option 1 - Pay in full your outstanding balance (you may keep the vehicle)</p><br /><br />");
        $pdf->WriteHTML("<p align='justify'>Option 2 - Voluntarily surrender the motor vehicle mortgaged as security</p><br /><br />");
        $pdf->WriteHTML("<p align='justify'>Failure on your part to exercise any of the above options will leave us no choice but to take the necessary legal steps to protect the interest of our client.</p><br /><br />");
        $pdf->WriteHTML("<p align='justify'>For your concern and inquiries, you may call my Legal Assistant  {$userName} at {$collectorNumber}. You may also email us at: anchor.autoloan@yahoo.com </p><br /><br />");
        //$pdf->WriteHTML("<p align='justify'></p><br /><br />");
        //$pdf->WriteHTML("<p align='justify'></p><br /><br />");
        
	    //$pdf->WriteHTML("<p align='justify'></p><br /><br />");
		// $pdf->WriteHTML("<p align='justify'></p><br /><br />");
		
		//$pdf->Cell(100, 4);
		$pdf->Cell(0, 4, "Very truly yours,",0,1);    
		$pdf->SetFont('', 'B');
		$pdf->Ln(4);
		//$pdf->Cell(90, 4);
		//$pdf->Signature($userid);
		if(!isset($_GET['signature'])){
            $pdf->Signature($userid);
        }
        $pdf->Ln(10);
		//$pdf->Cell(100, 4);
		$pdf->SetFont('', 'B');
		$pdf->Cell(0, 4, "ATTY. RAYMUNDO R. AQUINO", 0, 1);
		$pdf->SetFont('', '');
		//$pdf->Cell(100, 4);
		$pdf->Cell(0, 4, "Roll No. 48382", 0, 1);
		$pdf->Ln(4);
		
		$pdf->SetFont('', '', 7);
		
		$pdf->WriteHTML("<p align='justify'><i>All check / cash payment should be made payable to Eastwest bank for the account of {$name}  {$CardNumber}. </i><br /><br />");
        
		$pdf->WriteHTML("<p align='justify'><i>IMPORTANT: All Check /cash payment should be made payable to RCBC Savings Bank for the account {$CardNumber} {$name}</i><br /><br />");
        
		
	
		
        $pdf->cell(0,0,'',1,1);
        $pdf->ln(2);
        $pdf->cell(0,0,'Head Office:  ACSI Bldg., No. 2 Malakas Street,  Bgy. Pinyahan 1100 , Quezon City',0,0,'C');
        $pdf->ln(3);
        $pdf->cell(0,0,'Tel. No.(632) 920-8483; TeleFax:  (632) 927-9907;  Email: Admin@anchor.com.ph',0,0,'C');
        $pdf->ln(3);
        $pdf->cell(0,0,'Branches:  Cebu City; Davao City;Bulacan; Daet; Bacolod City; Cagayan de Oro City',0,0,'C');
        $pdf->ln(3);
        $pdf->cell(0,0,'Member:  Philippine Association of Collection Agencies (PACAI), Inc.',0,0,'C');
        
        
        
		$pdf->SetFont('', '', 9);
        
        $xCounter++;
	}
	
	$pdf->RegistryAnchor($dlid);
	
	$pdf->Output();
	

?>