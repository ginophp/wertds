
<style>
	.ui-autocomplete {
	max-height: 100px;
	overflow-y: auto;
	/* prevent horizontal scrollbar */
	overflow-x: hidden;
	}
	/* IE 6 doesn't support max-height
	* we use height instead, but this forces the menu to always be this tall
	*/
	* html .ui-autocomplete {
	height: 100px;
	}

	.ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year {
	  color: black;
	  /*font-family: ...;*/
	  font-size: 16px;
	  font-weight: bold;
	}
	
	.editdltable th{
		text-align:center;
	}
</style>
<script>
    

</script>
<div id="wrapper">
	<div id="page-wrapper">
		<input type = "hidden" value = "" name = "ID" />
		<div id = "listingmediaserver">

		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Data Uploader</h1>
			</div>
			<!-- /.col-lg-12 -->
		</div>
		<!-- /.row -->
		<div class="row" id = "rowCrossCheckValidation">
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
										<option value="1">Upload</option>
                                    <?php
								        $accounttype = $mysqli->query("SELECT ID FROM user WHERE AccountType LIKE '%PAGIBIG%' AND ID = {$_SESSION['empid']}");
								        if($accounttype->num_rows){
							         ?>    
										
									<?php }?>
										<option value="2">PROMO SET</option>
                                        <option value="3">PROMO ANY ITEM</option>
                                       
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
						<div class="panel-footer">
							<button class="btn btn-primary btn btn-xl" type="button" name="DataUploader">Upload</button> | 
							<a a href="download/ACCOUNT_INFO_FORMAT.xlsx" download><span class="glyphicon glyphicon-edit"></span> <b>Download Format</b> </a>
							<br />
							<!-- i><span class="fa fa-warning"></span> * Note : Please download the procedure. c/o Emma Lasala & Joy Villaruel</i -->
							
						</div>
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
		</div>
		<!-- /.row -->
		</div>
	</div>
</div>

<script>

	$(function(){
		
		$("[name=DateUploaded]").datepicker({
			changeYear	:	true,
			changeMonth :	true,
			maxDate		:	new Date()
		});
		
		$("[name=Selection]").change(function(){
			
			// if($(this).val() == 1 || $(this).val() == 3|| $(this).val() == 4|| $(this).val() == 5 || $(this).val() == 6 || $(this).val() == 7 || $(this).val() == 9 ){//upload & payment here..
				// $(".update").hide("fast");
			// }else{
				// $(".update").slideDown();
			// }
			
			if($(this).val() == 2){
				$(".update").slideDown();
			}else{
				$(".update").hide("fast");
			}
			// if()
			
		});

		
		$("[name=DataUploader]").click(function(){
			var files = $("[name=FileToUpload]").prop("files")[0];
			
			var data = new FormData();
			data.append("file", files);
			data.append("Selection", $("[name=Selection]").val());
			data.append("DateUploaded", $("[name=DateUploaded]").val());
			data.append("action", "UploadData");
			
			$.ajax({
				
				type	:	"post",
				dataType:	"json",
				data	:	data,
				url		:	"pages/supervisor/ajax/datauploader.php",
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
			
		});
		
	});
	
</script>