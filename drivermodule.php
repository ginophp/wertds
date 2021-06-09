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
					
					<div style="padding-bottom:10px;">
                        <select class = "form-control" name = "DriversGroup">
                            <option value = "">[SELECT HERE]</option>
                            <?php
                                $q = $mysqli->query("select * from drivergroup");
                                if($q->num_rows){
                                    while($r = $q->fetch_object()){
                                        echo "<option value = '{$r->Code}'>{$r->Description}</option>";
                                    }
                                }
                            ?>
                        </select>
					</div>
					<div style="padding-bottom:10px;">
						<button class='btn btn-danger' onclick="return AddDriver();">Add Driver</button>
					</div>
					<div class="panel panel-primary" id="DriversModule">
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
		showPage(1);
        $("[name=DriversGroup]").change(function(){
            showPage(1);
        })
	});
	
	function showPage(page){
		//alert(page);
		$.ajax({
			type	:	"post",
			dataType:	"json",
			url		:	"pages/operation/ajax/drivermodule.php",
			data	:	{action : "GetDriverList", page : page,DriversGroup:$("[name=DriversGroup]").find(":selected").val()},
			success	:	function(data){
				$("#DriversModule .table-responsive").html(data.Details);
				$("#DriversModule .panel-footer").html(data.Pagination);
			}
		});
		
        return false;
	}
	
	function AddDriver(){
		
		$.ajax({
			type	:	"post",
			url		:	"pages/operation/ajax/drivermodule.php",
			data	:	{action : "AddNewDriver"},
			success	:	function(data){
				var ButtonList = '<button type="button" class="btn btn-success" onclick="return SaveNewDriver();">Save</button>';
				ButtonList += '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
								
				$("#MyModal .modal-dialog").removeClass("modal-sm").removeClass("modal-lg").addClass("modal-md");
				$("#MyModal .modal-title").html("Add New Driver");
				$("#MyModal .modal-footer").html(ButtonList);
				$("#MyModal .modal-body").html(data);
				$("#MyModal").modal('show');
				
				var today = new Date();
				
				$('[name=AddNewDriverForm]').find('[name=BirthDate]').datepicker({
					changeYear : true,
					changeMonth: true,
					yearRange  : (today.getFullYear() - 100) + ":" + today.getFullYear()
				});
			}
		});
		
	}
	
	function SaveNewDriver(){
		
		if($("[name=AddNewDriverForm]").find("[name=FullName]").val().trim() == ""){
			$("#MyModal .modal-body").find(".alert").addClass("alert-danger");
			$("#MyModal .modal-body").find(".alert").html("Please insert Full Name.");
			$("#MyModal .modal-body").find(".alert").show();
			$("[name=AddNewDriverForm]").find("[name=FullName]").focus();
			return false;
		}
		
		if($("[name=AddNewDriverForm]").find("[name=Gender]").val() == ""){
			$("#MyModal .modal-body").find(".alert").addClass("alert-danger");
			$("#MyModal .modal-body").find(".alert").html("Please select Gender.");
			$("#MyModal .modal-body").find(".alert").show();
			$("[name=AddNewDriverForm]").find("[name=Gender]").focus();
			return false;
		}
		
		if($("[name=AddNewDriverForm]").find("[name=BirthDate]").val().trim() == ""){
			$("#MyModal .modal-body").find(".alert").addClass("alert-danger");
			$("#MyModal .modal-body").find(".alert").html("Please insert Birth Date.");
			$("#MyModal .modal-body").find(".alert").show();
			$("[name=AddNewDriverForm]").find("[name=BirthDate]").focus();
			return false;
		}
		
		$.ajax({
			
			type	:	"post",
			dataType:	"json",
			url		:	"pages/operation/ajax/drivermodule.php",
			data	:	$("[name=AddNewDriverForm]").serialize() + "&action=SaveNewDriver",
			success	:	function(data){
				if(data.Success == 1){
					alert("New driver has been added.");
					location.reload();
				}
			}
		});
		
	}
	
	function EditDriver(DRCode){
		$.ajax({
			type	:	"post",
			url		:	"pages/operation/ajax/drivermodule.php",
			data	:	{action : "EditDriver", DRCode : DRCode},
			success	:	function(data){
				var ButtonList = '<button type="button" class="btn btn-success" onclick="return UpdateDriver(\''+DRCode+'\');">Save</button>';
				ButtonList += '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
								
				$("#MyModal .modal-dialog").removeClass("modal-sm").removeClass("modal-lg").addClass("modal-md");
				$("#MyModal .modal-title").html("Update Driver");
				$("#MyModal .modal-footer").html(ButtonList);
				$("#MyModal .modal-body").html(data);
				$("#MyModal").modal('show');
				
				$('[name=EditDriverForm]').find('[name=BirthDate]').datepicker({
					changeYear : true,
					changeMonth: true,
					yearRange  : (today.getFullYear() - 100) + ":" + today.getFullYear()
				});
			}
		});
	}
	
	function UpdateDriver(DRCode){
		
		if($("[name=EditDriverForm]").find("[name=FullName]").val().trim() == ""){
			$("#MyModal .modal-body").find(".alert").addClass("alert-danger");
			$("#MyModal .modal-body").find(".alert").html("Please insert Full Name.");
			$("#MyModal .modal-body").find(".alert").show();
			$("[name=EditDriverForm]").find("[name=FullName]").focus();
			return false;
		}
		
		if($("[name=EditDriverForm]").find("[name=Gender]").val() == ""){
			$("#MyModal .modal-body").find(".alert").addClass("alert-danger");
			$("#MyModal .modal-body").find(".alert").html("Please select Gender.");
			$("#MyModal .modal-body").find(".alert").show();
			$("[name=EditDriverForm]").find("[name=Gender]").focus();
			return false;
		}
		
		if($("[name=EditDriverForm]").find("[name=BirthDate]").val().trim() == ""){
			$("#MyModal .modal-body").find(".alert").addClass("alert-danger");
			$("#MyModal .modal-body").find(".alert").html("Please insert Birth Date.");
			$("#MyModal .modal-body").find(".alert").show();
			$("[name=EditDriverForm]").find("[name=BirthDate]").focus();
			return false;
		}
		
		if($("[name=EditDriverForm]").find("[name=Status]").val().trim() == ""){
			$("#MyModal .modal-body").find(".alert").addClass("alert-danger");
			$("#MyModal .modal-body").find(".alert").html("Please insert Birth Date.");
			$("#MyModal .modal-body").find(".alert").show();
			$("[name=EditDriverForm]").find("[name=Status]").focus();
			return false;
		}
		
		$.ajax({
			
			type	:	"post",
			dataType:	"json",
			url		:	"pages/operation/ajax/drivermodule.php",
			data	:	$("[name=EditDriverForm]").serialize() + "&action=UpdateDriver&DRCode="+DRCode,
			success	:	function(data){
				if(data.Success == 1){
					alert("Driver has been updated.");
					location.reload();
				}
			}
		});
		
	}
    
    function AddDriverSchedule(DRCode){
		
		$.ajax({
			type	:	"post",
			url		:	"pages/operation/ajax/driverschedulemodule.php",
			data	:	{action : "AddDriverSchedule",Code:DRCode},
			success	:	function(data){
				var ButtonList = '<button type="button" class="btn btn-success" onclick="return SaveNewDriverSchedule();">Save</button>';
				ButtonList += '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
				
				$("#MyModal .modal-dialog").removeClass("modal-sm").removeClass("modal-lg").addClass("modal-md");
				$("#MyModal .modal-title").html("Add Field Schedule");
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

    function doAddMultipleSchedule(){
        if($("[name=MultipleDL]").val() == 0 || $("[name=MultipleDL]").val() == ""){
                $("[name=MultipleDL]").val(1);        
        }
        var html = "";
        for(var x = 1; $("[name=MultipleDL]").val() >= x; x++){
            html += "<label class='control-label col-sm-4'>DL Barcode # "+x+": </label><div class='col-sm-7'>"+
                "<input type='text' name='DLID"+x+"' class='form-control input-sm' onkeypress='return CheckDLID(this, event);' autofocus/>"+
                "</div>";
        }
        $(".MultipleDL").html(html);
        return false;
    }
    
    function CheckDLID(field, e){
	
		var DLID = $(field).val();
		var cnt = $(field).attr("name").replace("DLID", "");
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
						$('[name=AddDriverScheduleForm]').find('[name=DLID'+$(field).attr("name").replace("DLID", "")+']').val('').focus();
					}else{
                        cnt++;
                        $('[name=AddDriverScheduleForm]').find('[name=DLID'+cnt+']').focus();
						$('[name=AddDriverScheduleForm]').find('.alert').html('');
						$('[name=AddDriverScheduleForm]').find('.alert').hide();
					}
				}
			});
		}
		
	}
    
    
	function SaveNewDriverSchedule(){
		
        var MultipleDL = $("[name=MultipleDL]").val();
		
        if(MultipleDL == "" || MultipleDL == 0){
            MultipleDL = 1;
        }
        
        //for(var x =1; MultipleDL.length>=x;x++){
        //    if($("[name=AddDriverScheduleForm]").find("[name=DLID"+x+"]").val().trim() == ""){
        //        $("#MyModal .modal-body").find(".alert").addClass("alert-danger");
        //        $("#MyModal .modal-body").find(".alert").html("Please insert Demand Letter ID.");
        //        $("#MyModal .modal-body").find(".alert").show();
        //        $("[name=AddDriverScheduleForm]").find("[name=DLID"+x+"]").focus();
		//	     return false;
		//  }
        //}
        
		
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
			data	:	$("[name=AddDriverScheduleForm]").serialize() + "&action=SaveDriverSchedule&MultipleDL="+MultipleDL,
			success	:	function(data){
				if(data.Success == 1){
					alert("Schedule has been assigned to driver.");
					location.reload();
				}
			}
		});
		
	}
</script>