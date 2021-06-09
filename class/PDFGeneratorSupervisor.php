<?php 

require("../../../../../library/pdf/fpdf.php");
require("../../../../../library/pdf/mc_table.php");
class PDF extends PDF_MC_Table{
	
	var $B=0;
    var $I=0;
    var $U=0;
    var $HREF='';
    var $ALIGN='';
	var $header = 1;
        
   
    
    function WriteHTML($html)
    {
        //HTML parser
        $html=str_replace("\n",' ',$html);
        $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
        foreach($a as $i=>$e)
        {
            if($i%2==0)
            {
                //Text
                if($this->HREF)
                    $this->PutLink($this->HREF,$e);
                elseif($this->ALIGN=='justify'){
					$this->Write(4,$e,'FJ');
				}elseif($this->ALIGN=='center')
                    $this->Cell(140,4,$e,0,0,'C');
                else
                    $this->Write(4,$e,'L');
            }
            else
            {
                //Tag
                if($e[0]=='/')
                    $this->CloseTag(strtoupper(substr($e,1)));
                else
                {
                    //Extract properties
                    $a2=explode(' ',$e);
                    $tag=strtoupper(array_shift($a2));
                    $prop=array();
                    foreach($a2 as $v)
                    {
                        if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                            $prop[strtoupper($a3[1])]=$a3[2];
                    }
                    $this->OpenTag($tag,$prop);
                }
            }
        }
    }

