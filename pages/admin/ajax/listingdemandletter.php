<?php 

session_start();
require('../../../class/config.php');
require('../../../library/pagination.php');

$userid = $_SESSION['empid'];

if(isset($_POST['action'])){
	
	if($_POST['action'] == "GetDemandLetter"){
		
		$branch = $_POST['Branch'];
		$Supervisors = $_POST['Supervisors'];
		$area = $_POST['Area'];
		$region = $_POST['Region'];
		$city = $_POST['City'];
		$zip = $_POST['ZIP'];
		$dateuploaded = $_POST['DateUploaded'];
		$AmountFrom = $_POST['AmountFrom'];
		$AmountTo = $_POST['AmountTo'];
		$AccountNumber = $_POST['AccountNumber'];
		$Identifier = ($_POST['Identifier']=='+')?'positive':'negative';
		$page = $_POST['page'];
		$total = 50;
		$start = ($page > 1) ? ($page - 1) * $total : 0;
        
        
		$where = "";
		if($branch != ""){
			$where .= " AND dl.Branch = '{$branch}'";
		}
        
        
		if($AmountFrom != 0 && $AmountTo != 0){
			$where .= " AND dl.TotalAmountDue between {$AmountFrom} and {$AmountTo}";
		}
		
		if($area != ""){
			$where .= " AND dl.Area = '{$area}'";
		}
		
		if($region != ""){
			$where .= " AND zc.major_area = '{$region}'";
		}
		
		if($city != ""){
			$where .= " AND zc.city = '{$city}'";
		}
		
		// if($zip != ""){
			// $where .= " AND zc.zip_code = '{$zip}'";
		// }
		
		if($dateuploaded != ""){
			$dateuploaded = date("Y-m-d", strtotime($dateuploaded));
			$where .= " AND date(dl.DateUploaded) = '{$dateuploaded}'";
		}
		
		if($AccountNumber != ""){
            $where .= " AND dl.AccountNo like '%{$AccountNumber}%'";
            //$where .= " AND ifnull(ds.Status,'positive') = '{$Identifier}'";
		}
		
		
		if($Supervisors > 0){
            $where .= " AND dl.CreatedBy =".$Supervisors;
            //$where .= " AND ifnull(ds.Status,'positive') = '{$Identifier}'";
		}
		
        
       //if(ds.ID is null,'negative',ifnull(ds.Status,'positive'))
        
 		$query = $mysqli->query("SELECT dl.*,
								#ifnull(ds.Status,'positive') Identifier 
								if(ds.ID is null,'positive',ifnull(ds.Status,'negative')) Identifier
								FROM demandletter dl 
                                #LEFT JOIN  zc ON zc.zip_code = dl.Dlzip1 
                                LEFT JOIN driverschedule ds on ds.DLID = dl.ID
                                LEFT JOIN dlstatus dls on dls.ID = ds.DLReasonID 
                                WHERE #dl.CreatedBy = ".$userid." and 
								dl.Archived = 0 ".$where."  group by dl.ID #LIMIT $start, $total");
		
        
 		
		// $totalquery = $mysqli->query("SELECT dl.*,ifnull(ds.Status,'positive') Identifier FROM demandletter dl 
                                // LEFT JOIN zipcodes zc ON zc.zip_code = dl.Dlzip1 
                                // LEFT JOIN driverschedule ds on ds.DLID = dl.ID
                                // LEFT JOIN dlstatus dls on dls.ID = ds.DLReasonID 
                                // WHERE dl.CreatedBy = $userid $where ");
        
		$totalquery = $query->num_rows;
		
		$html = '<table id="tabledemandletter" class="table table-striped table-bordered table-hover">';
		$html .= '<thead>
					<tr class="warning">
						<th><input type="checkbox" name="CheckAll" onchange="return CheckAllDLDetails(this);" /></th>
						<th>#</th>
						<th>Action Supervisor</th>
						<th>Action Operation</th>
						<th>Barcode No.</th>
						<th>Account No.</th>
						<th>Account Name</th>
						<th>Total Amount Due</th>
						<th>Primary Address 1</th>
						<th>Primary Address 2</th>
						<th>Primary Address 3</th>
						<th>Primary Address 4</th>
						<th>Primary Address 5</th>		
					</tr>
				</thead>
				<tbody>';
        $counter = 0;
		if($query->num_rows){
            $glarrayvalidation  = array(10,11);
			while($res = mysqli_fetch_object($query)){
				$res->PuloutDate = ($res->PuloutDate == "")?date("Y-m-d",strtotime($res->PuloutDate)):date("Y-m-d");
				$btns = "";
				$btnsval = "negative";
				$btnvalidation = 1;
                
                
                // start here..
                
                //btns validation.. 
                $pullout = $mysqli->query("select * from pullout where DLID = {$res->ID} order by ID desc limit 1");
                $pulloutvalidation = 0;
                if($pullout->num_rows > 0){
                    $pulloutvalidation = $pullout->fetch_object()->IsPulledOut;
                }
                
                if($pulloutvalidation == 0){
                    //if( date("Y-m-d") >= $res->PuloutDate  ){
                        //query for refield and resched..
                        $refieldreschedval = $mysqli->query("SELECT dls.ID ReasonID,dls.GLCode,d.Status FROM driverschedule d 
                                        INNER JOIN dlstatus dls ON dls.ID = d.DLReasonID
                                        WHERE d.DLID = {$res->ID} ORDER BY d.id DESC LIMIT 1 ");
                        
                        $ReasonID = "";
                        
                        $val = 0;
                        if($refieldreschedval->num_rows > 0){
                            $refieldreschedvalres = $refieldreschedval->fetch_object();

                            if(strtoupper($refieldreschedvalres->Status) == 'NEGATIVE'){
                                $btnvalidation = 1;
                            }else{
                                $btnvalidation = 0;
                            }
                            $val = 1;
                            $ReasonID = $refieldreschedvalres->ReasonID;
                        }else{
                            $btns    = '<input type="checkbox" onclick = "singlecheck()" name="DemandLetterID[]" value="'.$res->ID.'" />';
                            $btnsval = "positive";
                        }
                        

                        if($val>0){

                            if(in_array($refieldreschedvalres->GLCode,$glarrayvalidation)){
                                $btns = "";
                                $btnsval = "negative";
                                $btnvalidation = 1;
                            }else{
                                if($btnvalidation == 0){
                                    $btns    = '<input type="checkbox" onclick = "singlecheck()" name="DemandLetterID[]" value="'.$res->ID.'" />';
                                    $btnsval = "positive";
                                }	
                            }
                        }else{
                            if($btnvalidation == 0){
                                $btns    = '<input type="checkbox" onclick = "singlecheck()" name="DemandLetterID[]" value="'.$res->ID.'" />';
                                $btnsval = "positive";
                            }


                        }

                        if($btns != ""){
                            if($Identifier == "positive"){
                                if($_POST['Reasons'] != 0){
                                    if($_POST['Reasons'] == $ReasonID){
                                        $counter++;
                                        $html .= '<tr>
                                            <td align="center">
                                                <!--<button class="btn btn-sm btn-danger" onclick="return DisplayPrintForm('.$res->ID.');">
                                                    <span class="glyphicon glyphicon-print"></span>
                                                </button>-->
                                                '.$btns.'
                                            </td>
                                            <td>
                                                '.$counter.'
                                            </td>
                                            <td align="center">
                                                <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="View Details" onclick="return ViewDLDetails('.$res->ID.');">
                                                        <span class="glyphicon glyphicon-search"></span>
                                                </button>
                                            </td>
                                            <td align="center">
                                                <button class="btn btn-sm btn-success" data-toggle="tooltip" title="Operation View Details" onclick="return OpsViewDLDetails('.$res->ID.');">
                                                        <span class="glyphicon glyphicon-search"></span>
                                                </button>
                                            </td>
                                            <td>'.$res->ID.'</td>
                                            <td>'.$res->AccountNo.'</td>
                                            <td>'.clean($res->Name).'</td>
                                            <td align="right">'.number_format((float)$res->TotalAmountDue,2).'</td>
                                            <td>'.clean($res->Primaryadd1).'</td>
                                            <td>'.clean($res->Primaryadd2).'</td>
                                            <td>'.clean($res->Primaryadd3).'</td>
                                            <td>'.clean($res->Primaryadd4).'</td>
                                            <td>'.clean($res->Primaryadd5).'</td>
                                        </tr>';
                                    }
                                    
                                }else{
                                    $counter++;
                                    $html .= '<tr>
                                        <td align="center">
                                            <!--<button class="btn btn-sm btn-danger" onclick="return DisplayPrintForm('.$res->ID.');">
                                                <span class="glyphicon glyphicon-print"></span>
                                            </button>-->
                                            '.$btns.'
                                        </td>
                                        <td>
                                            '.$counter.'
                                        </td>
                                        <td align="center">
                                            <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="View Details" onclick="return ViewDLDetails('.$res->ID.');">
                                                    <span class="glyphicon glyphicon-search"></span>
                                            </button>
                                        </td>
                                        <td align="center">
                                            <button class="btn btn-sm btn-success" data-toggle="tooltip" title="Operation View Details" onclick="return OpsViewDLDetails('.$res->ID.');">
                                                    <span class="glyphicon glyphicon-search"></span>
                                            </button>
                                        </td>
                                        <td>'.$res->ID.'</td>
                                        <td>'.$res->AccountNo.'</td>
                                        <td>'.clean($res->Name).'</td>
                                        <td align="right">'.number_format((float)$res->TotalAmountDue,2).'</td>
                                        <td>'.clean($res->Primaryadd1).'</td>
                                        <td>'.clean($res->Primaryadd2).'</td>
                                        <td>'.clean($res->Primaryadd3).'</td>
                                        <td>'.clean($res->Primaryadd4).'</td>
                                        <td>'.clean($res->Primaryadd5).'</td>
                                    </tr>';
                                }
                                
                            }

                        }else{

                            if($Identifier == "negative"){
                                
                                if($_POST['Reasons'] != 0){
                                    if($_POST['Reasons'] == $ReasonID){
                                        $counter++;
                                        $html .= '<tr>
                                            <td align="center">
                                            </td>
                                            <td>
                                                '.$counter.'
                                            </td>
                                            <td align="center">
                                                <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="View Details" onclick="return ViewDLDetails('.$res->ID.');">
                                                        <span class="glyphicon glyphicon-search"></span>
                                                </button>
                                            </td>
                                            <td align="center">
                                                <button class="btn btn-sm btn-success" data-toggle="tooltip" title="Operation View Details" onclick="return OpsViewDLDetails('.$res->ID.');">
                                                        <span class="glyphicon glyphicon-search"></span>
                                                </button>
                                            </td>
                                            <td>'.$res->ID.'</td>
                                            <td>'.$res->AccountNo.'</td>
                                            <td>'.clean($res->Name).'</td>
                                            <td align="right">'.$res->TotalAmountDue.'</td>
                                            <td>'.clean($res->Primaryadd2).'</td>
                                            <td>'.clean($res->Primaryadd3).'</td>
                                            <td>'.clean($res->Primaryadd1).'</td>
                                            <td>'.clean($res->Primaryadd4).'</td>
                                            <td>'.clean($res->Primaryadd5).'</td>
                                        </tr>';
                                    }
                                }else{
                                    
                                    $counter++;
                                    $html .= '<tr>
                                        <td align="center">
                                        </td>
                                        <td>
                                            '.$counter.'
                                        </td>
                                        <td align="center">
                                            <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="View Details" onclick="return ViewDLDetails('.$res->ID.');">
                                                    <span class="glyphicon glyphicon-search"></span>
                                            </button>
                                        </td>
                                        <td align="center">
                                            <button class="btn btn-sm btn-success" data-toggle="tooltip" title="Operation View Details" onclick="return OpsViewDLDetails('.$res->ID.');">
                                                    <span class="glyphicon glyphicon-search"></span>
                                            </button>
                                        </td>
                                        <td>'.$res->ID.'</td>
                                        <td>'.$res->AccountNo.'</td>
                                        <td>'.clean($res->Name).'</td>
                                        <td align="right">'.$res->TotalAmountDue.'</td>
                                        <td>'.clean($res->Primaryadd2).'</td>
                                        <td>'.clean($res->Primaryadd3).'</td>
                                        <td>'.clean($res->Primaryadd1).'</td>
                                        <td>'.clean($res->Primaryadd4).'</td>
                                        <td>'.clean($res->Primaryadd5).'</td>
                                    </tr>';
                                }
                                
                                
                            }

                        }
                    //}
                    
                }
                
				
			}
		}else{
			$html .= '<tr>
						<td colspan="20" align="center">No result found.</td>
					</tr>';
		}
		$html .= "</tbody></table>";
		
		
		
		$result['Details'] = $html;
        
      
        
        //$result['Pagination'] = AddPagination($total, $totalquery->num_rows, $page, "showPage");
		$result['Counter'] = "Total Row(s) Display ".$counter;
        
		//print_r($result);
		
		//$result['Pagination'] = AddPagination($total, $totalquery->num_rows, $page, "showPage");
		// print_r($result);
		die(json_encode($result));
		
	}
	
	if($_POST['action']=='Archived'){
		print_r($_POST);
		$ids = implode(",",$_POST['DemandLetterID']);
		$mysqli->query("update demandletter set Archived = 1 where ID in ({$ids})");
		
	}
	
	if($_POST["action"] == "DemandLetterTypeForm"){
		
		//$DLID = $_POST["DLID"];
		$userquery = $mysqli->query("SELECT * FROM user WHERE ID = ".$_SESSION['empid']);
		$user = mysqli_fetch_object($userquery);
		
		echo '<form action="" method="post" class="form-horizontal" role="form" name="DemandLetterTypeForm">
				<div class="form-group">
					<label class="control-label col-md-4">Demand Letter Type : </label>
					<div class="col-md-7">
						<select class="form-control" name="DemandLetterType">';
							
							$query = $mysqli->query("SELECT dlt.Description, dlp.url, dlt.Code FROM dltype dlt 
													LEFT JOIN dlprint dlp ON dlp.DLTypeCode = dlt.Code 
													AND dlt.AccountType = dlp.AccountType
													WHERE dlt.AccountType = '".$user->AccountType."'");
							if($query->num_rows){
								echo '<option value="">Select...</option>';
								while($res = mysqli_fetch_object($query)){
									echo '<option data-url="'.$res->url.'" value="'.$res->Code.'">'.$res->Description.'</option>';
								}
							}else{
								echo '<option value="">No record.</option>';
							}
							
						echo '</select>
						<span id="helpBlock" class="help-block"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4">Signature : </label>
					<div class="col-md-7">
						<input type="file" class="input-md" name="Signature" />
						<span id="helpBlock2" class="help-block"></span>
					</div>
				</div>
			</form>';
		
	}
	
	if($_POST["action"] == "FieldListing"){
		
		//$DLID = $_POST["DLID"];
		// $userquery = $mysqli->query("SELECT * FROM user WHERE ID = ".$_SESSION['empid']);
		// $user = mysqli_fetch_object($userquery);
		
		echo '<form action="" method="post" class="form-horizontal" role="form" name="FieldListingForm">
				<div class="form-group">
					<label class="control-label col-md-4">Driver : </label>
					<div class="col-md-7">
						<select class="form-control" name="Driver">';
							
							$query = $mysqli->query("select * from drivers order by FullName");
							if($query->num_rows){
								echo '<option value="ALL">[ALL]</option>';
								while($res = mysqli_fetch_object($query)){
									echo '<option value="'.$res->DRCode.'">'.$res->FullName.'</option>';
								}
							}else{
								echo '<option value="">No record.</option>';
							}
							
						echo '</select>
						<span id="helpBlock" class="help-block"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4">Date Field From : </label>
					<div class="col-md-7">
						<input type="text" class="form-control" placeholder = "'.date("m/d/Y").'" name="DateReturnedFrom" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4">Date Field To: </label>
					<div class="col-md-7">
						<input type="text" class="form-control" placeholder = "'.date("m/d/Y").'" name="DateReturnedTo" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-4">Level: </label>
					<div class="col-md-7">
						<select name="Level" class = "form-control">';
							$query = $mysqli->query("select Level from demandletter where CreatedBy = {$_SESSION['empid']} group by Level");
							if($query->num_rows){
								echo '<option value="ALL">[ALL]</option>';
								while($res = mysqli_fetch_object($query)){
									echo '<option value="'.$res->Level.'">'.$res->Level.'</option>';
								}
							}else{
								echo '<option value="0">No record.</option>';
							}
			echo 		'</select>
					</div>
				</div>
			</form>';
		
	}
	
	if($_POST["action"] == "GetDLDetails"){
		
		$dlid = $_POST['DLID'];
		
		$query = $mysqli->query("SELECT * FROM demandletter WHERE ID = $dlid");
		$res = mysqli_fetch_object($query);
		$excluded = array("ID", "CreatedBy");
		
		echo '<form class="form-horizontal">';
		foreach($res as $field => $value){
			if(!in_array($field, $excluded)){
				$value = (empty($value)) ? "N/A" : $value;
				echo "<div class='form-group' style='margin-bottom : 5px;'>
						<label class='control-label col-sm-4' style='padding-top:0px;'>{$field} : </label>
						<div class='col-sm-8'>
							<p class='form-control-static' style='min-height:0px; padding:0px; padding-left:5px; padding-right:5px; background : #f9f9f9;'>{$value}</p>
						</div>
					</div>";
			
			}
		}
		echo '</form>';
	}
    
	if($_POST["action"] == "GetDLOpsDetails"){
		
		$dlid = $_POST['DLID'];
		
		$query = $mysqli->query("select d.ID, dr.FullName DriverName,d.*,dls.Description ReasonDescription,ds.GLCode,ds.Description ReasonDescription 
		from driverschedule d
        inner join dlstatus ds on ds.ID = d.DLReasonID
		inner join drivers dr on dr.DRCode = d.DRCode 
		inner join dlstatus dls on dls.ID  = d.DLReasonID
        WHERE d.DLID = $dlid order by d.id desc");
		//$res = mysqli_fetch_object($query);
		$excluded = array("id", "DLID","CreatedBy","DLReasonID","DateUpdated");
		
		echo '<form class="form-horizontal">';
		if($query->num_rows > 0){
            $counter = 1;
            while($res = $query->fetch_object()){
                echo "<div class='form-group' style='margin-bottom : 5px;'>
                        <label class='control-label col-sm-4' style='padding-top:0px;'>{$counter}</label>
                     </div>";
                        
                foreach($res as $field => $value){
                    if(!in_array($field, $excluded)){
                        $value = (empty($value)) ? "N/A" : $value;
                        
                        if($field == 'SupervisorRemarks'){
							$field='IncentiveType';
						}
                        echo "<div class='form-group' style='margin-bottom : 5px;'>
                                <label class='control-label col-sm-4' style='padding-top:0px;'>{$field} : </label>
                                <div class='col-sm-8'>
                                    <p class='form-control-static' style='min-height:0px; padding:0px; padding-left:5px; padding-right:5px; background : #f9f9f9;'>{$value}</p>
                                </div>
                            </div>";
                    }
                }
				
				if($res->Status == 'positive'){
					
					 echo "<div class='form-group' style='margin-bottom : 5px;'>
								<label class='control-label col-sm-4' style='padding-top:0px;'>Action : </label>
                               
                                <div class='col-sm-8'>
                                  <button name='Print' class='btn btn-sm btn-danger' onclick='return AddIncentiveAmount({$res->ID});'><span class='fa  fa-check'></span> Add Incentive Amount </button>
                                </div>
                            </div>";
				}
                $counter++;
                echo "<br />";
            }
            
            
        }else{
            echo "No Record Found";
        }
        
        
		echo '</form>';
	}
	
	if($_POST["action"] == "SaveSignature"){
		
		$data = $_POST['image'];
		$file = "../pdf/letters/signatures/signature{$_SESSION['empid']}.png";
		
		list($type, $data) = explode(';', $data);
		list(, $data)      = explode(',', $data);
		$data = base64_decode($data);

		file_put_contents($file, $data);
		$result['Success'] = 1;
		
		die(json_encode($result));
	}
	
	if($_POST["action"] == "GetCity"){
		
		$region = utf8_decode($_POST['Region']);
		
		$query = $mysqli->query("SELECT city FROM zipcodes WHERE `major_area` = '".trim($region)."'");
		
		if($query->num_rows){
			while($res = mysqli_fetch_object($query)){
				$result["City"][] = utf8_encode($res->city);
			}
			
			$result['Success'] = 1;
		}else{
			$result['Success'] = 0;
		}
		
		die(json_encode($result));
		
	}
	
	if($_POST["action"] == "GetZip"){
		
		$city = utf8_decode($_POST['City']);
		$region = utf8_decode($_POST['Region']);
		
		$query = $mysqli->query("SELECT zip_code ZipCode FROM zipcodes WHERE city = '".$city."' AND major_area = '".$region."'");
		
		if($query->num_rows){
			while($res = mysqli_fetch_object($query)){
				$result['Zip'][] = $res->ZipCode;
			}
			
			$result['Success'] = 1;
		}else{
			$result['Success'] = 0;
		}
		
		die(json_encode($result));
		
	}
	
	if($_POST['action'] == "AddCounter"){
		
		$DLID = $_POST['DLID'];
		$query = $mysqli->query("UPDATE demandletter SET Counter = (Counter + 1) WHERE ID = {$DLID}");
		
	}
	
	if($_POST['action'] == 'saveincentive'){
		
		/*
			[Amount] => 2000
			[Remarks] => New Number
			[ID] => 1863
			[action] => saveincentive
			InfoStatus
		*/
		
		// Amount
		// SupervisorRemarks
		//driverschedule
        
        
        if($_POST['NewAddAmount']==""){
            $_POST['NewAddAmount'] = 0;
        }
        if($_POST['NewNumberAmount']==""){
            $_POST['NewNumberAmount'] = 0;
        }
        if($_POST['SevenDaysPaymentAmount']==""){
            $_POST['SevenDaysPaymentAmount'] = 0;
        }
        if($_POST['IncomingCallAmount']==""){
            $_POST['IncomingCallAmount'] = 0;
        }
        if($_POST['InfoStatus']==""){
            $_POST['InfoStatus']  = "";
        }
       
        
		$mysqli->query("update driverschedule set NewAddAmount = {$_POST['NewAddAmount']},
		NewNumberAmount = '{$_POST['NewNumberAmount']}', SevenDaysPaymentAmount = '{$_POST['SevenDaysPaymentAmount']}', 
		IncomingCallAmount = '{$_POST['IncomingCallAmount']}' ,	InfoStatus = '{$_POST['InfoStatus']}' where ID = {$_POST['ID']}");
		$result['Success'] = 1;
	}
    
    if($_POST['action'] == 'getpaymentinformation'){
        $result = array();
        $DLID = $mysqli->query("select DLID from driverschedule where ID = {$_POST['DriverScheduleID']}")->fetch_object()->DLID;
        $q = $mysqli->query("select * from paymenthistory where DLID = {$DLID}");
        if($q->num_rows>0){
            while($r  = $q->fetch_object()){
                $result['data_handler'][] = $r;
            }
            $result['response'] ='success';
        }else{
            
            $result['response'] ='failed';
        }
        
        die(json_encode($result));
    }
    
    
    if($_POST['action'] == 'GetReasons'){
        $result = array();

        $q = $mysqli->query("select * from dlstatus where Identifier = '{$_POST['Identifier']}'");
        if($q->num_rows>0){
            while($r  = $q->fetch_object()){
                $result['data_handler'][] = $r;
            }
            $result['response'] ='success';
        }else{

            $result['response'] ='failed';
        }
         die(json_encode($result));
    }
	
	
    if($_POST['action'] == 'Branch'){
        $branchquery = $mysqli->query("SELECT Branch FROM demandletter WHERE CreatedBy = {$_POST['sup']} GROUP BY Branch");
		if($branchquery->num_rows){
			echo '<option value="">Select</option>';
			while($res = mysqli_fetch_object($branchquery)){
				echo "<option value='{$res->Branch}'>{$res->Branch}</option>";
			}
		}
    }
    if($_POST['action'] == 'Area'){
        $branchquery = $mysqli->query("SELECT Area FROM demandletter WHERE CreatedBy = {$_POST['sup']} GROUP BY Branch");
		if($branchquery->num_rows){
			echo '<option value="">Select</option>';
			while($res = mysqli_fetch_object($branchquery)){
				echo "<option value='{$res->Area}'>{$res->Area}</option>";
			}
		}
    }
	
	
    
   
    
}

?>