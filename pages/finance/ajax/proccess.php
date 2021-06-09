<?php 

session_start();
require('../../../class/config.php');
require('../../../library/pagination.php');

if(isset($_POST['action'])){
	
	
	
	if($_POST["action"] == "Pagination"){
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
		
		if($_POST['Table'] == 'leave'){
			$query = $mysqli->query("SELECT b.company_id_no,concat(b.first_name,' ', b.middle_name,', ',b.last_name) full_name,a.* FROM `{$_POST['Table']}` a inner join employee b on a.employee_id = b.id {$wherecond}  LIMIT $start, $row");
			// $query = $mysqli->query("SELECT * FROM `{$_POST['Table']}` {$wherecond}  LIMIT $start, $row");
			// echo "SELECT b.company_id_no,a.* FROM `{$_POST['Table']}` a inner join employee b on a.employee_id = b.id {$wherecond}  LIMIT $start, $row";
			
		}else{
			$query = $mysqli->query("SELECT * FROM `{$_POST['Table']}` {$wherecond}  LIMIT $start, $row");
			
		}
		
		$queryTotal = $mysqli->query("SELECT * FROM `{$_POST['Table']}` {$wherecond}");
		
		
		$total = $queryTotal->num_rows;
	
        
        if($_POST['Table'] == 'manager'){
			$html = '<table id = "fetch_data" class="table table-striped table-bordered table-hover">
						<thead>
							<tr class="warning"><th>Action</th>';
			
		}else{
			$html = '<table id = "fetch_data" class="table table-striped table-bordered table-hover">
						<thead>
							<tr class="warning"><th>Action</th>';
		}				
        
        $q = $mysqli->query("desc `{$_POST['Table']}`");
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
						if($_POST['Table'] == "employee"){
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
						}else{
							$html .= '<tr>
                           
							<td align="center">
								<button class="btn btn-warning btn-xs" type="button" name="EditCollector" onclick="Edit(\''.$res->id.'\');">
									<span class="fa fa-edit fa-fw"></span>Edit
								</button>
								<button class="btn btn-primary btn-xs" type="button" name="" onclick="AddIncentiveBank(\''.$res->id.'\');">
									<span class="fa fa-edit fa-fw"></span>Add Bank Incentive Percent
								</button>
							</td>';
						}
							
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
    
    
    
    
    if($_POST['action'] == 'Add'){
        $q = $mysqli->query("desc {$_POST['Table']}");
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
								$in_array = array('id');
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
											if($r->Field == $check_tables_r->Tables_in_hr){
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
    
	if($_POST['action'] == 'changestatus'){
		$mysqli->query("update `{$_POST['Table']}` set status = '{$_POST['status']}' where id = {$_POST['id']}");
		die(json_encode(array('response'=>'success')));
	}
    
    if($_POST['action'] == 'Leave_Add'){
        $q = $mysqli->query("desc {$_POST['Table']}");
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
											if($r->Field == $check_tables_r->Tables_in_hr){
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
    

    
    if($_POST['action'] == 'Edit'){
        $q = $mysqli->query("select * from {$_POST['Table']} where id = {$_POST['id']}");
        
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
												if($f == $check_tables_r->Tables_in_hr){
													$validated = 1;
													$tableoption = $f;
													break;
												}
											}
											
											
											if($validated == 1){
												$option_q = $mysqli->query("select * from ".$tableoption);
												$options = "<option value = 0>[SELECT : HERE]</option>";
												if($option_q->num_rows > 0){
													while($option = $option_q->fetch_object()){
														$selected = "";
														if($option->code == $v){
															$selected = "selected";
														}
														$options .= "<option {$selected} value = '{$option->code}'>{$option->description}</option>";
													}
													echo '<div class="row col-lg-4">
													<div class="col-lg-10">
														<div class="form-group">
															<label>'.strtoupper(str_replace('_',' ',$f)).'</label>
															<select class = "form-control" name = "'.$f.'">'.$options.'</select>
														</div>
													</div>
													</div>';
												}
											}else{
													
												echo '<div class="row col-lg-4">
												<div class="col-lg-10">
													<div class="form-group">
														<label>'.strtoupper(str_replace('_',' ',$f)).'</label>
														<input '.$datepicker.' type="text"  name="'.$f.'" class="form-control '.$datepicker.'" value="'.$v.'" />
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
    
    if($_POST['action'] == 'ADdIncentiveBank'){
        $q = $mysqli->query("select * from {$_POST['Table']} where manager_id = {$_POST['id']}");
        // echo "select * from {$_POST['Table']} where id = {$_POST['id']}";
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
								
								// $in_array = array('id');
								
                                while($r = $q->fetch_object()){
                                  
                                   $datepicker = '';
                                   $in_array = array('id');
								   
									echo "<input type = 'hidden' name = 'id[]' value = '{$r->id}'>";
                                    foreach($r as $f =>$v){
                                        if(!in_array($f,$in_array)){
											$check_tables_q = $mysqli->query("SHOW TABLES");
											$validated = 0;
											$tableoption = "";
											while($check_tables_r = $check_tables_q->fetch_object()){
												
												if(str_replace("_id","",$f) == $check_tables_r->Tables_in_hr){
													$validated = 1;
													$tableoption = str_replace("_id","",$f);
													break;
												}
											}
											
											if($validated == 1){
												
												
												$option_q = $mysqli->query("select * from ".$tableoption);
												$options = "<option value = 0>[SELECT : HERE]</option>";
												if($option_q->num_rows > 0){
													while($option = $option_q->fetch_object()){
														$selected = "";
														if($option->id == $v){
															$selected = "selected";
														}
														$options .= "<option {$selected} value = '{$option->id}'>{$option->name}</option>";
													}
													echo '<div class="row col-lg-4">
													<div class="col-lg-10">
														<div class="form-group">
															<label>'.strtoupper(str_replace('_',' ',$f)).'</label>
															<select class = "form-control" name = "'.$f.'[]">'.$options.'</select>
														</div>
													</div>
													</div>';
												}
											}else{
													
												echo '<div class="row col-lg-4">
												<div class="col-lg-10">
													<div class="form-group">
														<label>'.strtoupper(str_replace('_',' ',$f)).'</label>
														<input '.$datepicker.' type="text"  name="'.$f.'[]" class="form-control '.$datepicker.'" value="'.$v.'" />
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
										<option value="1">Upload Incentives</option>
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
						
						<!-- div class="panel-footer">
							<a a href="download/hr.csv" download><span class="glyphicon glyphicon-edit"></span> <b>Download Format</b> </a>
							<br />
							<!-- i><span class="fa fa-warning"></span> * Note : Please download the procedure. c/o Emma Lasala & Joy Villaruel</i>
						</div -->
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
        $in_array = array('Save','employee','employeerelocation','employee_leaves');
        
        foreach($_POST as $f => $v){
            if(!in_array($v,$in_array)){

                $field[] = "`{$f}`";
                $value[] = "'{$v}'";   
            }
        }
		// echo "insert into {$_POST['Table']} (".implode(',',$field).") values (".implode(',',$value).")";
        $mysqli->query("insert into {$_POST['Table']} (".implode(',',$field).") values (".implode(',',$value).")");
		die("success");
    }
    
    if($_POST['action']=='Update'){
        
        $field = array();
        $value = array();
        $in_array = array();
        $in_array[] = 'Update';
        
		
		$table_q = $mysqli->query("SHOW TABLES");
		if($table_q->num_rows > 0){
			while($table_r = $table_q->fetch_object()){
				$in_array[] = $table_r->Tables_in_hr;
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
					$file = fopen($_FILES['file']['tmp_name'], 'r');
					$line = fgetcsv($file, 0, ",");
				}else{
					$handle = fopen($_FILES['file']['tmp_name'], 'r');
					if ($handle){
						while (($line = fgets($handle)) !== false) {
							// process the line read.
							 $explodeone = explode('	',$line);
							 $value = array();
							 foreach($explodeone as $k => $v){
								 $value[] = "'".trim($v)."'";
							 }
							 $mysqli->query("insert into timeinout values(NULL,".@implode(',',$value).")");
							 
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
                   
				
				while(!feof($file)){
				
					
                    //if(!empty($line[0]) AND ucwords($line[0]) != "BANK NAME"){
						
						$field = array();
						
						if($_POST['Selection'] == 1){
                            
                            // starts here..
							if($xxxcnt == 0){
                               
                                $header = array();
                                foreach($line as $val){
                                    //$field[] = $mysqli->real_escape_string($val);
                                    $get_headers = $mysqli->query("desc `{$_POST['table']}`");
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
						
       
        $q = $mysqli->query("desc `{$_POST['Table']}`");
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
        $q = $mysqli->query("desc `{$_POST['Table']}`");
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
											if($r->Field == $check_tables_r->Tables_in_hr){
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
}

?>