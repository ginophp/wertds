<div id="wrapper">
	<div id="page-wrapper">
        <div id="listingmediaserver">
    
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Sales Report</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
			<div class="row" id="CollectorsTable">
				<!-- div class="panel panel-primary">
					<div class="panel-heading">Parameter</div>
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
										<label class="control-label">so : </label>
										<input name="so" class="form-control input-sm" placeholder="[123]" value ="" />
									</div>
								
									<div class="form-group" style="margin-right:10px;">
										<label class="control-label">Branch : </label>
										<input name="branch" class="form-control input-sm" placeholder="[123]" value ="" />
									</div>
							</div>
						</div>
						</form>
				</div -->
				
				<div class="col-lg-12" style="padding-bottom:5px;">
					<!-- button class="btn btn-danger btn-xl" name="search">
						<span class="fa fa-search fa-fw"></span>
						Search
					</button -->
					<!-- button class="btn btn-danger btn-xl" name="AddCollector">
						<span class="fa fa-building-o fa-fw"></span>
						Create Sales Order
					</button -->
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
			
			<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Collection Report</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
			<div class="row" id="xCollectorsTable">
				<!-- div class="panel panel-primary">
					<div class="panel-heading">Parameter</div>
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
										<label class="control-label">so : </label>
										<input name="so" class="form-control input-sm" placeholder="[123]" value ="" />
									</div>
								
									<div class="form-group" style="margin-right:10px;">
										<label class="control-label">Branch : </label>
										<input name="branch" class="form-control input-sm" placeholder="[123]" value ="" />
									</div>
							</div>
						</div>
						</form>
				</div -->
				
				<div class="col-lg-12" style="padding-bottom:5px;">
					<!-- button class="btn btn-danger btn-xl" name="search">
						<span class="fa fa-search fa-fw"></span>
						Search
					</button -->
					<!-- button class="btn btn-danger btn-xl" name="AddCollector">
						<span class="fa fa-building-o fa-fw"></span>
						Create Sales Order
					</button -->
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

          
		$("[name=search]").click(function(){
			showPage(1);
			showPage1(1);
		});
        
        $("[name=UploadEmployees]").click(function(){
			//location.href="index.php?PageID=AC";
            //alert('x');
            $.ajax({
			type	:	"post",
			url		:	"pages/hr/ajax/proccess.php",
			//data	:	{action : "DemandLetterTypeForm", DLID : ID},
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
                        dateFormat: 'yy-mm-dd',
                        yearRange: "1000:<?=date("Y");?>"
                    
                    });
            }
            })
            
            
		});
		
		showPage(1);
		showPage1(1);
	});
	
	function Edit(id){
		$.ajax({
			type	:	"post",
			url		:	"pages/hr/ajax/proccess.php",
			//data	:	{action : "DemandLetterTypeForm", DLID : ID},
			data	:	{action : "Edit", page : 1, Table : 'so',id:id},
			success	:	function(data){
                var ButtonList = '<button type="button" class="btn btn-info" onclick="doUpdate('+id+');">Save</button>'+
								 '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
				    $("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-lg");
				    $("#MyModal .modal-title").html("Edit so");
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
		var serialize = $("[name=search_form_parameter]").serialize()+"&action=Pagination&page="+page+"&Table=so&report_type=sales_report";
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
	
	function showPage1(page){
		var serialize = $("[name=search_form_parameter]").serialize()+"&action=Pagination&page="+page+"&Table=so&report_type=collection_report";
		$.ajax({
			type	:	"post",
			url		:	"pages/hr/ajax/proccess.php",
			dataType:	"json",
			data	:	serialize,
			// data	:	{action : "Pagination", page : page, Table : 'employee'},
			success	:	function(data){
				$("#xCollectorsTable .table-responsive").html(data.Details);
				$("#xCollectorsTable .panel-footer .pagination").html(data.Pagination);
			}
		});
	}
    
    function doSave()
    {
        if(confirm("Are you sure want to save?")==true){
            $.ajax({
			type	:	"post",
			url		:	"pages/hr/ajax/proccess.php",
			dataType:	"json",
			// data	:	{action : "Pagination", page : page, Table : 'employee'},
			data	:	$("[name=AddEmployee]").serialize()+"&action=Save&Table=so",
			success	:	function(data){
                $("#MyModal").modal('hide');
                showPage(1);
				
				
			
				window.open('pages/generate_si.php?id='+data['id'],'TheWindow', 'scrollbars=1,resizable=1,width='+window.outerWidth+',height='+window.outerHeight+',left=0,top=0');
				
				
				
				
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
			data	:	$("[name=AddEmployee]").serialize()+"&action=Update&Table=so&id="+id,
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
			data.append("table", "so");
			
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
	function add_line(event,line){
		// sub_total = parseFloat($("#unit_price"+line).val()) * parseFloat($("#qty"+line).val()).toFixed(2);
		// $("#sub_total"+line).val(sub_total);
		var xfocus = $("#fetch_data_so_details tbody tr").length;
		if(event.keyCode == 13){
			var xsub_total = 0;
			for(var x = 0; line > x; x++){
				//now check the if existing the product in so details;
				if(x != xfocus){
					// alert(x+'='+xfocus);
					if($("#product"+x).find(":selected").val() == $("#product"+line).find(":selected").val()){
						var updated_qty = parseFloat($("#qty"+x).val()) + parseFloat($("#qty"+line).val());
						var updated_subtotal = parseFloat(updated_qty) * parseFloat($("#unit_price"+line).val());
						$("#qty"+x).val(updated_qty);
						$("#sub_total"+x).val(updated_subtotal);
						$("#fetch_data_so_details tbody").find("tr:last-child").remove();
						
						
					}
				}
				
			}
			var sub_total = parseFloat($("#unit_price"+line).val()) * parseFloat($("#qty"+line).val()).toFixed(2);
			$("#sub_total"+line).val(sub_total);
			
		
				
			var clone = $('.clone').html();
			var product = $("#product0").html();
			
		
			
			if(parseFloat(line)+1 < xfocus){
				xfocus = parseFloat(line)+1;
				$("#product"+xfocus).focus();
			}else{
				var res = clone.split(0).join($("#fetch_data_so_details tbody tr").length);
				$("#fetch_data_so_details tbody").append("<tr>"+res+"</tr>");
				$("#product"+xfocus).html(product);
				$("#product"+xfocus).focus();
			}
			
			var total_subtotal = 0;
			for(var x = 0; xfocus > x; x++){
				// alert(isNaN(parseFloat($("#qty"+x).val())));
				if(!isNaN($("#qty"+x).val())){
					if($("#qty"+x).val() != ""){
						 // alert($("#qty"+x).val());
						 total_subtotal += parseFloat($("#qty"+x).val()) * parseFloat($("#unit_price"+line).val());											
					}
				}
			}
			
			$("[name=total_price]").val(total_subtotal);
			var net_of_vat = 0;
			net_of_vat = parseFloat(total_subtotal) - (parseFloat(total_subtotal)  / parseFloat(1.12) );
			$("[name=vat]").val(net_of_vat.toFixed(2));
			
			
			
		}
	}
	
	function product(line){
		if($("#product"+line).find(":selected").val() == 0){
			
		}else{
			$("#product_description"+line).val($("#product"+line).find(":selected").data("description"));
			$("#unit_price"+line).val($("#product"+line).find(":selected").data("price"));
			$("#promo_code"+line).val($("#product"+line).find(":selected").data("promocode"));
			$("#qty"+line).focus();
			// $("#product_description"+line).val($("#product"+line).find(":selected").data("description"));
			
			
		}
	}
	function change_dealer(){
			// alert($("[name=dealer]").find(":selected").data("details"));
			
			// alert($("[name=dealer]").find("selected").toSource());
			// alert($("[name=dealer]").find("selected").val());
			
			// $("[name=dealer]").each(function( index, value ) {
			  // alert( index + ": " + value );
			// });
			
			$("#information_details").html($("[name=dealer]").find(":selected").data("details"));
			
	}
</script>
<style>

.modal-lg {
    width: 100%;
}
</style>