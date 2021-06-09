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
        <input type = "hidden" value = "" name = "ID" />
        <div id = "listingmediaserver">
    
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Demand Letter</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
			<div class="row">
				<div class="col-lg-12">
					
					<div class="panel panel-primary">
                        <div class="panel-heading">
                            Parameter
                        </div>
						<div class="panel-body">
							<div class="col-sm-12">
								<form class="form-inline" name="SearchDemandLetterForm">
									<div class="form-group" style="margin-right:10px;">
										<label class="control-label">Supervisors</label>
										<select name="Supervisors" class="form-control input-sm">
											<option value="">Select</option>
											<?php 
												$branchquery = $mysqli->query("SELECT ID,username,Name FROM USER WHERE Position = 'supervisor' AND ID > 24");
												if($branchquery->num_rows){
													while($res = mysqli_fetch_object($branchquery)){
														echo "<option value='{$res->ID}'>{$res->username} : {$res->Name}</option>";
													}
												}
											?>
										</select>
									</div>
									<div class="form-group" style="margin-right:10px;">
										<label class="control-label">Branch</label>
										<select name="Branch" class="form-control input-sm">
											<option value="">Select</option>
											<?php 
												$branchquery = $mysqli->query("SELECT Branch FROM demandletter WHERE CreatedBy = {$_SESSION['empid']} GROUP BY Branch");
												if($branchquery->num_rows){
													while($res = mysqli_fetch_object($branchquery)){
														echo "<option value='{$res->Branch}'>{$res->Branch}</option>";
													}
												}
											?>
										</select>
									</div>
									<div class="form-group" style="margin-right:10px;">
										<label class="control-label">Area</label>
										<select name="Area" class="form-control input-sm">
											<option value="">Select</option>
											<?php 
												$areaquery = $mysqli->query("SELECT Area FROM demandletter WHERE CreatedBy = {$_SESSION['empid']} GROUP BY Area");
												if($areaquery->num_rows){
													while($res = mysqli_fetch_object($areaquery)){
														echo "<option value='{$res->Area}'>{$res->Area}</option>";
													}
												}
											?>
										</select>
									</div>
									<div class="form-group" style="margin-right:10px;">
										<label class="control-label">Region</label>
										<select name="Region" class="form-control input-sm">
											<option value="">SELECT</option>
											<?php 
												$query = $mysqli->query("SELECT DISTINCT major_area Region FROM zipcodes");
												while($res = mysqli_fetch_object($query)){
													echo "<option value='".utf8_encode($res->Region)."'>".utf8_encode($res->Region)."</option>";
												}
											?>
										</select>
									</div>
									<div class="form-group" style="margin-right:10px;">
										<label class="control-label">City</label>
										<select name="City" class="form-control input-sm">
											<option value="">Select</option>
										</select>
									</div>
									<div class="form-group" style="margin-right:10px;">
										<label class="control-label">ZIP</label>
										<select name="ZIP" class="form-control input-sm">
											<option value="">Select</option>
										</select>
									</div>
									<div class="form-group" style="margin-right:10px;">
										<label class="control-label">Date Uploaded</label>
										<input name="DateUploaded" class="form-control input-sm" placeholder="<?=date("m/d/Y")?>" value ="<?=date("m/d/Y")?>" />
									</div>
									<div class="form-group" style="margin-right:10px;">
										<label class="control-label">Identifier</label>
                                        <select class ="form-control" name="Identifier">
                                            <option>+</option>
                                            <option>-</option>
                                        </select>
									</div>
									<div class="form-group" style="margin-right:10px;">
										<label class="control-label">Reasons</label>
                                        <select class ="form-control" name="Reasons">
                                            <option value = "0">Zero Result</option>
                                        </select>
									</div>
									<div class="form-group" style="margin-right:10px;">
										<label class="control-label">Range Amount</label>
                                        <input name="AmountFrom" class="form-control input-sm" placeholder="0.00" value ="" />
                                        <input name="AmountTo" class="form-control input-sm" placeholder="1000000.00" value ="" />
									</div>
									<div class="form-group" style="margin-right:10px;">
										<label class="control-label">Account Number</label>
                                        <input name="AccountNumber" class="form-control input-sm" placeholder="01010101001" value ="" />
									</div>
									<div class="form-group">
										<button type="button" class="btn btn-sm btn-info" name="BtnSearchDemandLetter">Search</button>
										
										<button type="button" class="btn btn-sm btn-danger" name="BtnClearhDemandLetter">Clear</button>
									</div>
								</form>
							</div>
						</div>
						<div class="panel-footer">
                            <p class = "total">0</p>
                            <p class = "TotalPrint"> Total Print : 0</p>
                            <!--button type="button" class="btn btn-sm btn-primary" name="BtnFieldListingr"><span class="glyphicon glyphicon-print"></span> Field Listing Report</button -->
                            <button type="button" class="btn btn-sm btn-primary" name="BtnFieldListingXls"><span class="glyphicon glyphicon-print"></span> Field Listing</button>
                            <button type="button" class="btn btn-sm btn-primary" name="BtnIncentivesgXls"><span class="glyphicon glyphicon-print"></span>Incentive Report</button>
							<button name="Print" class="btn btn-sm btn-danger" onclick="return DisplayPrintForm();"><span class="glyphicon glyphicon-print"></span> Print</button>
							<!-- button name="Archive" class="btn btn-sm btn-primary" onclick="return Archive();"><span class="glyphicon glyphicon-trash"></span> Archive</button -->
						</div>
					</div>
					
				</div>
			</div>
			
            <div class="row" id="DemandLetterTable">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Information
                        </div>
						<form name = "print_pdf">
                        <div class="table-responsive">
							<table id = "fetch_data" class="table table-striped table-bordered table-hover">
								<td align="center">Loading... Please wait...</td>
							</table>
						</div>
						</form>
                        <!-- /.panel-body -->
						<div class="panel-footer"> 
							<ul class="pagination" style="margin:0;"></ul>
                            <br />
						</div>
						
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            </div>
            <div id = "addmediaserver" style="display:none;">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Add Arena</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
			<div class="row" id = "">
				 <div class="col-lg-8">
				  <div class="panel panel-primary">
						<div class="panel-heading">
                            Information
						</div>
						
						 <form role="form" name = "mediaserver">
							<div class="panel-body">
							<div class="row">
								<div class="col-lg-10">
									<div id= "Name" class="form-group">
										<label>Name</label>
										<input name = "Name" class="form-control" placeholder="Enter text">
										<!-- p class="help-block">Example Gino C. Leabres</p -->
									</div>
                                    <div id= "Name" class="form-group">
										<label>Address</label>
										<input name = "Address" class="form-control" placeholder="Enter text">
										<!-- p class="help-block">Example Gino C. Leabres</p -->
									</div>
                                    <!-- div id= "Name" class="form-group">
										<label>Region</label>
								        
									</div -->
								</div>
							</div>
							
							</div>
							<div class="panel-footer"> 
								<button class="btn btn-success btn-circle btn-xl" type="button" name = "Edit" 
                                style="display:none;">
									<i class="fa fa-check"></i>
								</button>
                                <button class="btn btn-success btn-circle btn-xl" type="button" name = "Save">
									<i class="fa fa-check"></i>
								</button>
								<button class="btn btn-danger btn-circle btn-xl" type="button" name = "Cancel">
									<i class="fa fa-refresh"></i>
								</button>
							</div>
						</form>
				  </div>
				 </div>
			</div>
			</div>
            <!-- /.row -->
        </div>
    <!-- /#wrapper -->
