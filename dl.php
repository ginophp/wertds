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
        $pdf->Cell(140, 4,"EWB ".$res->Reference."  ".$res->DateEndoresed, 0, 1);			
        $pdf->SetFont('', '', 9);
        
        
        $pdf->ln(10);
		
		$pdf->SetFont('', 'B');
        $pdf->cell(0,5,'RE: EAST WEST BANK A/C NO. '.$CardNumber,0,1,'C');
        $pdf->SetFont('', '');
		//{$CardNumber}
		$pdf->ln(5);
		$pdf->WriteHTML("Dear Mr. / Ms. <b>{$name}</b>, <br /><br />");
		
	    $explodedecimal = explode('.',$res->ACAOB1);
	    $OBexplodedecimal = explode('.',$ACAOB1);
        
        $pdf->WriteHTML("<p align='justify'>Our client East West Bank has referred to us your past due account in the amount of PESOS: <b>".ucwords(convertNumberToWord($explodedecimal[0]))." and   ".ucwords(convertNumberToWord($OBexplodedecimal[1]))." Centavos</b> (PhP{$ACAOB1}) accumulated from your usages of the credit card facilities extended by our client    bank.</p><br /><br />");
        
	    $pdf->WriteHTML("<p align='justify'>Your failure to pay above account is a breach of the contract you signed when you applied for said credit facility.  We are therefore making this final demand for you to settle your unpaid account to avoid the embarrassment of having your name included in the negative file of undesirable borrowers- a move that will surely affect your financial credibility.</p><br /><br />");
        
	    $pdf->WriteHTML("<p align='justify'>Our client is reaching out to you for an amicable settlement and unless payment is received five (5) days from receipt hereof, we shall have no recourse but to seek the more drastic legal intervention for the settlement of subject account.  </p><br /><br />");
        
        
 	    $pdf->WriteHTML("<p align='justify'>Option 1- One time Payment                         Php {$OPT1}</p><br /><br />");
 	    $pdf->WriteHTML("<p align='justify'>Option 2- Termed 2-6 months                        Php {$OPT2}</p><br /><br />");
        
       
		$pdf->WriteHTML("<p align='justify'>For assistance or inquiries, please get in touch with Mr. / Ms. ABIGAIL COLLADO at Tel. No. (02) 982-3340 loc 322 or (02) 927-1403 or text/call us at SMART 0929-4735691; GLOBE 0997-2697680 or email us at: acsi_recov@anchor.com.ph; ralph.angelo@anchor.com.ph or for other concerns, you may call EASTWESTBANK and look for Ms. Jennifer Arnaldo (Recovery Officer) at 620-1700 loc 2857 or you may send email to JAArnaldo@eastwestbanker.com</p><br /><br />");
		
        $pdf->WriteHTML("<p align='justify'>We hope you give this matter your preferential attention.</p><br /><br />");
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
        
		$pdf->WriteHTML("<p align='justify'><i>NOTE:  Please be advised that pursuant to Republic Act (RA 9510) or the Credit Information System Act, EastWest is mandated to submit your basic credit data and its succeeding updates, to the Credit Information Corporation (CIC). The said information will be compiled to help financial institutions and credit reporting agencies authorized by the CIC in evaluating the creditworthiness of prospective and existing customers.</i><br /><br />");
        
		
	
		
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