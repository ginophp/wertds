<?php

	session_start();
	require_once("class/config.php");
	require_once("class/function.php");
	require_once("library/pagination.php");

	if(isset($_GET['logout'])){
		if(file_exists("pages/supervisor/pdf/letters/signatures/signature{$_SESSION['empid']}.png")){
			unlink("pages/supervisor/pdf/letters/signatures/signature{$_SESSION['empid']}.png");
		}
        loginaccount($_SESSION['empid']);
		// die();
		session_destroy();
		header("Location: login.php");
	}	
	if(!isset($_SESSION['empid'])){
		session_destroy();
		header("Location: login.php");
		die();
	}
	
	$module = "";
	$submenus = "";
	$submenusmultiple = "";
	$arrayid = array();

	$qmodule = $mysqli->query("select * from module where trim(Access) like ('%".$_SESSION['position']."%') order by Ordering ASC");

   

	if( $qmodule->num_rows > 0 ){

		while($r = $qmodule->fetch_object()){
			$submenus = "";
			$module .= '<li class = "active">';
			$module .= '<a href="#"><i class="fa '.$r->Icon.' fa-fw"></i>'.$r->Description.'<span class="fa arrow"></span></a>';
			$module .= '<ul class="nav nav-second-level">';
			
			$qsubmodule = $mysqli->query("SELECT * FROM submodule where ModuleID = ".$r->ID);
			if($qsubmodule->num_rows > 0){
				while($rr = $qsubmodule->fetch_object()){
					$array_access = explode(',',$rr->Access);
					foreach($array_access as $access){
							if($_SESSION['position'] == $access){
								if($rr->IsMultipleMenu == 1){
									$submenus 	.= '<li>';
									$submenus	.= '<a href="#"><i class="fa '.$rr->Icon.' fa-fw"></i>'.$rr->Description.' <span class="fa arrow"></span></a>';
									$submenusmultiple = $mysqli->query("select * from submodule where ParentID = ".$rr->ID);
									if($submenusmultiple->num_rows > 0){
										$submenus .= '<ul class="nav nav-third-level">';
										while($rrr = $submenusmultiple->fetch_object()){
												$arrayid[] = $rrr->ID;
												$submenus .= '<li>';
												$submenus .= '<a href="index.php?PageID='.$rrr->Code.'"><i class="fa '.$rrr->Icon.' fa-fw"></i>'.$rrr->Description.' <span class="fa arrow"></span></a>';
												$submenus .= '</li>';
										}
										$submenus .='</ul>';
									}
									$submenus 	.= '</li>';
								}else{
									if(!in_array($rr->ID,$arrayid)){
										$submenus 	.= '<li>';
										$submenus	.= '<a href="index.php?PageID='.$rr->Code.'"><i class="fa '.$rr->Icon.' fa-fw"></i>'.$rr->Description.' <span class="fa arrow"></span></a>';
										$submenus 	.= '</li>';
									}
								}
							}
					}
				}
			}	
			
			$module .= $submenus;
			$module .= '</ul>';
			$module .= '</li>';
		}
	}
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>POS</title>

    <!-- Bootstrap Core CSS -->
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- -->
    <script src="js/geo-min.js" type="text/javascript" charset="utf-8"></script>
    <!-- MetisMenu CSS -->
    <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
	<script src="js/jquery/jquery-ui.js"></script>
	<link href="js/jquery/jquery-ui.css" rel="stylesheet">
    <!-- Bootstrap Core JavaScript -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

    

    <script src="js/globalfunction.js"></script>
    <script src="js/selectize.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

    <script src="library/select.js"></script>
	
	<link href="library/select.css" rel="stylesheet">
    <script>
		function logout(){
			if(confirm("are you sure want to logout?")==true){
				location.href = "index.php?logout";
			}
			return false
		}
		
		$(function(){
				
			
			$('[data-toggle="tooltip"]').tooltip();
			
			
			
			
			//for soa
			
			$(document).keypress(function(e) {
				var html = "";
				if(e.which == 13) {
					// alert('x');
					return false;
				}
				<?php 
					if($_SESSION['position'] == 'operation'):
				?>
				if(e.which == 96) {
					// alert('x');
					html = '<form class="form-horizontal" role="form" name="BarcodeInquiry"><div class="form-group">'+
					'<label class="control-label col-sm-3">Barcode : </label>'+
					'<div class="col-sm-5">'+
					'<input type="text" name="BarCode" class="form-control" />'+
					'</div>'+
					'<div class="col-sm-2">'+
					'<button name= "barcode_save" onclick = "return search_barcodes();" class="btn btn-primar">Search</button>'+
					'</div>'+
					'</div>';
					html += '<div class="col-lg-12">'+
					'<div class="panel panel-primary">'+			
					'<div class="panel-heading">Information</div>'+
					'<div class="table-responsive">'+
					'<table id = "datainquiry_fetchdata" class="table table-striped table-bordered table-hover">'+
					'<td align="center">Loading... Please wait...</td>'+
					'</table>'+
					'</div>'+
					'<div class="panel-footer"> '+
					'<ul class="pagination" style="margin:0;"></ul>'+
					'</div>'+
					'</div>'+
					'</div></form>';
					var ButtonList = '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
					$("#MyModal .modal-dialog").removeClass("modal-sm").removeClass("modal-md").addClass("modal-lg");
					$("#MyModal .modal-title").html("Barcode Inquiries");
					$("#MyModal .modal-body").html(html);
					
					$("#MyModal").modal('show');
					return false;
				}
				<?php 
					else:
				?>
					//for SOA fuction
					
					if(e.which == 96) {
						// alert('x');
						html = '<form class="form-horizontal" role="form" name="FinancialInquiry"><div class="form-group">'+
						'<label class="control-label col-sm-3">AccountNumber : </label>'+
						'<div class="col-sm-5">'+
						
						'<select class = "selectize"  id="select-account"  placeholder="...">'+
							
						<?php 
							$q = $mysqli->query("SELECT * FROM dealer");
							if($q->num_rows > 0){
								while($r = $q->fetch_object()){
								$full_name = $r->first_name." ".$r->middle_name." ".$r->last_name;
						?>
							'<option value="<?php echo $r->id; ?>"><?php echo  $full_name; ?></option>'+
						<?php
								}
							}
						?>
						'</select>'+
						
						
						'</div>'+
						'<div class="col-sm-2">'+
						'</div>'+
						'</div>';
						html += '<div class="col-lg-12">'+
						'<div class="panel panel-primary">'+			
						'<div class="panel-heading">DEALER DETAILS</div>'+
						'<div class="table-responsive">'+
						'<table id = "data_promisetopay" class="table table-striped table-bordered table-hover">'+
						'<td align="center">Loading... Please wait...</td>'+
						'</table>'+
						'</div>'+
						'<div class="panel-footer"> '+
						'<ul class="pagination" style="margin:0;"></ul>'+
						'</div>'+
						'</div>'+
						'</div>';
						
						html += '<div class="col-lg-12">'+
						'<div class="panel panel-primary">'+			
						'<div class="panel-heading">BOM INFORMATION</div>'+
						'<div class="table-responsive">'+
						'<table id = "bom_info" class="table table-striped table-bordered table-hover">'+
						'<td align="center">Loading... Please wait...</td>'+
						'</table>'+
						'</div>'+
						'<div class="panel-footer"> '+
						'<ul class="pagination" style="margin:0;"></ul>'+
						'</div>'+
						'</div>'+
						'</div>';
						html += '<div class="col-lg-6">'+
						'<div class="panel panel-primary">'+			
						'<div class="panel-heading">LIST OF SALES INVOICE</div>'+
						'<div class="table-responsive">'+
						'<table id = "lsi" class="table table-striped table-bordered table-hover">'+
						'<td align="center">Loading... Please wait...</td>'+
						'</table>'+
						'</div>'+
						'<div class="panel-footer"> '+
						'<ul class="pagination" style="margin:0;"></ul>'+
						'</div>'+
						'</div>'+
						'</div>';

						html += '<div class="col-lg-6">'+
						'<div class="panel panel-primary">'+			
						'<div class="panel-heading">LIST OF COLLECTIONS</div>'+
						'<div class="table-responsive">'+
						'<table id = "lc" class="table table-striped table-bordered table-hover">'+
						'<td align="center">Loading... Please wait...</td>'+
						'</table>'+
						'</div>'+
						'<div class="panel-footer"> '+
						'<ul class="pagination" style="margin:0;"></ul>'+
						'</div>'+
						'</div>'+
						'</div>';

						html += '<div class="col-lg-12">'+
						'<div class="panel panel-primary">'+			
						'<div class="panel-heading">FOR BOM NETWOKS</div>'+
						'<div class="table-responsive">'+
						'<table id = "bom_networks" class="table table-striped table-bordered table-hover">'+
						'<td align="center">Loading... Please wait...</td>'+
						'</table>'+
						'</div>'+
						'<div class="panel-footer"> '+
						'<ul class="pagination" style="margin:0;"></ul>'+
						'</div>'+
						'</div>'+
						'</div>'+
						'</form>';
						
						var ButtonList = '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
						$("#MyModal .modal-dialog").removeClass("modal-sm").removeClass("modal-md").addClass("modal-lg");
						$("#MyModal .modal-title").html("Financial Inquiry");
						$("#MyModal .modal-body").html(html);
						
						
						$("#MyModal").modal('show');
						var selectz = "";
						
						
						var $x = $(".selectize").selectize({create: false,
							// onInitialize: function() {
								// this.trigger('change', this.getValue(), true);
							// },
						  
						  
						  onDropdownClose: function(dropdown) {
							
								var that = $(dropdown).prev().find('.item');
								selectz = that.data('value');
								
								$.ajax({
					
									type	:	"post",
									dataType:	"json",
									url		:	"class/dashboard.php",
									data	:	{dealer_id:selectz,action:'searchaccountnumber'},
									success	:	function(data){
										// alert('x');
										var html ='<tr><th>#</th><th>Account No</th><th>Full Name</th><th>Mobile No</th><th>Birthday</th><th>Primary Address</th><th>Level</th><th>Available Credit Limit</th></tr>',html2='';
										var htmll ='<tr><th>#</th><th>Posting Date</th><th>Amount</th></tr>',html2='';
										var html_si ='<tr><th>#</th><th>SI</th><th>Gross</th><th>VAT</th><th>Additional Discount</th><th>Net Amount</th><th>Outstanding Balance</th></tr>';
										var html_lc ='<tr><th>#</th><th>Date</th><th>Mode of payment</th><th>Check details</th><th>Amount</th><th>Particulars</th></tr>';
										var html_networks ='<tr><th>#</th><th>Account No</th><th>Full Name</th><th>Mobile No</th><th>Birthday</th><th>Primary Address</th><th>Level</th><th>Available Credit Limit</th></tr>',html2='';
										var html_bom_info ='<tr><th>#</th><th>Account No</th><th>Full Name</th><th>Mobile No</th><th>Birthday</th><th>Primary Address</th><th>Level</th><th>Available Credit Limit</th></tr>',html2='';
										if(data['response']=='success'){
											var a=1;
											for(var x = 0; data['data_handler_dealer_info'].length > x; x++){
												html+= '<tr>';
												html+= '<td>'+a+'</td>';
												html+= '<td>'+data['data_handler_dealer_info'][x].id+'</td>';
												html+= '<td>'+data['data_handler_dealer_info'][x].first_name+' '+data['data_handler_dealer_info'][x].middle_name+' '+data['data_handler_dealer_info'][x].last_name+'</td>';
												html+= '<td>'+data['data_handler_dealer_info'][x].mobile_number+'</td>';
												html+= '<td>'+data['data_handler_dealer_info'][x].birthday+'</td>';
												html+= '<td>'+data['data_handler_dealer_info'][x].primary_address+'</td>';
												html+= '<td>'+data['data_handler_dealer_info'][x].level+'</td>';
												html+= '<td>'+data['data_handler_dealer_info'][x].credit_limit+'</td>';
												html+= '</tr>';
												
												a++
											}
											
											if(data['si_response']=='success'){
												var a=1;
												// alert('x');
												for(var x = 0; data['data_handler_so'].length > x; x++){
													html_si+= '<tr>';
													html_si+= '<td>'+a+'</td>';
													html_si+= '<td>'+data['data_handler_so'][x].id+'</td>';
													html_si+= '<td>'+data['data_handler_so'][x].total_price+'</td>';
													html_si+= '<td>'+data['data_handler_so'][x].vat+'</td>';
													html_si+= '<td>'+data['data_handler_so'][x].additional_discount+'</td>';
													html_si+= '<td>'+data['data_handler_so'][x].net_amount+'</td>';
													html_si+= '<td>'+data['data_handler_so'][x].outstanding_balance+'</td>';
													html_si+= '</tr>';
													
													a++
												}
												
											}
											
											
											if(data['mother_id_info']=='success'){
												var a=1;
												// alert('x');
												for(var x = 0; data['mother_info_response'].length > x; x++){
													html_bom_info += '<tr>';
													html_bom_info += '<td>'+a+'</td>';
													html_bom_info += '<td>'+data['mother_info_response'][x].id+'</td>';
													html_bom_info += '<td>'+data['mother_info_response'][x].first_name+' '+data['data_handler_dealer_info'][x].middle_name+' '+data['data_handler_dealer_info'][x].last_name+'</td>';
													html_bom_info += '<td>'+data['mother_info_response'][x].mobile_number+'</td>';
													html_bom_info += '<td>'+data['mother_info_response'][x].birthday+'</td>';
													html_bom_info += '<td>'+data['mother_info_response'][x].primary_address+'</td>';
													html_bom_info += '<td>'+data['mother_info_response'][x].level+'</td>';
													html_bom_info += '<td>'+data['mother_info_response'][x].credit_limit+'</td>';
													html_bom_info += '</tr>';
													
													a++
												}
												
											}
											
											if(data['lc_response']=='success'){
												var a=1;
												// alert('x');
												for(var x = 0; data['data_handler_dealer_or'].length > x; x++){
													html_lc+= '<tr>';
													html_lc+= '<td>'+a+'</td>';
													html_lc+= '<td>'+data['data_handler_dealer_or'][x].date+'</td>';
													html_lc+= '<td>'+data['data_handler_dealer_or'][x].mode_of_payment+'</td>';
													html_lc+= '<td> </td>';
													html_lc+= '<td>'+data['data_handler_dealer_or'][x].amount+'</td>';
													html_lc+= '<td>'+data['data_handler_dealer_or'][x].particulars+'</td>';
													html_lc+= '</tr>';
													
													a++
												}
											}
											
											if(data['boa_n_response']=='success'){
												var a=1;
												// alert('x');
												for(var x = 0; data['data_handler_dealer_boa'].length > x; x++){
													html_networks+= '<tr>';
													html_networks+= '<td>'+a+'</td>';
													html_networks+= '<td>'+data['data_handler_dealer_boa'][x].id+'</td>';
													html_networks+= '<td>'+data['data_handler_dealer_boa'][x].first_name+' '+data['data_handler_dealer_boa'][x].middle_name+' '+data['data_handler_dealer_boa'][x].last_name+'</td>';
													html_networks+= '<td>'+data['data_handler_dealer_boa'][x].mobile_number+'</td>';
													html_networks+= '<td>'+data['data_handler_dealer_boa'][x].birthday+'</td>';
													html_networks+= '<td>'+data['data_handler_dealer_boa'][x].primary_address+'</td>';
													html_networks+= '<td>'+data['data_handler_dealer_boa'][x].level+'</td>';
													html_networks+= '<td>'+data['data_handler_dealer_boa'][x].credit_limit+'</td>';
													html_networks+= '</tr>';
													
													a++
												}
											}
										}
										
										
										$("#MyModal .modal-body #data_promisetopay").html(html);
										$("#MyModal .modal-body #lsi").html(html_si);
										$("#MyModal .modal-body #bom_networks").html(html_networks);
										$("#MyModal .modal-body #lc").html(html_lc);
										$("#MyModal .modal-body #bom_info").html(html_bom_info);
									}
									
								});
								return false;
								
								
								
								
								
								// return false;
								}
							});
							
							if($x[0].selectize != ""){
								var control = $x[0].selectize;
								// control.focus();
								control.clear();
							
							
								control.click();
								 // control.setValue("YOURVALUE");
								// return false;
							}
							 
						
					
					}
				<?php endif; ?>
				
			
				
				
			});
			
			//for soa..
			
			
		});
		
		
		
	</script>
