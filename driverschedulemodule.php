<style>
	.table thead tr th{
		text-align:center;
		vertical-align:middle;
	}
	.ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year{
		color : black;
	}
</style>
<div id="wrapper">
	<div id="page-wrapper">
		
		<div id="listingmediaserver">
			
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Field Schedule</h1>
				</div>
				<!-- /.col-lg-12 -->
			</div>
			
			<div class="row">
				<div class="col-lg-12">
					
					<div class="panel panel-primary" id="DriversScheduleModule">
                        <div class="panel-heading">
                            Information
                        </div>
						<div class = "panel-body">
							<form name = "search_parameter">
							<div class="col-lg-6">
								<div class= "form-group">
									Date From : <input type ="text" class = "form-control" name = "DateFrom" value = "<?=date("m/d/Y",strtotime("-7 days"));?>">
								</div>
								<div class= "form-group">
									Date To : <input type ="text" class = "form-control" name = "DateTo" value = "<?=date("m/d/Y");?>">
								</div>
							</div>
							
							<div class="col-lg-6">
								<div class= "form-group">
									Driver : <input type ="text" class = "form-control" name = "Driver">
								</div>
								<div class= "form-group">
									Created By : <input type ="text" class = "form-control" name = "CreatedBy">
								</div>
								<div class= "form-group">
                                    DL Name: <input type ="text" class = "form-control" name = "DlName">
								</div>
							</div>
							</form>
							<div style="padding-bottom:10px;">
								<button class='btn btn-primary' onclick="return Search();">Search</button>
							</div>
							
						</div>
						
					</div>
					
				</div>
				<div class="col-lg-12">
					<?php 
                    if($_SESSION['position'] != 'supervisor'):
                    ?>
                    <div style="padding-bottom:10px;">
						<!-- button class='btn btn-danger' onclick="return AddDriverSchedule();">Add Driver Schedule</button -->
						<button class='btn btn-danger' onclick="return PrintSchedule();">Print Schedule</button>
						<button class='btn btn-primary' onclick="return TransferSchedule();">Transfer Schedule</button>
						<button type="button" class="btn btn-primary" name="BtnFieldListingXls"><span class="glyphicon glyphicon-print"></span> Field Listing</button>
                        <button name="Archive" class="btn btn-sm btn-primary" onclick="return PFDP();"><span class="glyphicon glyphicon-print"></span> Print Field Daily Productivity Report</button>
					</div>
                    <?php endif; ?>
					<div class="panel panel-primary" id="DriversScheduleModule">
                        <div class="panel-heading">
                            Information
                        </div>
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover">
								<td align="center">Loading... Please wait...</td>
							</table>
						</div>
						<div class="panel-footer"></div>
					</div>
					
				</div>
				
			</div>
		
		</div>
		
	</div>
</div>