    function OpenTag($tag,$prop)
    {
        //Opening tag
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,true);
        if($tag=='A')
            $this->HREF=$prop['HREF'];
        if($tag=='BR')
            $this->Ln(4);
        if($tag=='P')
            $this->ALIGN=$prop['ALIGN'];
        if($tag=='HR')
        {
            if( !empty($prop['WIDTH']) )
                $Width = $prop['WIDTH'];
            else
                $Width = $this->w - $this->lMargin-$this->rMargin;
            $this->Ln(2);
            $x = $this->GetX();
            $y = $this->GetY();
            $this->SetLineWidth(0.4);
            $this->Line($x,$y,$x+$Width,$y);
            $this->SetLineWidth(0.2);
            $this->Ln(2);
        }
    }

    function CloseTag($tag)
    {
        //Closing tag
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,false);
        if($tag=='A')
            $this->HREF='';
        if($tag=='P')
            $this->ALIGN='';
    }

    function SetStyle($tag,$enable)
    {
        //Modify style and select corresponding font
        $this->$tag+=($enable ? 1 : -1);
        $style='';
        foreach(array('B','I','U') as $s)
            if($this->$s>0)
                $style.=$s;
        $this->SetFont('',$style);
    }

    function PutLink($URL,$txt)
    {
        //Put a hyperlink
        $this->SetTextColor(0,0,255);
        $this->SetStyle('U',true);
        $this->Write(4,$txt,$URL);
        $this->SetStyle('U',false);
        $this->SetTextColor(0);
    }
	
	function Header(){
		
		$this->SetFont('Arial','',9);     
		
		if($this->header == 1){
			$this->SetMargins(20, 0, 20);
			$this->SetAutoPageBreak(true, 0);
			// $this->Image('../../../../../img/irs.jpg', 0, 0, $this->w, $this->h);
			$this->Image('../../../../../img/letterbackground.jpg', 0, 0, $this->w, $this->h);
		}
		
	}
	
	function Barcode($dlid, $dltypeid = ""){
		
		$url = "http://".$_SERVER['SERVER_NAME'].str_replace("pages/supervisor/pdf/letters", "", dirname(dirname($_SERVER['REQUEST_URI'])));
		$this->Image("{$url}library/img.php?dlid={$dlid}&dltypeid=$dltypeid", 160, 0, 0, 0, 'PNG');
		
	}
	
	function Signature($userid, $width=60, $height=15){
		
		$url = "http://".$_SERVER['SERVER_NAME'].dirname(dirname($_SERVER['REQUEST_URI']));
		$this->Cell(0, 4, $this->Image("{$url}/signatures/signature{$userid}.png", $this->GetX(), $this->GetY(), $width, $height));
	
	}
	
	function Registry($dlid){
		
		global $mysqli;
        
		$userid = $_SESSION['empid'];
		$userquery = $mysqli->query("SELECT * FROM user WHERE ID = {$userid}");
		$user = mysqli_fetch_object($userquery);
		
		$this->SetFont("", "", 8);
		
		$this->header = 0;
		$counter = 1;
		$this->SetMargins(10, 0, 5);
		$this->AddPage();
		$this->ln(6);
		$this->Cell(0, 4, '------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
		$this->ln(6);
		
		$height = 22;
		$xCounter = 1;
		foreach($dlid as $id){
			
			$this->ln(9);
			$this->Cell(105, 4);
			$this->Cell(95, 67, "", 1, 1);
			
			$this->ln(-60);
			
			$url = "http://".$_SERVER['SERVER_NAME'].str_replace("pages/supervisor/pdf/letters", "", dirname(dirname($_SERVER['REQUEST_URI'])));
			$this->Image("{$url}library/img.php?dlid={$id}", 160, $height, 0, 0, 'PNG');
			
			$height = $height + 86;
			
			$this->Cell(108, 4);
			$this->Cell(0, 5, "Date of field : ____________________________ Time : ___________", 0, 1);
			$this->Cell(108, 4);
			$this->Cell(0, 5, "Landmark : ______________________________________________", 0, 1);
			$this->Cell(108, 4);
			$this->Cell(0, 5, "Remarks : _______________________________________________", 0, 1);
			$this->Cell(108, 4);
			$this->Cell(0, 5, "________________________________________________________", 0, 1);
			$this->Cell(108, 4);
			$this->Cell(0, 5, "________________________________________________________", 0, 1);
			$this->Cell(108, 4);
			$this->Cell(0, 5, "________________________________________________________", 0, 1);
			$this->ln(4);
			$this->Cell(108, 4);
			$this->Cell(0, 6, "_______________________________,  _______________________", 0, 1);
			$this->Cell(108, 4);
			$this->Cell(0, 4, "       Recipient/Print name and sign                         Relation to CH", 0, 1);
			$this->ln(4);
			$this->Cell(108, 4);
			$this->Cell(0,6, "_______________________________,  _______________________", 0, 1);
			$this->Cell(108, 4);
			$this->Cell(0, 4, "                NEW Contact No.                         	                 Owner", 0, 1);
			
			$this->ln(-73);
			$query = $mysqli->query("SELECT * FROM demandletter WHERE ID = {$id} AND CreatedBy = {$userid}");
			$res = mysqli_fetch_object($query);
		
            //do process here
            $qcollectors = $mysqli->query("select * from collectors where Code = '{$res->Collector}'");
            $rescol = mysqli_fetch_object($qcollectors);
            
            
			$userName = explode(" ", $res->Name);
			
			$this->SetFont("", "B");
			$this->Cell(0, 3, "{$user->AccountType} - {$user->Name}", 0, 1, "C");
			
            if($qcollectors->num_rows>0){
             
             $this->Cell(0, 3, "{$rescol->Number}", 0, 1, "C");
			
			 $this->Cell(50, 3, "Name of Sender : AAM", 0, 1);
			 $this->Cell(10, 3);
			 $this->Cell(40, 3, "{$rescol->Address}");
			   
            }
			$this->ln(7);
			
			// $name = ($res->Middlename == "") ? "{$res->Firstname} ".substr($res->Middlename, 1, 0)." {$res->Lastname}" : "{$res->Firstname} {$res->Lastname}";
			$name = "{$res->Title} {$res->Firstname} {$res->Middlename} {$res->Lastname}";
			$this->Cell(50, 3, "Addressed to : {$name}", 0, 1);
			$this->Cell(10, 3);
			$this->Cell(40, 3, "{$res->Primaryadd1}, {$res->Primaryadd2}", 0, 1);
			$this->Cell(10, 3);
			$this->Cell(40, 3, "{$res->Primaryadd3}, {$res->Primaryadd4}", 0, 1);
			$this->Cell(10, 3);
			$this->Cell(40, 3, "{$res->Primaryadd5}");
			
			$this->ln(5);
			
			$this->Cell(50, 3, "EMPLOYER'S NAME : {$res->Employee}", 0, 1);
			
			$this->ln(5);
			
			$this->Cell(50, 3, "EXISTING CONTACT NOS.", 0, 1);
			
			$this->SetFont("", "");
			$this->Cell(50, 3, "HOME NO. {$res->Homephone}", 0, 1);
			$this->Cell(50, 3, "OFFICE NO. {$res->Officephone}", 0, 1);
			$this->Cell(50, 3, "MOBILE NO. {$res->Mobilephone}", 0, 1);
			
			$this->ln(5);
			
			$this->SetFont("", "B");
			$collectorquery = $mysqli->query("SELECT * FROM collectors WHERE Code = '{$res->Collector}'");		
			$collectorName = "";
			$collectorNumber = "";
			$collectorEmailAddress = "";
			
			if($collectorquery->num_rows){
				$collector = mysqli_fetch_object($collectorquery);
				$collectorName = $collector->Title." ".$collector->Name;
				$collectorNumber = $collector->Number;
				$collectorEmailAddress = $collector->EmailAddress;
			}
			
			$dltypequery = $mysqli->query("SELECT Description DLType FROM dltype WHERE Code = '{$_GET['DLType']}' AND AccountType = '{$user->AccountType}'");
			$dltype = mysqli_fetch_object($dltypequery);
			
			// $DateofDL = ($res->DateofDL != "") ? date("m/d/Y", strtotime($res->DateofDL)) : "NA";
			$DateofDL = date("m/d/Y");
			
			$explode = explode(' ',$dltype->DLType);
			$this->Cell(50, 3, "{$collectorName}", 0, 1);
			$this->Cell(50, 3, "Count : {$xCounter} / Type of DL : {$explode[0]} / DL Date : {$DateofDL}", 0, 1);
			
			$CardNumber = ($res->CardNumberMask == "") ? $res->AccountNo : $res->CardNumberMask;
			$BlockDate = ($res->BlockDate != "") ? date("m/d/Y", strtotime($res->BlockDate)) : "NA";
			$EndoDate = ($res->EndoDate != "") ? date("m/d/Y", strtotime($res->EndoDate)) : "NA";
			$PuloutDate = ($res->PuloutDate != "") ? date("m/d/Y", strtotime($res->PuloutDate)) : "NA";
			
			$this->Cell(50, 3, "{$CardNumber} / Level : {$res->Level} / Blk Date : {$BlockDate}", 0, 1); 
			$this->Cell(50, 3, "Endo No. {$res->EndoNo} / DOE : {$EndoDate}", 0, 1);
			$this->Cell(50, 3, "POD : {$PuloutDate}", 0, 1);
			$this->Cell(50, 3, "ALT ADD : {$res->Altadd1}, {$res->Altadd2}", 0, 1);
			$this->Cell(10, 3);
			$this->Cell(40, 3, "{$res->Altadd3}, {$res->Altadd4}");
			$this->Cell(10, 3);
			$this->Cell(40, 3, "{$res->Altadd5}");
			
			$this->ln(6);
			
			$this->Cell(0, 4, '------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
			$this->ln(6);
			
			if(count($dlid) != $counter){
				if(($counter % 3) == 0){
					$height = 22;
					$this->AddPage();
					$this->ln(6);
					$this->Cell(0, 4, '------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');
					$this->ln(6);
				}
			}
			$counter++;
			$xCounter++;
			
			$mysqli->query("update demandletter set DLType = '{$explode[0]}' where ID = {$id}");
		}
		
		
		
	}
    
    
    function RegistryAnchor($dlid){
        global $mysqli;
        //print_r($_GET);
		$userid = $_SESSION['empid'];
		$userquery = $mysqli->query("SELECT * FROM user WHERE ID = {$userid}");
		$user = mysqli_fetch_object($userquery);
		
		$this->SetFont("", "", 6);
		
		$this->header = 0;
		$counter = 1;
		$this->SetMargins(10, 0, 5);
		$this->AddPage();
		$this->ln(2);

		$height = 9;
		$xCounter = 1;
        
        foreach($dlid as $id){
			
			$this->ln(6);
			//$this->Cell(105, 4);
			$this->Cell(135, 25, "", 1, 0);
			$this->Cell(55, 25, "", 1, 0);
			
			$this->ln(8);
			
			$url = "http://".$_SERVER['SERVER_NAME'].str_replace("pages/supervisor/pdf/letters", "", dirname(dirname($_SERVER['REQUEST_URI'])));
			$this->Image("{$url}library/img.php?dlid={$id}", 160, $height, 0, 0, 'PNG');
			
            //$this->Cell(108, 4);
			$this->Cell(135, 5, "ACCOUNT INFORMATION", 0, 0);
			$this->Cell(0, 5, "ACCOUNT #", 0, 1);
			$this->Cell(135, 5, "ACCOUNT NAME", 0, 0);
            $this->Cell(0, 5, "BANK", 0, 1);
			$this->Cell(0, 5, "BUSINESS ADDRESS", 0, 1);
            $this->ln(2);
            $this->Cell(190, 30, "", 1, 1);
            $this->ln(-30);
            $this->Cell(20, 5, "PPP", 0, 0);
            $this->Cell(20, 5, "LM", 0, 0);
            $this->Cell(20, 5, "DRP", 0, 1);
            $this->Cell(20, 5, "PTP", 0, 0);
            $this->Cell(20, 5, "NLC", 0, 0);
            $this->Cell(20, 5, "UNL", 0, 1);
            $this->Cell(20, 5, "MO", 0, 0);
            $this->Cell(20, 5, "NCON", 0, 1);
            $this->Cell(20, 5, "DEAD", 0, 1);
            
            $this->ln(-20);
            $this->Cell(60, 5, "", 0, 0);
            $this->Cell(40, 5, "UNK", 0, 0);
            $this->Cell(60, 5, "DATE VISITED : _____________", 0, 1);
            
            $this->Cell(60, 5, "", 0, 0);
            $this->Cell(40, 5, "COMPANY CLOSED", 0, 1);
            
            $this->Cell(60, 5, "", 0, 0);
            $this->Cell(40, 5, "COMPANY REFUSED TO ACCEPT", 0, 1);
            
            $this->Cell(60, 5, "", 0, 0);
            $this->Cell(40, 5, "RECEIVED BY: ", 0, 1);
            
            $this->Cell(60, 5, "", 0, 0);
            $this->Cell(40, 5, "_________________", 0, 1);
            $this->ln(5);
            $this->Cell(190, 30, "", 1, 1);
            $this->ln(-35);
            $this->Cell(0, 5, "", 0, 1);
            $this->Cell(60, 5, "NEW CONTACT NUMBER", 0, 0);
            $this->Cell(60, 5, "OTHER", 0, 0);
            $this->Cell(60, 5, "NAME", 0, 1);
            $this->Cell(60, 5, "CONTACT NAME", 0, 0);
            $this->Cell(60, 5, "__________________", 0, 0);
            $this->Cell(60, 5, "__________________", 0, 1);
            $this->Cell(60, 5, "NEW ADDRESSS", 0, 1);
            $this->Cell(60, 10, "REMARKS", 0, 1);
            $this->Cell(60, 5, "RECEIVED BY:", 0, 0);
            $this->Cell(107, 5, "VERIFIED BY:", 0, 0);
            $this->Cell(60, 5, "FIELD COLLECTOR", 0, 0);
			$height = $height + 86;
            
            if(count($dlid) != $counter){
				if(($counter % 3) == 0){
					$height = 9;
					$this->AddPage();
					$this->ln(2);
					//$this->Cell(0, 0, '',1);
					//$this->ln(6);
				}
			}
			$counter++;
        }
        
        
        $this->driverschedule();
        
        
    }
    
    function driverschedule()
    {
        global $mysqli;
        
        //require("../library/pdf/mc_table.php");
       
        //$thi\ = new PDF_MC_Table('P', 'mm', 'Letter');
        //$mc->AddPage();
        
      
        //$mc = new PDF_MC_Table('P', 'mm', 'Letter');
        //$this->AddPage();
        $CreatedBy = $_SESSION['empid'];
        $DRCode = $_GET['Driver'];
        $DateFrom = date("Y-m-d", strtotime($_GET['DateFrom']));
        $DateTo = date("Y-m-d", strtotime($_GET['DateTo']));
        
          try{
			mysqli_autocommit($mysqli, FALSE);
			
			
            
            foreach($_POST['DemandLetterID'] as $k => $v){
                  $DLID =  $v;
                  $checker = $mysqli->query("select * from driverschedule where Status = ''");
                  if($checker->num_rows == 0){
                       $st = $mysqli->prepare("INSERT INTO driverschedule(DRCode, DLID, DateFrom, DateTo, CreatedBy) VALUES(?, ?, ?, ?, ?)");
                      $st->bind_param("ssssi", $DRCode, $DLID, $DateFrom, $DateTo, $CreatedBy);
                      $st->execute();
                      $mysqli->query("UPDATE demandletter SET HeldBy = 'operation' WHERE ID = $DLID");
                  }
                 
            }
			mysqli_commit($mysqli);
			$result['Success'] = 1;
			$result['ErrorMessage'] = "Schedule has been assigned to driver.";
			
		}catch(Exception $e){
			mysqli_rollback($mysqli);
			$result['Success'] = 0;
			$result['ErrorMessage'] = $e->getMessage();
		}
        
       
        
        
        
        // now generate report schedule
        
        $this->AddPage();
	   
        $this->SetFont('Arial','B',12);
        $this->Cell(0,5,'Schedule Report', 0, 1, 'C');
        $this->SetFont('Arial','',9);

        $this->ln(10);

        $driversquery = $mysqli->query("SELECT * FROM drivers WHERE DRCode = '{$_GET['Driver']}'");
        $driver = mysqli_fetch_object($driversquery);

        $this->SetFont('','B');


        $where = array();
        $where[] = "ds.DRCode = '{$_GET['Driver']}'";
        $where[] = "ds.Status IN ('')";
        $where[] = "ds.DateFrom BETWEEN '{$DateFrom}' AND '{$DateTo}' ";

        //if($_GET['EncoderName'] != ""){
            $where[] = "ds.CreatedBy = {$CreatedBy}";
        //}



        $this->Cell(25, 5, 'Driver\'s Name');
        $this->Cell(5, 5, ':', 0, 0, 'C');
        $this->SetFont('','');
        $this->Cell(100, 5, $driver->FullName, 0, 0);
        $this->Cell(25, 5, "Total Delivered : _____________", 0, 1);

        $this->SetFont('','B');
        $this->Cell(25, 5, 'Driver Partner');
        $this->Cell(5, 5, ':', 0, 0, 'C');
        $this->SetFont('','');
        $this->Cell(100, 5,"_______________________________________", 0, 1);

        $this->SetFont('','B');
        $this->Cell(25, 5, 'Printed Date');
        $this->Cell(5, 5, ':', 0, 0, 'C');
        $this->SetFont('','');
        $this->Cell(100, 5, date("F j, Y h:i:s A"), 0, 0);
        $this->Cell(25, 5, "Total Undelivered  : __________", 0, 1);

        $this->SetFont('','B');
        $this->Cell(25, 5, 'Date From');
        $this->Cell(5, 5, ':', 0, 0, 'C');
        $this->SetFont('','');
        $this->Cell(100, 5, date("F j, Y", strtotime($_GET['DateFrom'])), 0, 0);
        $this->Cell(25, 5, "Petty Cash Amount  : _________", 0, 1);

        $this->SetFont('','B');
        $this->Cell(25, 5, 'Date To');
        $this->Cell(5, 5, ':', 0, 0, 'C');
        $this->SetFont('','');
        $this->Cell(100, 5, date("F j, Y", strtotime($_GET['DateTo'])), 0, 0);



        $this->SetFont('Arial','',8);
        $this->Cell(25, 5, "Meal  : _________", 0, 1);
        $this->Cell(130, 5, '');
        // $this->Cell(100, 5, date("F j, Y", strtotime($_GET['DateTo'])), 0, 0);
        $this->Cell(25, 5, "Gasoline  : _________", 0, 1);

        $this->Cell(130, 5, '');
        // $this->Cell(100, 5, date("F j, Y", strtotime($_GET['DateTo'])), 0, 0);
        $this->Cell(25, 5, "Fare  : _________", 0, 1);

        $this->Cell(130, 5, '');
        // $this->Cell(100, 5, date("F j, Y", strtotime($_GET['DateTo'])), 0, 0);
        $this->Cell(25, 5, "Others  : _________", 0, 1);

        $this->Cell(130, 5, '');
        // $this->Cell(100, 5, date("F j, Y", strtotime($_GET['DateTo'])), 0, 0);
        $this->Cell(25, 5, "Total Expenses  : _________", 0, 1);

        $this->Cell(130, 5, '');
        // $this->Cell(100, 5, date("F j, Y", strtotime($_GET['DateTo'])), 0, 0);
        $this->Cell(25, 5, "Changed  : _________", 0, 1);

        $this->Cell(130, 5, '');
        // $this->Cell(100, 5, date("F j, Y", strtotime($_GET['DateTo'])), 0, 0);
        $this->Cell(25, 5, "Reimburstment  : _________", 0, 1);

        $this->ln(10);

   


        $query = $mysqli->query("SELECT
                                    dl.AccountNo,dl.ID DLID,
                                    dl.FullName DLName,		
                                    ds.DateFrom,
                                    ds.DateTo,
                                    u.AccountType Supervisor,
                                    CONCAT(dl.Address1,'-',dl.Address2) Address
                                FROM driverschedule ds
                                INNER JOIN demandletter_anchor dl ON dl.ID = ds.DLID
                                INNER JOIN user u ON u.ID = dl.CreatedBy
                                Where ".@implode(' and ',$where)."
                                order by dl.FullName asc");

        $header = array("#","DL ID", "Account#","DL Name", "Date From", "Date To", "Account Type", "Address");

        $this->SetFont("", "B");




        $this->SetWidths(array(7,15,25,30,20,20,25,55));
        $this->Row($header);

        $this->SetFont("", "", 7);
        $Counter = 1;
        if($query->num_rows){
            while($res = mysqli_fetch_object($query)){
                $this->Row(array($Counter,"DL".$res->DLID,$res->AccountNo,ucwords(strtolower($res->DLName)),date("m/d/Y", strtotime($res->DateFrom)),
                date("m/d/Y", strtotime($res->DateTo)),$res->Supervisor,$res->Address));

                $Counter++;
            }
        }
        $this->SetFont('','B');
        $this->ln(5);
        $this->Cell(15, 5, 'Reasons "Note: Please Indicate Time for Rainy or Other Incident"');
        $this->Cell(5, 5, ':', 0, 1, 'C');
        $this->Cell(0, 0, '', 1, 1, 'L');
        $this->ln(5);
        $this->Cell(0, 0, '', 1, 1, 'L');
        $this->ln(5);
        $this->Cell(0, 0, '', 1, 1, 'L');
        $this->ln(5);
        $this->Cell(0, 0, '', 1, 1, 'L');
        $this->ln(5);
        $this->Cell(0, 0, '', 1, 1, 'L');
        $this->ln(5);
        $this->Cell(0, 0, '', 1, 1, 'L');
        $this->ln(5);
        $this->Cell(0, 0, '', 1, 1, 'L');
        $this->ln(5);
        $this->Cell(15, 5, 'Signature / "Note: Please Indicate Time for Rainy or Other Incident"');
        $this->ln(5);
        $this->Cell(50, 10, '', 1, 1, 'C');
        $this->Cell(15, 5, '"Note: Please Indicate Time for Rainy or Other Incident"');
        $this->SetFont("", "", 9);


        $this->Output();
        
        
        
        
    }
}

?>