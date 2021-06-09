<div id="wrapper">
	<div id="page-wrapper">
        <div id="listingmediaserver">
    
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Spare Parts</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
			<div class="row" id="CollectorsTable">
				<div class="panel panel-primary">
					<div class="panel-heading">Parameter</div>
						<form name = "search_form_parameter">
						<div class="panel-body">
							<div class="col-sm-6">
									
									<div class="form-group" style="margin-right:10px;">
										<label class="control-label">PPE Type : </label>
										<input name="ppe_type" class="form-control input-sm" placeholder="[123]" value ="" />
									</div>
									
									<div class="form-group" style="margin-right:10px;">
										<label class="control-label">Property No : </label>
										<input name="Property_no" class="form-control input-sm" placeholder="[sample]" value ="" />
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
						<span class="fa fa-building-o fa-fw"></span>
						Add Spare Parts
					</button>
					<button class="btn btn-success btn-xl" name="RequestSpareLogs">
						<span class="fa fa-building-o fa-fw"></span>
						Request Spare Parts
					</button>
					<button class="btn btn-primary btn-xl" name="PurchaseRequest">
						<span class="fa fa-data-o fa-fw"></span>
						Purchase Request
					</button>
				</div>
				
				<div class="col-lg-12">
					
					<div class="panel panel-primary">
					
						<div class="panel-heading">Information</div>
						
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
			
            $.ajax({
			type	:	"post",
			url		:	"pages/hr/ajax/proccess.php",
			data	:	{action : "Add", page : 1, Table : 'spare_parts'},
			success	:	function(data){
                var ButtonList = '<button type="button" class="btn btn-info" onclick="doSave();">Save</button>'+
								 '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
				    $("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-lg");
				    $("#MyModal .modal-title").html("Add Spare Parts");
				    $("#MyModal .modal-body").html(data);
				    $("#MyModal .modal-footer").html(ButtonList);
				    $("#MyModal").modal('show');
                    
                    $('.datepicker').datepicker({
                        changeMonth: true,
			            changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        yearRange: "1000:<?=date("Y");?>"
                    
                    });
            }
            });
			
			
            
            
		});
		$("[name=RequestSpareLogs]").click(function(){
			
            $.ajax({
			type	:	"post",
			url		:	"pages/hr/ajax/proccess.php",
			data	:	{action : "Add", page : 1, Table : 'spare_parts_stock_logs',type:'out'},
			success	:	function(data){
                var ButtonList = '<button type="button" class="btn btn-info" onclick="doSaveRequestStock();">Save</button>'+
								 '<button type="button" class="btn btn-info" onclick="PrintIRS();">Print IRS</button>'+
								 '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
				    $("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-lg");
				    $("#MyModal .modal-title").html("Add Spare Parts");
				    $("#MyModal .modal-body").html(data);
				    $("#MyModal .modal-footer").html(ButtonList);
				    $("#MyModal").modal('show');
                    
                    $('.datepicker').datepicker({
                        changeMonth: true,
			            changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        yearRange: "1000:<?=date("Y");?>"
                    
                    });
            }
            });
			
			
            
            
		});
		
		$("[name=PurchaseRequest]").click(function(){
			
            $.ajax({
			type	:	"post",
			url		:	"pages/hr/ajax/proccess.php",
			data	:	{action : "Purchace_request", page : 1, Table : 'spare_parts',type:'out'},
			success	:	function(data){
                var ButtonList = '<button type="button" class="btn btn-info" onclick="doPurchaseRequest();">Generate</button>'+
								 '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
				    $("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-lg");
				    $("#MyModal .modal-title").html("Add Spare Parts");
				    $("#MyModal .modal-body").html(data);
				    $("#MyModal .modal-footer").html(ButtonList);
				    $("#MyModal").modal('show');
                    
                    $('.datepicker').datepicker({
                        changeMonth: true,
			            changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        yearRange: "1000:<?=date("Y");?>"
                    
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
			url		:	"pages/hr/ajax/proccess.php",
			//data	:	{action : "DemandLetterTypeForm", DLID : ID},
			data	:	{action : "Upload", page : 1, Table : 'spare_parts'},
			success	:	function(data){
                var ButtonList = '<button type="button" class="btn btn-info" onclick="doUpload();">Save</button>'+
								 '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
				    $("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-lg");
				    $("#MyModal .modal-title").html("Upload Employee");
				    $("#MyModal .modal-body").html(data);
				    $("#MyModal .modal-footer").html(ButtonList);
				    $("#MyModal").modal('show');
                    
                    $('.datepicker').datepicker({
                        changeMonth: true,
			            changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        yearRange: "1000:<?=date("Y");?>"
                    
                    });
            }
            })
            
            
		});
		
		showPage(1);
	});
	
	function PrintIRS(){
		
		var url = "pages/supply";
		$("[name=AddEmployee]").attr("method","post");
		$("[name=AddEmployee]").attr("action",url+'/pdf/letters/irs/irs.php');
		$("[name=AddEmployee]").attr("target","TheWindow");
		window.open('','TheWindow', 'scrollbars=1,resizable=1,width='+window.outerWidth+',height='+window.outerHeight+',left=0,top=0');
		
		$("[name=AddEmployee]").submit();
		
		
	}
	
	function doPurchaseRequest(){
		
		var url = "pages/supply";
		$("[name=AddEmployee]").attr("method","post");
		$("[name=AddEmployee]").attr("action",url+'/pdf/letters/irs/purchaserequest.php');
		$("[name=AddEmployee]").attr("target","TheWindow");
		window.open('','TheWindow', 'scrollbars=1,resizable=1,width='+window.outerWidth+',height='+window.outerHeight+',left=0,top=0');
		
		$("[name=AddEmployee]").submit();
		
		
	}
	
	
	function add_stock(id){
		
		$.ajax({
			type	:	"post",
			url		:	"pages/hr/ajax/proccess.php",
			data	:	{action : "Add", page : 1, Table : 'spare_parts_stock_logs',spare_parts:id},
			success	:	function(data){
                var ButtonList = '<button type="button" class="btn btn-info" onclick="doSavestcck();">Save</button>'+
								 '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
				    $("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-lg");
				    $("#MyModal .modal-title").html("Add Spare Parts");
				    $("#MyModal .modal-body").html(data);
				    $("#MyModal .modal-footer").html(ButtonList);
				    $("#MyModal").modal('show');
                    
                    $('.datepicker').datepicker({
                        changeMonth: true,
			            changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        yearRange: "1000:<?=date("Y");?>"
                    
                    });
            }
		});
		
	}
	
	function Edit(id){
		$.ajax({
			type	:	"post",
			url		:	"pages/hr/ajax/proccess.php",
			//data	:	{action : "DemandLetterTypeForm", DLID : ID},
			data	:	{action : "Edit", page : 1, Table : 'spare_parts',id:id},
			success	:	function(data){
                var ButtonList = '<button type="button" class="btn btn-info" onclick="doUpdate('+id+');">Save</button>'+
								 '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
				    $("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-lg");
				    $("#MyModal .modal-title").html("Edit Spare Parts");
				    $("#MyModal .modal-body").html(data);
				    $("#MyModal .modal-footer").html(ButtonList);
				    $("#MyModal").modal('show');
                    
                    $('#datepicker').datepicker({
                        changeMonth: true,
			            changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        yearRange: "1000:<?=date("Y");?>"
                    
                    });
            }
        })
	}
	
	function showPage(page){
		var serialize = $("[name=search_form_parameter]").serialize()+"&action=Pagination&page="+page+"&Table=spare_parts";
		$.ajax({
			type	:	"post",
			url		:	"pages/hr/ajax/proccess.php",
			dataType:	"json",
			data	:	serialize,
			// data	:	{action : "Pagination", page : page, Table : 'employee'},
			success	:	function(data){
				$("#CollectorsTable .table-responsive").html(data.Details);
				$("#CollectorsTable .panel-footer .pagination").html(data.Pagination);
			}
		});
	}
	
	
	function show_stocklogs(code)
	{
		
		$.ajax({
			type	:	"post",
			url		:	"pages/hr/ajax/proccess.php",
			//data	:	{action : "DemandLetterTypeForm", DLID : ID},
			data	:	{action : "Show Logs", page : 1, Table : 'spare_parts_stock_logs',code:code},
			success	:	function(data){
                var ButtonList = '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
				    $("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-lg");
				    $("#MyModal .modal-title").html("Logs Spare Parts");
				    $("#MyModal .modal-body").html(data);
				    $("#MyModal .modal-footer").html(ButtonList);
				    $("#MyModal").modal('show');
                    
                    $('#datepicker').datepicker({
                        changeMonth: true,
			            changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        yearRange: "1000:<?=date("Y");?>"
                    
                    });
            }
        })
		
		
		
	}
    
    function doSave()
    {
        if(confirm("Are you sure want to save?")==true){
            $.ajax({
			type	:	"post",
			url		:	"pages/hr/ajax/proccess.php",
			// dataType:	"json",
			// data	:	{action : "Pagination", page : page, Table : 'employee'},
			data	:	$("[name=AddEmployee]").serialize()+"&action=Save&Table=spare_parts",
			success	:	function(data){
                $("#MyModal").modal('hide');
                showPage(1);
			}
		  });
        }
    }
    function doSavestcck()
    {
        if(confirm("Are you sure want to save?")==true){
            $.ajax({
			type	:	"post",
			url		:	"pages/hr/ajax/proccess.php",
			// dataType:	"json",
			// data	:	{action : "Pagination", page : page, Table : 'employee'},
			data	:	$("[name=AddEmployee]").serialize()+"&action=Save&Table=spare_parts_stock_logs&type=in",
			success	:	function(data){
                $("#MyModal").modal('hide');
                showPage(1);
			}
		  });
        }
    }
    function doSaveRequestStock()
    {
        if(confirm("Are you sure want to save?")==true){
            $.ajax({
			type	:	"post",
			url		:	"pages/hr/ajax/proccess.php",
			// dataType:	"json",
			// data	:	{action : "Pagination", page : page, Table : 'employee'},
			data	:	$("[name=AddEmployee]").serialize()+"&action=Save&Table=spare_parts_stock_logs&type=out",
			success	:	function(data){
                // $("#MyModal").modal('hide');
                // showPage(1);
				alert("Successfuly added.");
				$("[name=AddEmployee]").find("input").each(function(){
					// alert($(this).attr("name"));
					if($(this).attr("name") != "ris_no"){
						$("[name="+$(this).attr("name")+"]").val("");
					}
				});
				
				$("[name=AddEmployee]").find("select").each(function(){
					// alert($(this).attr("name"));
					if($(this).attr("name") == "spare_parts"){
						$("[name="+$(this).attr("name")+"]").val("0");
					}
				});
			}
		  });
        }
    }
    
    function doUpdate(id)
    {
        if(confirm("Are you sure want to update?")==true){
            $.ajax({
			type	:	"post",
			url		:	"pages/hr/ajax/proccess.php",
			//dataType:	"json",
			//data	:	{action : "Pagination", page : page, Table : 'employee'},
			data	:	$("[name=AddEmployee]").serialize()+"&action=Update&Table=spare_parts&id="+id,
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
			data.append("table", "spare_parts");
			
			$.ajax({
				
				type	:	"post",
				dataType:	"json",
				data	:	data,
				url		:	"pages/hr/ajax/proccess.php",
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
        
        
        var ButtonList = '<button type="button" class="btn btn-info" onclick="return doGenerate();">Save</button>'+
								 '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
				    $("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-lg");
				    $("#MyModal .modal-title").html("Generate Payslip");
				    $("#MyModal .modal-body").html('<form name = "generate_payslip"><div class="col-lg-12">                                            <div class="form-group"><label>Date From</label>                                                <input type="text" name="date_from" class="form-control " value=""</div>                                        </div><div class="col-lg-12">                                            <div class="form-group"><label>Date To</label>                                               <input type="text" name="date_to" class="form-control " value=""</div>                                        </div></form>');
				    $("#MyModal .modal-footer").html(ButtonList);
				    $("#MyModal").modal('show');
        
                    $("[name=date_from],[name=date_to]").datepicker();
        return false;
    }
    
    function doGenerate()
    {
        
        if(confirm("are you sure want to generate payslip?") == true){
            $.ajax({
				
				type	:	"post",
				dataType:	"json",
				data	:	{action:"generatepayslip",c:$("[name=date_from]").val(),date_to:$("[name=date_to]").val()},
				url		:	"pages/hr/ajax/proccess.php",
				success	:	function(data){
                    alert(data['message']);
                    $("#MyModal").modal('hide');
                }
            });
        }
        return false;
    }
    
    function GeneratePayslip()
    {
        window.open('generate_payslip.php','_blank', 'scrollbars=1,resizable=1,width='+window.outerWidth+',height='+window.outerHeight+',left=0,top=0');
    }
</script>