</head>
<style>
    
.navbar-inverse .navbar-brand {
    color: yellow;
}
    
/*.top-nav>li>a {
    color: yellow;
}*/
.ui-widget-header {
    border: 1px solid #494437;
    background: #817865 url(images/ui-bg_gloss-wave_45_817865_500x100.png) 50% 50% repeat-x;
    color: #000000;
    font-weight: bold;
}

</style>


</style>
<body>
<!-- body oncontextmenu="return false;" -->

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php?ID=0">POS</a>
                <a class="navbar-brand">Welcome <?=$_SESSION['username'];?> !</a>
            </div>
            <ul class="nav navbar-top-links navbar-right">
               
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i><i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
							<a href="#" onclick="ViewProfile();">
								<i class="fa fa-user fa-fw"></i>View Profile
							</a>
						</li>
                        <li class="divider"></li>
                        <li>
                            <?php
                                if($_SESSION['position'] == 'supervisor'):
                            ?>
                                <a href="#" onclick="ViewCollectors(1);">
								    <i class="fa fa-users fa-fw"></i>View Collectors
							    </a>
                            <?php
                                else:
                            ?>
                                <a href="#" onclick="ViewDriver(2);">
								    <i class="fa fa-users fa-fw"></i>View Driver
							    </a>
							<?php endif;

                            ?>
						</li>
                        <li class="divider"></li>
                            <li>
								<a href="#" onclick="ChangePassword();">
									<i class="fa fa-lock fa-fw"></i>Change Password
								</a>
							</li>
                        </li>
                       <li class="divider"></li>
                        <li>
                            <a href="#" onclick="logout();"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
            </ul>
             <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                       <!-- Menus -->
                        
                        <?=$module;?>
                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>