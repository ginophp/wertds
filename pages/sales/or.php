<div id="wrapper">
	<div id="page-wrapper">
        <div id="listingmediaserver">
    
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">OFFICIAL RECEIPT</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
			<div class="row" id="Collectofficial_receiptsTable">
				<div class="panel panel-primary">
					<div class="panel-heading">Parameter</div>
						<form name = "search_form_parameter">
						<div class="panel-body">
							<div class="col-sm-6">
									
									<div class="form-group" style="margin-right:10px;">
										<label class="control-label">Date From : </label>
										<input name="date_from" class="form-control datepicker" placeholder="[123]" value ="" />
									</div>
									
									<div class="form-group" style="margin-right:10px;">
										<label class="control-label">Date To : </label>
										<input name="date_to" class="form-control datepicker" placeholder="[sample]" value ="" />
									</div>
							</div>
							<div class="col-sm-6">
									<!-- div class="form-group" style="margin-right:10px;">
										<label class="control-label">official_receipt : </label>
										<input name="official_receipt" class="form-control input-sm" placeholder="[123]" value ="" />
									</div>
								
									<div class="form-group" style="margin-right:10px;">
										<label class="control-label">Branch : </label>
										<input name="branch" class="form-control input-sm" placeholder="[123]" value ="" />
									</div -->
							</div>
						</div>
						</form>
				</div>
				
				<div class="col-lg-12" style="padding-bottom:5px;">
					<button class="btn btn-danger btn-xl" name="search">
						<span class="fa fa-search fa-fw"></span>
						Search
					</button>
					<button class="btn btn-danger btn-xl" name="AddCollectofficial_receipt">
						<span class="fa fa-building-o fa-fw"></span>
						Add official_receipt
					</button>
				</div>
				
				<div class="col-lg-12">
					
					<div class="panel panel-primary">
					
						<div class="panel-heading">official_receipt</div>
						
                        <div class="table-responsive">
							<table id = "fetch_data" class="table table-striped table-bofficial_receiptdered table-hover">
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
		 
                    // $('.datepicker').datepicker({
						// changeMonth: true,
						// changeYear: true,
						// dateFormat: 'yy-mm-dd',
						// yearRange: "1000:2020"
                    
                    // });
		
		$("[name=AddCollectofficial_receipt]").click(function(){
			//location.href="index.php?PageID=AC";
            //alert('x');
            $.ajax({
			type	:	"post",
			url		:	"pages/hr/ajax/proccess.php",
			//data	:	{action : "DemandLetterTypeform", DLID : ID},
			data	:	{action : "Add", page : 1, Table : 'official_receipt'},
			success	:	function(data){
                var ButtonList = '<button type="button" class="btn btn-info" onclick="doSave();">Save</button>'+
								 '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
				    $("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-lg");
				    $("#MyModal .modal-title").html("Add official_receipt");
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
			//data	:	{action : "DemandLetterTypeform", DLID : ID},
			data	:	{action : "Upload", page : 1, Table : 'branch'},
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
                        dateformat: 'yy-mm-dd',
                        yearRange: "1000:<?=date("Y");?>"
                    
                    });
            }
            })
            
            
		});
		
		showPage(1);
	});
	
	function Edit(id){
		$.ajax({
			type	:	"post",
			url		:	"pages/hr/ajax/proccess.php",
			//data	:	{action : "DemandLetterTypeform", DLID : ID},
			data	:	{action : "Edit", page : 1, Table : 'official_receipt',id:id},
			success	:	function(data){
                var ButtonList = '<button type="button" class="btn btn-info" onclick="doUpdate('+id+');">Save</button>'+
								 '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
				    $("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-lg");
				    $("#MyModal .modal-title").html("Edit official_receipt");
				    $("#MyModal .modal-body").html(data);
				    $("#MyModal .modal-footer").html(ButtonList);
				    $("#MyModal").modal('show');
                    
                    $('#datepicker').datepicker({
                        changeMonth: true,
			            changeYear: true,
                        dateformat: 'yy-mm-dd',
                        yearRange: "1000:<?=date("Y");?>"
                    
                    });
            }
        })
	}
	
	function showPage(page){
		var serialize = $("[name=search_form_parameter]").serialize()+"&action=Pagination&page="+page+"&Table=official_receipt";
		$.ajax({
			type	:	"post",
			url		:	"pages/hr/ajax/proccess.php",
			dataType:	"json",
			data	:	serialize,
			// data	:	{action : "Pagination", page : page, Table : 'employee'},
			success	:	function(data){
				$("#Collectofficial_receiptsTable .table-responsive").html(data.Details);
				$("#Collectofficial_receiptsTable .panel-footer .pagination").html(data.Pagination);
			}
		});
	}
    
    function doSave()
    {
        if(confirm("Are you sure want to save?")==true){
            $.ajax({
			type	:	"post",
			url		:	"pages/hr/ajax/proccess.php",
			// dataType:	"json",
			// data	:	{action : "Pagination", page : page, Table : 'employee'},
			data	:	$("[name=AddEmployee]").serialize()+"&action=Save&Table=official_receipt",
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
			url		:	"pages/hr/ajax/proccess.php",
			//dataType:	"json",
			//data	:	{action : "Pagination", page : page, Table : 'employee'},
			data	:	$("[name=AddEmployee]").serialize()+"&action=Update&Table=official_receipt&id="+id,
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
			
			var data = new formData();
			data.append("file", files);
			data.append("Selection", $("[name=Selection]").val());
			data.append("DateUploaded", $("[name=DateUploaded]").val());
			data.append("action", "UploadDataEmployee");
			data.append("table", "official_receipt");
			
			$.ajax({
				
				type	:	"post",
				dataType:	"json",
				data	:	data,
				url		:	"pages/hr/ajax/proccess.php",
				cache	:	false,
				processData:false,
				contentType:false,
				success	:	function(data){
					$(".Errofficial_receipt-Message-Box").find(".alert").removeClass("alert-success").removeClass("alert-info").addClass("alert-danger");
					
					if(data.Success == 1){
						$("[name=DateUploaderform]")[0].reset();
						$(".Errofficial_receipt-Message-Box").find(".alert").removeClass("alert-danger").removeClass("alert-info").addClass("alert-success");
						$(".Errofficial_receipt-Message-Box").find(".Errofficial_receipt-Message").html(data.Errofficial_receiptMessage);
					}else{
						$(".Errofficial_receipt-Message-Box").show();
						$(".Errofficial_receipt-Message-Box").find(".alert").removeClass("alert-danger").removeClass("alert-success").addClass("alert-info");
						$(".Errofficial_receipt-Message-Box").find(".Errofficial_receipt-Message").html(data.Errofficial_receiptMessage);
					}
					
                    $("[name=DataUploader]").removeAttr("disabled","disabled");
				},
				befofficial_receipteSend:	function(){
					
                    $("[name=DataUploader]").attr("disabled","disabled");
					$(".Errofficial_receipt-Message-Box").show();
					$(".Errofficial_receipt-Message-Box").find(".Errofficial_receipt-Message").html("<img src = 'img/ajax-loader.gif'></img> loading... please wait..");
					//$(".Errofficial_receipt-Message-Box").find(".Errofficial_receipt-Message").html("Loading... Please wait...");
					$(".Errofficial_receipt-Message-Box").find(".alert").removeClass("alert-danger").removeClass("alert-success").addClass("alert-info");
					
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