</div>

<script>
	$(function(){
        
        getreasons();
        $("[name=Identifier]").change(function(){
            getreasons();
            
        });
		
		$("[name=Supervisors]").change(function(){
				var sup = $(this).find(":selected").val();
				$.ajax({
				type	:	"post",
				dataType:	"html",
				url		:	"pages/admin/ajax/listingdemandletter.php",
				data	:	{action : "Branch", sup : sup},
				success	:	function(data){
					// alert(data);
					$("[name=Branch]").html(data);
				}
				});
				
				$.ajax({
				type	:	"post",
				dataType:	"html",
				url		:	"pages/admin/ajax/listingdemandletter.php",
				data	:	{action : "Area", sup : sup},
				success	:	function(data){
					// alert(data);
					$("[name=Area]").html(data);
				}
				});
				
				
		})
        
		showPage(1);
		
		$("[name=DateUploaded]").datepicker({
			changeYear	:	true,
			changeMonth	:	true,
			maxDate		:	0	
		});
		
		//action to get city
		$("[name=Region]").change(function(){
			var region = $(this).val();
			$.ajax({
				type	:	"post",
				dataType:	"json",
				url		:	"pages/admin/ajax/listingdemandletter.php",
				data	:	{action : "GetCity", Region : region},
				success	:	function(data){
					var city = "<option value=''>SELECT</option>";
					
					if(data.Success == 1){
						for(var x = 0; x < data.City.length; x++){
							city += "<option value='"+data.City[x]+"'>"+data.City[x]+"</option>";
						}
					}
					$("[name=City]").html(city);
				}
			});
			
		});
		
		//action to get city
		$("[name=City]").change(function(){
			var city = $(this).val();
			$.ajax({
				type	:	"post",
				dataType:	"json",
				url		:	"pages/admin/ajax/listingdemandletter.php",
				data	:	{action : "GetZip", City : city, Region : $("[name=Region]").val()},
				success	:	function(data){
					var zip = "<option value=''>SELECT</option>";
					
					if(data.Success == 1){
						for(var x = 0; x < data.Zip.length; x++){
							zip += "<option value='"+data.Zip[x]+"'>"+data.Zip[x]+"</option>";
						}
					}
					$("[name=ZIP]").html(zip);
				}
			});
			
		});
		
		$("[name=BtnSearchDemandLetter]").click(function(){
			showPage(1);
		});
		
		$("[name=BtnFieldListingr]").click(function(){
			//showPage(1);
            
			$.ajax({
			type	:	"post",
			url		:	"pages/admin/ajax/listingdemandletter.php",
			//data	:	{action : "DemandLetterTypeForm", DLID : ID},
			data	:	{action : "FieldListing"},
			success	:	function(data){
			
				var ButtonList = '<button type="button" class="btn btn-info" onclick="PrintFieldListing();">Print</button>'+
								 '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
				$("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-md");
				$("#MyModal .modal-title").html("Field Listing");
				$("#MyModal .modal-body").html(data);
				$("#MyModal .modal-footer").html(ButtonList);
				$("#MyModal").modal('show');
				$("[name=DateReturned]").datepicker({
					changeYear	:	true,
					changeMonth	:	true,
					maxDate		:	0	
				});
			}
			
			});
			
			
            
            return false;
            
            
            
            //$.ajax({
            //    type	:	"post",
            //    url		:	"pages/admin/ajax/listingdemandletter.php",
            //    dataType:	"json",
            //    data	:	$("[name=SearchDemandLetterForm]").serialize() + "&action=GetDemandLetter&page="+page,
            //    success	:	function(data){
            //        $("#DemandLetterTable .table-responsive").html(data.Details);
            //        $(".total").html(data.Counter);
            //        $("#DemandLetterTable .panel-footer .pagination").html(data.Pagination);
            //    }
		    //});
            
		});
		
		$("[name=BtnFieldListingXls]").click(function(){
			//showPage(1);
            
			$.ajax({
			type	:	"post",
			url		:	"pages/admin/ajax/listingdemandletter.php",
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
		
		$("[name=BtnIncentivesgXls]").click(function(){
			//showPage(1);
            
			$.ajax({
			type	:	"post",
			url		:	"pages/admin/ajax/listingdemandletter.php",
			//data	:	{action : "DemandLetterTypeForm", DLID : ID},
			data	:	{action : "FieldListing"},
			success	:	function(data){
			
				var ButtonList = '<button type="button" class="btn btn-info" onclick="PrintIncentivesgXls();">Print</button>'+
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

        $("[name=BtnClearhDemandLetter]").click(function(){
            
            $("[name=SearchDemandLetterForm]").find("input").each(function(){
                //alert($(this).attr("name"));
                $("[name ="+$(this).attr("name")+"]").val("");
            })
            
            //$("[name=SearchDemandLetterForm]").find("select").each(function(){
            //    //alert($(this).attr("name"));
            //    $("[name ="+$(this).attr("name")+"]").val("Select");
            //})
            
            showPage(1);
        })
	});
	
	
	function PrintFieldListing()
	{
		//$("[name=FieldListingForm]").serialize()+"&action=fieldlisting";
		
		$("[name=FieldListingForm]").attr("method","post");
		$("[name=FieldListingForm]").attr("action",'pages/admin/ajax/report.php?action=fieldlisting');
		$("[name=FieldListingForm]").attr("target","TheWindow");
		window.open('','TheWindow', 'scrollbars=1,resizable=1,width='+window.outerWidth+',height='+window.outerHeight+',left=0,top=0');
		
		$("[name=FieldListingForm]").submit();
		
		
	}
	
	function PrintFieldListingxls()
	{
		//$("[name=FieldListingForm]").serialize()+"&action=fieldlisting";
		$("[name=FieldListingForm]").attr("method","post");
		$("[name=FieldListingForm]").attr("action",'pages/admin/ajax/report.php?action=fieldlistingexporttoxls');
		$("[name=FieldListingForm]").attr("target","TheWindow");
		window.open('','_blank', 'scrollbars=1,left=0,top=0');
		$("[name=FieldListingForm]").submit();
		
		
	}
	function PrintIncentivesgXls()
	{
		//$("[name=FieldListingForm]").serialize()+"&action=fieldlisting";
		$("[name=FieldListingForm]").attr("method","post");
		$("[name=FieldListingForm]").attr("action",'pages/admin/ajax/report.php?action=driverincentive');
		$("[name=FieldListingForm]").attr("target","TheWindow");
		window.open('','_blank', 'scrollbars=1,left=0,top=0');
		$("[name=FieldListingForm]").submit();
		
		
	}
	//function DisplayPrintForm(ID){
	function DisplayPrintForm(){
		
		if($("#DemandLetterTable").find("[name='DemandLetterID[]']:checked").length == 0){
			alert("Please select Demand Letter.");
			return false;
		}
		
		$.ajax({
			type	:	"post",
			url		:	"pages/admin/ajax/listingdemandletter.php",
			//data	:	{action : "DemandLetterTypeForm", DLID : ID},
			data	:	{action : "DemandLetterTypeForm"},
			success	:	function(data){
			
				var ButtonList = '<button type="button" class="btn btn-info" onclick="PrintDL();">Print</button>'+
								 '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
				$("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-md");
				$("#MyModal .modal-title").html("Demand Letter Type");
				$("#MyModal .modal-body").html(data);
				$("#MyModal .modal-footer").html(ButtonList);
				$("#MyModal").modal('show');
			
			}
			
		});
	}
	
	function PrintDL(){
		
		$("[name=DemandLetterTypeForm]").find("#helpBlock").html("");
		$("[name=DemandLetterTypeForm]").find(".form-group").removeClass("has-error");
		
		if($("[name=DemandLetterTypeForm]").find("select[name=DemandLetterType]").val() == ""){
			$("[name=DemandLetterTypeForm]").find("#helpBlock").html("Please select Demand Letter Type.");
			$("[name=DemandLetterTypeForm]").find("#helpBlock").closest(".form-group").addClass("has-error");
			return false;
		}
		
		if($("[name=DemandLetterTypeForm]").find("[name=Signature]").val() != ""){
			var file = $("[name=DemandLetterTypeForm]").find("[name=Signature]")[0].files[0];
			var reader = new FileReader();
			
			reader.onload = function(e){
				$.ajax({
					type	:	"post",
					dataType:	"json",
					url		:	"pages/admin/ajax/listingdemandletter.php",
					data	:	{action : "SaveSignature", image : e.target.result},
					success	:	function(data){
						if(data.Success == 1){
							var dlid = new Array();
							
							//$("#DemandLetterTable").find("[name='DemandLetterID[]']:checked").each(function(i){
							//	dlid[i] = $(this).val();
							//	AddCounter($(this).val());
							//})
							var h=0;
							$("#DemandLetterTable").find("[type=checkbox]:checked").each(function(i){
								
								if($(this).attr("name") != 'CheckAll'){
									dlid[h] = $(this).val();
										//AddCounter($(this).val());
										h++;
									
								}
							});
                            
							var url = "pages/admin/"+$("[name=DemandLetterTypeForm]").find("[name=DemandLetterType] option:selected").attr("data-url");
							// var details = "DLType=" + $("[name=DemandLetterTypeForm]").find("[name=DemandLetterType]").val() + "&dlid=" + dlid;
							var details = "DLType=" + $("[name=DemandLetterTypeForm]").find("[name=DemandLetterType]").val();
							
							print_pdf(url, details);
							
                            // details = "DLType=" + $("[name=DemandLetterTypeForm]").find("[name=DemandLetterType]").val() + "&dlid=" + dlid;
							url = "pages/admin/print_barcodes.php";
                            
							print_barcodes(url, details);
							
                            $("[data-dismiss='modal']").click();
							// $("#DemandLetterTable").find("[name=CheckAll]").prop("checked", false);
							// $("#DemandLetterTable").find("[name='DemandLetterID[]']:checked").each(function(i){
								// $(this).prop("checked", false);
							// })
						}
					}
				});
			}
			
			reader.readAsDataURL(file);
			
			return false;
		}else{
            var dlid = new Array();
            //$("#DemandLetterTable").find("[name='DemandLetterID[]']:checked").each(function(i){
            //    dlid[i] = $(this).val();
            //    AddCounter($(this).val());
            //})
			
			var h=0;
			$("#DemandLetterTable").find("[type=checkbox]:checked").each(function(i){
				if($(this).attr("name") != 'CheckAll'){
						dlid[h] = $(this).val();
						//AddCounter($(this).val());
						h++;
					
				}
			})
            var url = "pages/admin/"+$("[name=DemandLetterTypeForm]").find("[name=DemandLetterType] option:selected").attr("data-url");
            // var details = "DLType=" + $("[name=DemandLetterTypeForm]").find("[name=DemandLetterType]").val() + "&dlid=" + dlid+"&signature=0";
            var details = "DLType=" + $("[name=DemandLetterTypeForm]").find("[name=DemandLetterType]").val() +"&signature=0";

            print_pdf(url, details);
            
            url = "pages/admin/print_barcodes.php";
            // details = "DLType=" + $("[name=DemandLetterTypeForm]").find("[name=DemandLetterType]").val() + "&dlid=" + dlid+"&signature=0";
            
			print_barcodes(url, details);
            
			// $("[name=DemandLetterTypeForm]").find("#helpBlock2").html("Please insert your signature.");
			// $("[name=DemandLetterTypeForm]").find("#helpBlock2").closest(".form-group").addClass("has-error");
			// return false;
		}
        
        $("[data-dismiss='modal']").click();
        // $("#DemandLetterTable").find("[name=CheckAll]").prop("checked", false);
        // $("#DemandLetterTable").find("[name='DemandLetterID[]']:checked").each(function(i){
            // $(this).prop("checked", false);
        // })
	
	}
	
	function showPage(page){
		
		$.ajax({
			type	:	"post",
			url		:	"pages/admin/ajax/listingdemandletter.php",
			dataType:	"json",
			data	:	$("[name=SearchDemandLetterForm]").serialize() + "&action=GetDemandLetter&page="+page,
			success	:	function(data){
				$("#DemandLetterTable .table-responsive").html(data.Details);
                $(".total").html(data.Counter);
				$("#DemandLetterTable .panel-footer .pagination").html(data.Pagination);
				$("#MyModal").modal('hide');
			},beforeSend:	function(){
					$("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-md");
					$("#MyModal .modal-title").html("Loading..");
					$("#MyModal .modal-body").html("<img src = 'img/ajax-loader.gif'></img> PLease wait.....");
					
					$("#MyModal .modal-footer").html("");
					$("#MyModal").modal('show');
			}
		});
		
	}
	
	function print_pdf(url, data){
		
	
		$("[name=print_pdf]").attr("method","post");
		$("[name=print_pdf]").attr("action",url+"?"+data);
		$("[name=print_pdf]").attr("target","TheWindow");
		window.open('','TheWindow', 'scrollbars=1,resizable=1,width='+window.outerWidth+',height='+window.outerHeight+',left=0,top=0');
		
		$("[name=print_pdf]").submit();
		
		
        // var myWindow = window.open(url+"?"+data,"windowOpenTab", 'scrollbars=1,resizable=1,width='+window.outerWidth+',height='+window.outerHeight+',left=0,top=0');
        return false;
    
	}
	
	function print_barcodes(url, data){
	
        //var myWindow = window.open(url+"?"+data,"windowOpenTab", 'scrollbars=1,resizable=1,width='+window.outerWidth+',height='+window.outerHeight+',left=0,top=0');
        // window.open(url+"?"+data,'_blank');
		$("[name=print_pdf]").attr("method","post");
		$("[name=print_pdf]").attr("action",url+"?"+data,'_blank');
		$("[name=print_pdf]").attr("target","_blank");
		$("[name=print_pdf]").submit();
        //window.open(url);
        
		$("[name=print_pdf]").removeAttr("method","post");
		$("[name=print_pdf]").removeAttr("action",url+"?"+data,'_blank');
		$("[name=print_pdf]").removeAttr("target","_blank");
		
		
		
        return false;
    
	}
	
	
	function Archive(){
		var serialize = $("[name=print_pdf]").serialize()+"&action=Archived";
		
		
		if(confirm("Are you sure want to archived this records?")==true){
				$.ajax({
					type	:	"post",
					url		:	"pages/admin/ajax/listingdemandletter.php",
					data	:	serialize,
					success	:	function(data){
						showPage(1);
					}
				});
				return false;
		}
		return false;
	}
	
	function ViewDLDetails(DLID){
		$.ajax({
			
			type	:	"post",
			url		:	"pages/admin/ajax/listingdemandletter.php",
			data	:	{action : "GetDLDetails", DLID : DLID},
			success	:	function(data){
				var ButtonList = '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
				$("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-md");
				$("#MyModal .modal-title").html("Demand Letter Details");
				$("#MyModal .modal-body").html(data);
				$("#MyModal .modal-footer").html(ButtonList);
				$("#MyModal").modal('show');
			}
			
		});
		return false;
	}
    
	function OpsViewDLDetails(DLID){
		$.ajax({
			
			type	:	"post",
			url		:	"pages/admin/ajax/listingdemandletter.php",
			data	:	{action : "GetDLOpsDetails", DLID : DLID},
			success	:	function(data){
				var ButtonList = '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
				$("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-md");
				$("#MyModal .modal-title").html("Operation Details");
				$("#MyModal .modal-body").html(data);
				$("#MyModal .modal-footer").html(ButtonList);
				$("#MyModal").modal('show');
			}
			
		});
		
		return false;
	}
	
	function CheckAllDLDetails(field){
		var count = 0;
		if($("#DemandLetterTable").find("[name='DemandLetterID[]']").length > 0){
			$("#DemandLetterTable").find("[name='DemandLetterID[]']").prop('checked', $(field).prop('checked'));
            
            $("[name='DemandLetterID[]']").each(function(){
                if($(this).is(":checked")){
                    count++;   
                }
            });
            
            
            
            if($(field).prop('checked') == true){
                 //count++;
            }
           
		}
		$(".TotalPrint").html("Total Print : "+count);
		return false;
		
	}
	
	function AddCounter(DLID){
		$.ajax({
			type	:	"post",
			url		:	"pages/admin/ajax/listingdemandletter.php",
			data	:	{action : "AddCounter", DLID : DLID}
		});
	}
    
    function singlecheck()
    {
         var count = 0;
         $("[name='DemandLetterID[]']").each(function(){
                if($(this).is(":checked")){
                    count++;   
                }
        });
        $(".TotalPrint").html("Total Print : "+count);
            
    }
	
	function AddIncentiveAmount(ID)
	{
		if(confirm("Are you sure want to add incentive?")==false){
			return false;
		}
		var html = ""
        var details = "";
        $.ajax({
				type	:	"post",
				url		:	"pages/admin/ajax/listingdemandletter.php",
				data	:	{DriverScheduleID : ID, action:'getpaymentinformation'},
				success : function(resp){
				    	if(resp['response'] == 'success'){
                            for(var x = 0; resp['data_handler'].length > x; x++){
                                details +='<tr>';
                                details += "<td>"+resp['data_handler'][x].DLID+"</td>";        
                                details += "<td>"+resp['data_handler'][x].Amount+"</td>";        
                                details += "<td>"+resp['data_handler'][x].DateLogs+"</td>";       
                                details += "</tr>";
                            }
                        }else{
                            details += "<tr><td colspan = '3'>No payment record found</td></tr>";
                        }
                    
                        html += '<div class="panel-body">';
                        html += '<div class="row" id="Information">';
                        html += '        <div class="col-lg-12">';
                        html += '            <div class="panel panel-primary">';
                        html += '                <div class="panel-heading">';
                        html += '                    Information';
                        html += '                </div>';
                        html += '                <div class="table-responsive">';
                        html += '					<table id = "fetch_data_information" class="table table-striped table-bordered table-hover">';
                        html += '                     <tr><th>Barcode</th><th>Amount</th><th>Date Uploaded</th></tr>';
                        html += details;
                        html += '					</table>';
                        html += '				</div>';
                        html += '            </div>';
                        html += '            <!-- /.panel -->';
                        html += '        </div>';
                        html += '        <!-- /.col-lg-12 -->';
                        html += '    </div>';



                        html +=	'<form class="form-horizontal" role="form" name="AddCollectorForm">';
                        html += '<div class="form-group">';
                        html += '<label class="control-label col-sm-3">New Address Amount : </label>';
                        html += '<div class="col-sm-5">';
                        html += '<input type="text" name="NewAddAmount" class="form-control" />';
                        html += '</div>';
                        html += '</div>';

                        html += '<div class="form-group">';
                        html += '<label class="control-label col-sm-3">New Number Amount : </label>';
                        html += '<div class="col-sm-5">';
                        html += '<input type="text" name="NewNumberAmount" class="form-control" />';
                        html += '</div>';
                        html += '</div>';

                        html += '<div class="form-group">';
                        html += '<label class="control-label col-sm-3">7 Days Payment Amount : </label>';
                        html += '<div class="col-sm-5">';
                        html += '<input type="text" name="SevenDaysPaymentAmount" class="form-control" />';
                        html += '</div>';
                        html += '</div>';


                        html += '<div class="form-group">';
                        html += '<label class="control-label col-sm-3">Incoming Call: </label>';
                        html += '<div class="col-sm-5">';
                        html += '<input type="text" name="IncomingCallAmount" class="form-control" />';
                        html += '</div>';
                        html += '</div>';

                        html += '<div class="form-group">';
                        html += '<label class="control-label col-sm-3">Info Status : </label>';
                        html += '<div class="col-sm-5">';
                        html += '<input type="text" name="InfoStatus" class="form-control" />';
                        html += '</div>';
                        html += '</div>';

                        html += '</form>';
                        html += '</div>';

                        var ButtonList = '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
                         ButtonList += '<button type="button" class="btn btn-primary" onclick = "saveincentive('+ID+')" data-dismiss="modal">Save</button>';
                        $("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-md");
                        $("#MyModal .modal-title").html("Add Incentives");
                        $("#MyModal .modal-body").html(html);
                        $("#MyModal .modal-footer").html(ButtonList);
                        $("#MyModal").modal('show');

				}
        })
        
        
        
        
        
		
		return false;
	}
	
	function saveincentive(ID){
		if(confirm("are you sure want to save this incentive?")==true){
			$.ajax({
				type	:	"post",
				url		:	"pages/admin/ajax/listingdemandletter.php",
				data	:	$("[name=AddCollectorForm]").serialize()+"&ID="+ID+"&action=saveincentive",
				success : function(resp){
					//showPage(1);
				}
			})
			
		}
		return false;
	}
    
    function getreasons(){
        
        
           //alert($(this).val()); 
            $.ajax({
                type	:	"post",
				dataType:	"json",
				url		:	"pages/admin/ajax/listingdemandletter.php",
				data	:	{action : "GetReasons", Identifier : $("[name=Identifier]").val()},
				success	:	function(resp){
                    
                    var html = "";
                    if(resp['response'] == 'success'){
                        
                        html += '<option value = "0">[ALL]</option>';
                        for(var x = 0; resp['data_handler'].length > x; x++){
                            html += '<option value = "'+resp['data_handler'][x].ID+'">'+resp['data_handler'][x].Description+'</option>';
                        }
                    }
                    $("[name=Reasons]").html(html);
                }
            });
    }
</script>