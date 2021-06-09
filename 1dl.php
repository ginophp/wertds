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
		$DateReleased =  date("F d, Y",strtotime($res->DateReleased));
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
			
		$ExplodeAddress = explode(" ",trim($res->Address1));
        $parameterreader = 0;
        $xxxx =  round((count($ExplodeAddress)/2));
        //echo $xxxx;
        $printaddress="";
        foreach($ExplodeAddress as $k => $v){
         //echo $v." ";
            if($parameterreader == $xxxx){
                $pdf->Cell(140, 4, $printaddress, 0, 1);

                $parameterreader = 0;
                $printaddress = "";
                 if($v != ""){
                    $printaddress .= "{$v} ";
                    $parameterreader++;
                }

            }else{
                if($v != ""){
                    $printaddress .= "{$v} ";
                    $parameterreader++;
                }
            }
        }
        $pdf->Cell(140, 4, $printaddress, 0, 1);
			// $count++;
		// }
		$pdf->SetFont('', '', 5);
        $pdf->Cell(140, 4,"NORKIS ".$res->Reference."  ".$res->DateEndoresed, 0, 1);			
        $pdf->SetFont('', '', 9);
        
        
        $pdf->ln(10);
		
		$pdf->SetFont('', 'B');
        $pdf->cell(0,5,"RE: MOTORCYCLE LOAN",0,1,'C');
        $pdf->cell(0,5,'ACCOUNT NO. '.$CardNumber,0,1,'C');
        $pdf->SetFont('', '');
		//{$CardNumber}
		$pdf->ln(5);
		$pdf->WriteHTML("Dear Mr. / Ms. <b>{$name}</b>, <br /><br />");
		
	    $explodedecimal = explode('.',$res->ACAOB1);
	    $OBexplodedecimal = explode('.',$ACAOB1);
        
        $pdf->WriteHTML("<p align='justify'>In connection with the motorcycle loan you have with <b>NORKIS   FINANCIAL   CORP.</b> to purchase {$res->Brand} dated {$DateReleased} it appears that you have an outstanding balance in the amount of PhP. {$ACAOB1} .Hence, <b>ANCHOR   COLLECTION   SERVICES,   INC.</b> as the duly Authorized Collection Agent of the above-mentioned bank, demands the immediate settlement of your obligation.  </p><br /><br />");
        
	    $pdf->WriteHTML("<p align='justify'>Failure on your part to settle above obligation <b>within   five   (_5_) days</b> from receipt of this letter shall constrain us, much to our regret, to do all the necessary legal action to protect the interest of our client, including the filing of civil and criminal cases against you before the proper forum.  By way of reminder, in the event that we resort to court action to enforce our client’s rights, you shall likewise be liable, apart from the foregoing outstanding amount, for attorney’s fees, damages and cost of suit.</p><br /><br />");
        
        
        
       
		$pdf->WriteHTML("<p align='justify'>We welcome your inquiries and/or verifications at the following: Tel. Nos. (02)926-17-56. Please look for Mr./Ms. {$userName} or text/call us at: Smart: 0999-8849-021; Globe: 0975-3721-567  You may also e-mail us at anchor.norkis123@gmail.com
        </p><br /><br />");
		
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
		
		$pdf->WriteHTML("<p align='justify'><i>Please disregard this letter if payment has already been made, or any other kind of settlement with the bank has been reached, or if you are not the party concerned. In any case, please advise us accordingly.</i><br /><br />");
        
		
		$pdf->WriteHTML("<p align='justify'><i>IMPORTANT: Our field collectors are authorized to accept check payments only payable to Norkis Financial Corp, the account of  {$name}  {$CardNumber}. </i><br /><br />");
        
		$pdf->SetFont('', '', 9);
        
        $xCounter++;
	}
	
	$pdf->RegistryAnchor($dlid);
	
	$pdf->Output();
	

?>