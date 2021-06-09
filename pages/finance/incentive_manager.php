
<div id="wrapper">
	<div id="page-wrapper">
        <div id="listingmediaserver">
    
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Management Incentives</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
			<div class="row" id="CollectorsTable">
				<div class="panel panel-primary">
					<div class="panel-heading">
								Parameter
					</div>
						<form name = "search_form_parameter">
						<div class="panel-body">
							<div class="col-sm-6">
									
									<div class="form-group" style="margin-right:10px;">
										<label class="control-label">ID Number : </label>
										<input name="employee_id" class="form-control input-sm" placeholder="[123]" value ="" />
									</div>
									
									<div class="form-group" style="margin-right:10px;">
										<label class="control-label">Last Name : </label>
										<input name="last_name" class="form-control input-sm" placeholder="[sample]" value ="" />
									</div>
									<div class="form-group" style="margin-right:10px;">
										<label class="control-label">Position : </label>
										<input name="position" class="form-control input-sm" placeholder="[]" value ="" />
									</div>
							</div>
							<div class="col-sm-6">
									<div class="form-group" style="margin-right:10px;">
										<label class="control-label">Account : </label>
										<input name="account" class="form-control input-sm" placeholder="[123]" value ="" />
									</div>
								
									<div class="form-group" style="margin-right:10px;">
										<label class="control-label">Branch : </label>
										<input name="branch" class="form-control input-sm" placeholder="[123]" value ="" />
									</div>
							</div>
						</div>
						</form>
				</div>
				
				<div class="col-lg-12" style="padding-bottom:5px;">
					<button class="btn btn-danger btn-xl" name="search">
						<span class="fa fa-search fa-fw"></span>
						Search
					</button>
					<button class="btn btn-danger btn-xl" name="AddCollector">
						<span class="fa fa-users fa-fw"></span>
						Add manager
					</button>
					<button class="btn btn-danger btn-xl" name="UploadEmployees">
						<span class="fa fa-plus fa-file"></span>
						Uploader
					</button>
					<button class="btn btn-danger btn-xl" name="PrintReports" onclick = "return PrintReports();">
						<span class="fa fa-file fa-fw"></span>
						Reports
					</button>
					<button class="btn btn-danger btn-xl" name="GeneratePayslip" onclick = "return GeneratePayslip();">
						<span class="fa fa-file fa-fw"></span>
						Generate payslips
					</button>
					<button class="btn btn-danger btn-xl" name="GeneratePayslip" onclick = "return GeneratePayslip();">
						<span class="fa fa-plus fa-fw"></span>
						Sample payslips
					</button>
				</div>
				
				<div class="col-lg-12">
					
					<div class="panel panel-primary">
					
						<div class="panel-heading">Information</div>
						<div class="panel-footer"> 
							<ul class="pagination" style="margin:0;"></ul>
						</div>
                        <div class="table-responsive">
							<table id = "fetch_data" class="table table-striped table-bordered table-hover">
								<td align="center">Loading... Please wait...</td>
							</table>
						</div>
						
						<div class="panel-footer"> 
							<ul class="pagination" style="margin:0;"></ul>
						</div>
					
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>
<script>
	$(function(){ 
		$("[name=AddCollector]").click(function(){
			//location.href="index.php?PageID=AC";
            //alert('x');
            $.ajax({
			type	:	"post",
			url		:	"pages/finance/ajax/proccess.php",
			//data	:	{action : "DemandLetterTypeForm", DLID : ID},
			data	:	{action : "Add", page : 1, Table : 'manager'},
			success	:	function(data){
                var ButtonList = '<button type="button" class="btn btn-info" onclick="doSave();">Save</button>'+
								 '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
				    $("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-lg");
				    $("#MyModal .modal-title").html("Add manager");
				    $("#MyModal .modal-body").html(data);
				    $("#MyModal .modal-footer").html(ButtonList);
				    $("#MyModal").modal('show');
                    
                    $('.datepicker').datepicker({
                        //changeMonth: true,
			            //changeYear: true,
                        //dateFormat: 'yy-mm-dd',
                        //yearRange: "1000:<?=date("Y");?>"
                    
                    });
            }
            });
			
			
            
            
		});
		$("[name=search]").click(function(){
			showPage(1);
		});
        
        $("[name=UploadEmployees]").click(function(){
			//location.href="index.php?PageID=AC";
            //alert('x');
            $.ajax({
			type	:	"post",
			url		:	"pages/finance/ajax/proccess.php",
			//data	:	{action : "DemandLetterTypeForm", DLID : ID},
			data	:	{action : "Upload", page : 1, Table : 'manager'},
			success	:	function(data){
                var ButtonList = '<button type="button" class="btn btn-info" onclick="doUpload();">Save</button>'+
								 '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
				    $("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-lg");
				    $("#MyModal .modal-title").html("Upload manager");
				    $("#MyModal .modal-body").html(data);
				    $("#MyModal .modal-footer").html(ButtonList);
				    $("#MyModal").modal('show');
                    
                    $('.datepicker').datepicker({
                        //changeMonth: true,
			            //changeYear: true,
                        //dateFormat: 'yy-mm-dd',
                        //yearRange: "1000:<?=date("Y");?>"
                    
                    });
            }
            })
            
            
		});
		
		showPage(1);
	});
	
	function AddLeaves(id){
			//location.href="index.php?PageID=AC";
            //alert('x');
            $.ajax({
			type	:	"post",
			url		:	"pages/finance/ajax/proccess.php",
			//data	:	{action : "DemandLetterTypeForm", DLID : ID},
			data	:	{action : "Leave_Add", page : 1, Table : 'employee_leaves'},
			success	:	function(data){
                var ButtonList = '<button type="button" class="btn btn-info" onclick="doAddLeaves('+id+');">Save</button>'+
								 '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
				    $("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-lg");
				    $("#MyModal .modal-title").html("Upload manager");
				    $("#MyModal .modal-body").html(data);
				    $("#MyModal .modal-footer").html(ButtonList);
				    $("#MyModal").modal('show');
                    
                    $('.datepicker').datepicker({
                        //changeMonth: true,
			            //changeYear: true,
                        //dateFormat: 'yy-mm-dd',
                        //yearRange: "1000:<?=date("Y");?>"
                    
                    });
            }
            })
	}
	
	
	function Edit(id){
		$.ajax({
			type	:	"post",
			url		:	"pages/finance/ajax/proccess.php",
			//data	:	{action : "DemandLetterTypeForm", DLID : ID},
			data	:	{action : "Edit", page : 1, Table : 'manager',id:id},
			success	:	function(data){
                var ButtonList = '<button type="button" class="btn btn-info" onclick="doUpdate('+id+');">Save</button>'+
								 '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
				    $("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-lg");
				    $("#MyModal .modal-title").html("View / Edit manager");
				    $("#MyModal .modal-body").html(data);
				    $("#MyModal .modal-footer").html(ButtonList);
				    $("#MyModal").modal('show');
                    
                    $('#datepicker').datepicker({
                        //changeMonth: true,
			            //changeYear: true,
                        //dateFormat: 'yy-mm-dd',
                        //yearRange: "1000:<?=date("Y");?>"
                    
                    });
            }
        })
	}
	
	
	function AddIncentiveBank(id){
		$.ajax({
			type	:	"post",
			url		:	"pages/finance/ajax/proccess.php",
			//data	:	{action : "DemandLetterTypeForm", DLID : ID},
			data	:	{action : "ADdIncentiveBank", page : 1, Table : 'manager_incentive_bank_percent',id:id},
			success	:	function(data){
                var ButtonList = '<button type="button" class="btn btn-info" onclick="doUpdate('+id+');">Save</button>'+
								 '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
				    $("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-lg");
				    $("#MyModal .modal-title").html("View / Edit manager");
				    $("#MyModal .modal-body").html(data);
				    $("#MyModal .modal-footer").html(ButtonList);
				    $("#MyModal").modal('show');
                    
                    $('#datepicker').datepicker({
                        //changeMonth: true,
			            //changeYear: true,
                        //dateFormat: 'yy-mm-dd',
                        //yearRange: "1000:<?=date("Y");?>"
                    
                    });
            }
        })
	}
	
	function ViewDTR(id){
		
		$.ajax({
			type	:	"post",
			url		:	"pages/finance/ajax/proccess.php",
			//data	:	{action : "DemandLetterTypeForm", DLID : ID},
			data	:	{DateFrom:$("[name=Date_From]").val(),DateTo:$("[name=Date_To]").val(),action : "ViewDTR", page : 1, Table : 'timeinout',id:id},
			success	:	function(data){
                var ButtonList = '<button type="button" class="btn btn-info" onclick="ViewDTR('+id+');">Search</button>'+
								'<button type="button" class="btn btn-primary" onclick="SasveDTR('+id+');">Save</button>'+
								 '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
				    $("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-lg");
				   
        			$("#MyModal .modal-title").html("View DTR");
					
				    $("#MyModal .modal-body").html(data);
				    $("#MyModal .modal-footer").html(ButtonList);
				    $("#MyModal").modal('show');
                    
                    $('.datepicker').datepicker({
                        //changeMonth: true,
			            //changeYear: true,
                        //dateFormat: 'yy-mm-dd',
                        //yearRange: "1000:<?=date("Y");?>"
                    
                    });
            }
        })
	}
	
	
	function SasveDTR(id){
		if(confirm("are you sure want to save this Overtime?") == true){
			var serialize = $("[name=DTRForm]").serialize()+"&Table=timeinout&action=savetimeinoutOT";
			$.ajax({
				type	:	"post",
				url		:	"pages/finance/ajax/proccess.php",
				dataType:	"json",
				data	:	serialize,
				// data	:	{action : "Pagination", page : page, Table : 'manager'},
				success	:	function(data){
					ViewDTR(id);
				}
			});
		}
		return false;
	}
	
	function showPage(page){
		var serialize = $("[name=search_form_parameter]").serialize()+"&action=Pagination&page="+page+"&Table=manager";
		$.ajax({
			type	:	"post",
			url		:	"pages/finance/ajax/proccess.php",
			dataType:	"json",
			data	:	serialize,
			// data	:	{action : "Pagination", page : page, Table : 'manager'},
			success	:	function(data){
				$("#CollectorsTable .table-responsive").html(data.Details);
				$("#CollectorsTable .panel-footer .pagination").html(data.Pagination);
			}
		});
	}
    
    function doSave()
    {
        if(confirm("Are you sure want to save?")==true){
            $.ajax({
			type	:	"post",
			url		:	"pages/finance/ajax/proccess.php",
			dataType:	"json",
			//data	:	{action : "Pagination", page : page, Table : 'manager'},
			data	:	$("[name=AddEmployee]").serialize()+"&action=Save&Table=manager",
			success	:	function(data){
                $("#MyModal").modal('hide');
                showPage(1);
			}
		  });
        }
    }
    function doAddLeaves(id)
    {
        if(confirm("Are you sure want to save?")==true){
            $.ajax({
			type	:	"post",
			url		:	"pages/finance/ajax/proccess.php",
			dataType:	"json",
			//data	:	{action : "Pagination", page : page, Table : 'manager'},
			data	:	$("[name=AddEmployee]").serialize()+"&action=Save&employee_id="+id+"&Table=employee_leaves",
			success	:	function(data){
                $("#MyModal").modal('hide');
                showPage(1);
			}
		  });
        }
    }
    
    function doUpdate(id)
    {
        if(confirm("Are you sure want to update?")==true){
            $.ajax({
			type	:	"post",
			url		:	"pages/finance/ajax/proccess.php",
			//dataType:	"json",
			//data	:	{action : "Pagination", page : page, Table : 'manager'},
			data	:	$("[name=AddEmployee]").serialize()+"&action=Update&Table=manager&id="+id,
			success	:	function(data){
				 $("#MyModal").modal('hide');
                 showPage(1);
			} 
		  });
        }
       
        
    }
    
    function doUpload()
    {
        var files = $("[name=FileToUpload]").prop("files")[0];
			
			var data = new FormData();
			data.append("file", files);
			data.append("Selection", $("[name=Selection]").val());
			data.append("DateUploaded", $("[name=DateUploaded]").val());
			data.append("action", "UploadDataEmployee");
			data.append("table", "manager");
			
			$.ajax({
				
				type	:	"post",
				dataType:	"json",
				data	:	data,
				url		:	"pages/finance/ajax/proccess.php",
				cache	:	false,
				processData:false,
				contentType:false,
				success	:	function(data){
					$(".Error-Message-Box").find(".alert").removeClass("alert-success").removeClass("alert-info").addClass("alert-danger");
					
					if(data.Success == 1){
						$("[name=DateUploaderForm]")[0].reset();
						$(".Error-Message-Box").find(".alert").removeClass("alert-danger").removeClass("alert-info").addClass("alert-success");
						$(".Error-Message-Box").find(".Error-Message").html(data.ErrorMessage);
					}else{
						$(".Error-Message-Box").show();
						$(".Error-Message-Box").find(".alert").removeClass("alert-danger").removeClass("alert-success").addClass("alert-info");
						$(".Error-Message-Box").find(".Error-Message").html(data.ErrorMessage);
					}
					
                    $("[name=DataUploader]").removeAttr("disabled","disabled");
				},
				beforeSend:	function(){
					
                    $("[name=DataUploader]").attr("disabled","disabled");
					$(".Error-Message-Box").show();
					$(".Error-Message-Box").find(".Error-Message").html("<img src = 'img/ajax-loader.gif'></img> loading... please wait..");
					//$(".Error-Message-Box").find(".Error-Message").html("Loading... Please wait...");
					$(".Error-Message-Box").find(".alert").removeClass("alert-danger").removeClass("alert-success").addClass("alert-info");
					
				}
				
			});
    }
    
    function GeneratePayslip()
    {
        
        
        var ButtonList = '<button type="button" class="btn btn-info" onclick="return doGenerate();">Print All Employees</button>'+
								 '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
				    $("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-lg");
				    $("#MyModal .modal-title").html("Generate Payslip");
				    
					
					
		var html = '<div class="row" id="rowCrossCheckValidation">'+
			'<div class="col-lg-12">'+
			'	<div class="panel panel-red">'+
			'		<div class="panel-heading">'+
			'			Parameter'+
			'		</div>'+
			'		 <form class="form-horizontal" role="form" name="generate_payslip" enctype="multipart/form-data">'+
			'			<div class="panel-body">'+
			'				<label>Date From</label>'+
			'				<div class="form-group"><input type="text" name="date_from" class="form-control " value="" />'+
			'				</div>'+
			'				<div class="form-group"><label>Date To</label>'+
			'				<input type="text" name="date_to" class="form-control " value="" /></div>'+
			'			</div>'+
			'		</form>'+
			'	</div>'+
			'</div>'+
			'</div>';
				
				
					
					
					$("#MyModal .modal-body").html(html);
				    $("#MyModal .modal-footer").html(ButtonList);
				    $("#MyModal").modal('show');
        
                    $("[name=date_from],[name=date_to]").datepicker();
        return false;
    }
    
    function doGenerate()
    {
        
        if(confirm("are you sure want to generate payslip?") == true){
               window.open('generate_payslip.php?datefrom='+$("[name=date_from]").val()+'&dateto='+$("[name=date_to]").val(),'_blank', 'scrollbars=1,resizable=1,width='+window.outerWidth+',height='+window.outerHeight+',left=0,top=0');
			
			//$.ajax({
			//	
			//	type	:	"post",
			//	dataType:	"json",
			//	data	:	{action:"generatepayslip",c:$("[name=date_from]").val(),date_to:$("[name=date_to]").val()},
			//	url		:	"pages/finance/ajax/proccess.php",
			//	success	:	function(data){
            //        alert(data['message']);
            //        $("#MyModal").modal('hide');
            //    }
            //});
        }
        return false;
    }
    
    //function GeneratePayslip()
    //{
    
    //}
</script>