<script>
	$(function(){
		
		
		
		
		$("[name=Driver]").autocomplete({
		source: function( request, response ) {
			$.ajax( {
			  url: 'pages/operation/ajax/search.php',
			  dataType: "json",
			  type:"post",
			  data: {
				search: request.term,action:'searchdriver'
			  },
			  success: function( data ) {
				 response($.map(data, function(result) {
							return {
								label: result.FullName,
								// Expenses : result.Expenses
								// Result : result.Response
							};
				 }));
			  }
			} );
      },
      minLength: 1,
      select: function( event, ui ) {
		  
      }
	  
	  
    });$("[name=CreatedBy]").autocomplete({
		source: function( request, response ) {
			$.ajax( {
			  url: 'pages/operation/ajax/search.php',
			  dataType: "json",
			  type:"post",
			  data: {
				search: request.term,action:'users'
			  },
			  success: function( data ) {
				 response($.map(data, function(result) {
							return {
								label: result.Name,
								// Expenses : result.Expenses
								// Result : result.Response
							};
				 }));
			  }
			} );
      },
      minLength: 1,
      select: function( event, ui ) {
		  
      }
    });
	
	
		
		
		
		
		$("[name=DateFrom], [name = DateTo]").datepicker();
		showPage(1);
		
		$("[name=BtnFieldListingXls]").click(function(){
			//showPage(1);
            
			$.ajax({
			type	:	"post",
			url		:	"pages/supervisor/ajax/listingdemandletter.php",
			//data	:	{action : "DemandLetterTypeForm", DLID : ID},
			data	:	{action : "FieldListing"},
			success	:	function(data){
			
				var ButtonList = '<button type="button" class="btn btn-info" onclick="PrintFieldListingxls();">Print</button>'+
								 '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
				$("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-md");
				$("#MyModal .modal-title").html("Field Listing");
				$("#MyModal .modal-body").html(data);
				$("#MyModal .modal-footer").html(ButtonList);
				$("#MyModal").modal('show');
				$("[name=DateReturnedFrom], [name=DateReturnedTo]").datepicker({
					changeYear	:	true,
					changeMonth	:	true,
					maxDate		:	0	
				});
			}
			
			});
			
			
            
            return false;
            
		});
	});
	
	function Search(){
		showPage(1);
		return false
	}
	function showPage(page){
		
		var serialize = $("[name = search_parameter]").serialize()+"&action=GetDriverSchedule&page="+page
		
		
		$.ajax({
			type	:	"post",
			dataType:	"json",
			url		:	"pages/operation/ajax/driverschedulemodule.php",
			// data	:	{action : "GetDriverSchedule", page : page},
			data	:	serialize,
			success	:	function(data){
				$("#DriversScheduleModule .table-responsive").html(data.Details);
				// alert(data.Pagination);
				$("#DriversScheduleModule .panel-footer").html(data.Pagination);
			}
		});
		
	}
	
	function AddDriverSchedule(){
		
		$.ajax({
			type	:	"post",
			url		:	"pages/operation/ajax/driverschedulemodule.php",
			data	:	{action : "AddDriverSchedule"},
			success	:	function(data){
				var ButtonList = '<button type="button" class="btn btn-success" onclick="return SaveNewDriverSchedule();">Save</button>';
				ButtonList += '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
				
				$("#MyModal .modal-dialog").removeClass("modal-sm").removeClass("modal-lg").addClass("modal-md");
				$("#MyModal .modal-title").html("Add Driver Schedule");
				$("#MyModal .modal-footer").html(ButtonList);
				$("#MyModal .modal-body").html(data);
				$("#MyModal").modal('show');
				
				$("[name=DateFrom], [name=DateTo]").datepicker({
					changeYear : true,
					changeMonth: true,
					minDate	   : new Date()
				});
				
				$('[name=AddDriverScheduleForm]').find('[name=DLID]').focus();
			}
		});
		
	}
	
	function CheckDLID(field, e){
	
		var DLID = $(field).val();
		
		if(e.which == 13 || e.which == 9){
			$.ajax({
				type	:	"post",
				dataType:	"json",
				url		:	"pages/operation/ajax/driverschedulemodule.php",
				data	:	{action : "CheckDLID", DLID : DLID},
				success	:	function(data){
					if(data.Success == 0){
						$('[name=AddDriverScheduleForm]').find('.alert').html(data.ErrorMessage);
						$('[name=AddDriverScheduleForm]').find('.alert').show();
						$('[name=AddDriverScheduleForm]').find('[name=DLID]').val('').focus();
					}else{
						$('[name=AddDriverScheduleForm]').find('.alert').html('');
						$('[name=AddDriverScheduleForm]').find('.alert').hide();
					}
				}
			});
		}
		
	}
	
	function SaveNewDriverSchedule(){
		
		if($("[name=AddDriverScheduleForm]").find("[name=DLID]").val().trim() == ""){
			$("#MyModal .modal-body").find(".alert").addClass("alert-danger");
			$("#MyModal .modal-body").find(".alert").html("Please insert Demand Letter ID.");
			$("#MyModal .modal-body").find(".alert").show();
			$("[name=AddDriverScheduleForm]").find("[name=DLID]").focus();
			return false;
		}
		
		if($("[name=AddDriverScheduleForm]").find("[name=DateFrom]").val() == ""){
			$("#MyModal .modal-body").find(".alert").addClass("alert-danger");
			$("#MyModal .modal-body").find(".alert").html("Please select Date From.");
			$("#MyModal .modal-body").find(".alert").show();
			$("[name=AddDriverScheduleForm]").find("[name=DateFrom]").focus();
			return false;
		}
		
		if($("[name=AddDriverScheduleForm]").find("[name=DateTo]").val().trim() == ""){
			$("#MyModal .modal-body").find(".alert").addClass("alert-danger");
			$("#MyModal .modal-body").find(".alert").html("Please select Date To.");
			$("#MyModal .modal-body").find(".alert").show();
			$("[name=AddDriverScheduleForm]").find("[name=DateTo]").focus();
			return false;
		}
		
		if($("[name=AddDriverScheduleForm]").find("[name=Driver]").val().trim() == ""){
			$("#MyModal .modal-body").find(".alert").addClass("alert-danger");
			$("#MyModal .modal-body").find(".alert").html("Please select Driver.");
			$("#MyModal .modal-body").find(".alert").show();
			$("[name=AddDriverScheduleForm]").find("[name=Driver]").focus();
			return false;
		}
		
		$.ajax({
			
			type	:	"post",
			dataType:	"json",
			url		:	"pages/operation/ajax/driverschedulemodule.php",
			data	:	$("[name=AddDriverScheduleForm]").serialize() + "&action=SaveDriverSchedule",
			success	:	function(data){
				if(data.Success == 1){
					alert("Schedule has been assigned to driver.");
					location.reload();
				}
			}
		});
		
	}
	
	function PrintSchedule(){
		
		$.ajax({
			type	:	"post",
			url		:	"pages/operation/ajax/driverschedulemodule.php",
			data	:	{action : "PrintDriverSchedule"},
			success	:	function(data){
				var ButtonList = '<button type="button" class="btn btn-success" onclick="return PrintDriverSchedule();">Print</button>';
				ButtonList += '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
				
				$("#MyModal .modal-dialog").removeClass("modal-sm").removeClass("modal-lg").addClass("modal-md");
				$("#MyModal .modal-title").html("Print Driver Schedule");
				$("#MyModal .modal-footer").html(ButtonList);
				$("#MyModal .modal-body").html(data);
				$("#MyModal").modal('show');
				
				$("[name=PrintDriverScheduleForm]").find("[name=DateFrom], [name=DateTo]").datepicker({
					changeYear : true,
					changeMonth: true,
				});
			}
		});
		
	}
	
	function TransferSchedule(){
		
		$.ajax({
			type	:	"post",
			url		:	"pages/operation/ajax/driverschedulemodule.php",
			data	:	{action : "TransferSchedule"},
			success	:	function(data){
				var ButtonList = '<button type="button" class="btn btn-success" onclick="return SaveTransferSchedule();">Save</button>';
				ButtonList += '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
				
				$("#MyModal .modal-dialog").removeClass("modal-sm").removeClass("modal-lg").addClass("modal-md");
				$("#MyModal .modal-title").html("Transfer Schedule");
				$("#MyModal .modal-footer").html(ButtonList);
				$("#MyModal .modal-body").html(data);
				$("#MyModal").modal('show');
				
				$("[name=PrintDriverScheduleForm]").find("[name=DateFrom], [name=DateTo], [name=UpdateDateFrom], [name=UpdateDateTo]").datepicker({
					changeYear : true,
					changeMonth: true,
				});
			}
		});
		
	}
	
	function PrintDriverSchedule(){
		
		if($("[name=PrintDriverScheduleForm]").find("[name=Driver]").val().trim() == ""){
			$("#MyModal .modal-body").find(".alert").addClass("alert-danger");
			$("#MyModal .modal-body").find(".alert").html("Please select Driver.");
			$("#MyModal .modal-body").find(".alert").show();
			$("[name=AddDriverScheduleForm]").find("[name=Driver]").focus();
			return false;
		}
		
		if($("[name=PrintDriverScheduleForm]").find("[name=DateFrom]").val().trim() == ""){
			$("#MyModal .modal-body").find(".alert").addClass("alert-danger");
			$("#MyModal .modal-body").find(".alert").html("Please select Date From.");
			$("#MyModal .modal-body").find(".alert").show();
			$("[name=AddDriverScheduleForm]").find("[name=DateFrom]").focus();
			return false;
		}
		
		if($("[name=PrintDriverScheduleForm]").find("[name=DateTo]").val().trim() == ""){
			$("#MyModal .modal-body").find(".alert").addClass("alert-danger");
			$("#MyModal .modal-body").find(".alert").html("Please select Date To.");
			$("#MyModal .modal-body").find(".alert").show();
			$("[name=AddDriverScheduleForm]").find("[name=DateTo]").focus();
			return false;
		}
		
		var url = "pages/operation/pdf/DriverSchedule.php";
		var data = $("[name=PrintDriverScheduleForm]").serialize();
		print_pdf(url, data);
		
		$("#MyModal").modal('hide');
		
	}
	
	function SaveTransferSchedule(){
		if($("[name=PrintDriverScheduleForm]").find("[name=Driver]").val().trim() == ""){
			$("#MyModal .modal-body").find(".alert").addClass("alert-danger");
			$("#MyModal .modal-body").find(".alert").html("Please select Driver.");
			$("#MyModal .modal-body").find(".alert").show();
			$("[name=AddDriverScheduleForm]").find("[name=Driver]").focus();
			return false;
		}
		
		if($("[name=PrintDriverScheduleForm]").find("[name=DateFrom]").val().trim() == ""){
			$("#MyModal .modal-body").find(".alert").addClass("alert-danger");
			$("#MyModal .modal-body").find(".alert").html("Please select Date From.");
			$("#MyModal .modal-body").find(".alert").show();
			$("[name=AddDriverScheduleForm]").find("[name=DateFrom]").focus();
			return false;
		}
		
		if($("[name=PrintDriverScheduleForm]").find("[name=DateTo]").val().trim() == ""){
			$("#MyModal .modal-body").find(".alert").addClass("alert-danger");
			$("#MyModal .modal-body").find(".alert").html("Please select Date To.");
			$("#MyModal .modal-body").find(".alert").show();
			$("[name=AddDriverScheduleForm]").find("[name=DateTo]").focus();
			return false;
		}
		
		if($("[name=PrintDriverScheduleForm]").find("[name=TransferDriver]").val().trim() == ""){
			$("#MyModal .modal-body").find(".alert").addClass("alert-danger");
			$("#MyModal .modal-body").find(".alert").html("Please select Date To.");
			$("#MyModal .modal-body").find(".alert").show();
			$("[name=AddDriverScheduleForm]").find("[name=DateTo]").focus();
			return false;
		}
		
		//var url = "pages/operation/pdf/DriverSchedule.php";
		//var data = $("[name=PrintDriverScheduleForm]").serialize();
		//print_pdf(url, data);
		//
		//$("#MyModal").modal('hide');
		var serialize = $("[name=PrintDriverScheduleForm]").serialize()+"&action=SaveTransfer";
		$.ajax({
			type	:	"post",
			dataType:	"json",
			url		:	"pages/operation/ajax/driverschedulemodule.php",
			data	:	serialize,
			success:function(resp){
				alert(resp['ErrorMessage']);
				showPage(1);
				$("#MyModal").modal('hide');
			}
			
		})
		
	}
	
	function print_pdf(url, data){
	
        var myWindow = window.open(url+"?"+data,"windowOpenTab", 'scrollbars=1,resizable=1,width='+window.outerWidth+',height='+window.outerHeight+',left=0,top=0');
        return false;
    
	}
	
	function PrintFieldListingxls()
	{
		//$("[name=FieldListingForm]").serialize()+"&action=fieldlisting";
		$("[name=FieldListingForm]").attr("method","post");
		$("[name=FieldListingForm]").attr("action",'pages/supervisor/ajax/report.php?action=fieldlistingexporttoxls');
		$("[name=FieldListingForm]").attr("target","TheWindow");
		window.open('','_blank', 'scrollbars=1,left=0,top=0');
		$("[name=FieldListingForm]").submit();
		
		
	}
	
    function PFDP()
    {
        
        var ButtonList = '<button type="button" class="btn btn-info" onclick="PrintDriver();">Print</button>'+
								 '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
        
        
        
        $.ajax({
			type	:	"post",
			url		:	"pages/supervisor/ajax/listingdemandletter.php",
			//data	:	{action : "DemandLetterTypeForm", DLID : ID},
			data	:	{action : "GetParametersField"},
			success	:	function(data){
                $("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-md");
                $("#MyModal .modal-title").html("Field Daily Prod Report Parameters");
                $("#MyModal .modal-body").html(data);
                $("#MyModal .modal-footer").html(ButtonList);
                $("#MyModal").modal('show');

                $("[name=DateFrom]").datepicker({
                    changeYear	:	true,
                    changeMonth	:	true
                    //maxDate		:	0	
                });

                $("[name=DateTo]").datepicker({
                    changeYear	:	true,
                    changeMonth	:	true
                    //maxDate		:	0	
                });

            }
        })
        
        return false;
    }
    
    function PrintDriver(){
        var data = "action=Printdriverdailyprod";
        $("[name=parameterfield]").attr("method","post");
		$("[name=parameterfield]").attr("action","pages/supervisor/ajax/report.php?"+data);
		$("[name=parameterfield]").attr("target","TheWindow");
		window.open('','TheWindow', 'scrollbars=1,resizable=1,width='+window.outerWidth+',height='+window.outerHeight+',left=0,top=0');
		
		$("[name=parameterfield]").submit();
		
		
        // var myWindow = window.open(url+"?"+data,"windowOpenTab", 'scrollbars=1,resizable=1,width='+window.outerWidth+',height='+window.outerHeight+',left=0,top=0');
        return false;
    }
    
    function addstatus(ID)
    {
        
        $.ajax({
			type	:	"post",
			url		:	"pages/operation/ajax/driverschedulemodule.php",
			//data	:	{action : "DemandLetterTypeForm", DLID : ID},
			data	:	{action : "ShowDetailsRemarkStatus",ID:ID},
			success	:	function(data){
			
				var ButtonList = '<button type="button" class="btn btn-info" onclick="StatusSave('+ID+');">Save</button>'+
								 '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
				$("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-lg");
				$("#MyModal .modal-title").html("Status Remarks");
				$("#MyModal .modal-body").html(data);
				$("#MyModal .modal-footer").html(ButtonList);
                
				$("#MyModal").modal('show');
				
			}
        
        
        
    
    })
        
    }
    
    function StatusSave(ID){
        
        var error_cnt = 0,error_msg = "";
        if($("[name=DriverRemarks]").val()==""){
            error_msg += "Remarks Required. \n";
            error_cnt++;
            
        }
        
        if(error_cnt > 0){
            alert(error_msg);
            return false;
        }
        
        
        if(confirm("are you sure want to save this status?") == true){
            
            $.ajax({
			type	:	"post",
			url		:	"pages/operation/ajax/driverschedulemodule.php",
			//data	:	{action : "DemandLetterTypeForm", DLID : ID},
			data	:	$("[name=FormDriverStatus]").serialize()+"&action=driversavestatus&ID="+ID+"&lati="+lati+"&long="+long,
			success	:	function(data){
			
			  showPage(1);
              $("#MyModal").modal('hide');
			}
            })
            
            
            
            
            
           
        }
        return false;
    }
</script>
