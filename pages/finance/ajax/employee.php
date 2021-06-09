<?php 

session_start();
require('../../../class/config.php');
require('../../../library/pagination.php');

if(isset($_POST['action'])){
	
	
	
	if($_POST["action"] == "Pagination"){
		$row = 5;
		$page = $_POST['page'];
		$start = ($page > 1) ? (($page-1) * $row) : 0;
	
		$userid = $_SESSION['empid'];
		$query = $mysqli->query("SELECT * FROM employee LIMIT $start, $row");
		$queryTotal = $mysqli->query("SELECT * FROM employee");
	
		$total = $queryTotal->num_rows;
	
        
        
		$html = '<table id = "fetch_data" class="table table-striped table-bordered table-hover">
					<thead>
						<tr class="warning">';
        
        
        $q = $mysqli->query("desc employee");
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
					
					$html .= '<tr>
							<td align="center">
								<button class="btn btn-warning btn-xs" type="button" name="EditCollector" onclick="EditCollector(\''.$res->Code.'\');">
									<span class="fa fa-edit fa-fw"></span>Edit
								</button>
							</td>
							<td>'.$res->Code.'</td>
							<td>'.$res->Name.'</td>
							<td>'.$res->Alias.'</td>
							<td>'.$res->Birthday.'</td>
							<td>'.$res->Status.'</td>
							<td>'.$res->Number.'</td>
							<td>'.$res->EmailAddress.'</td>
							<td>'.$res->Address.'</td>
						</tr>';
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
	
}

?>