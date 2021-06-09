<script>
	$(function(){ 
		$("[name=AddCollector]").click(function(){
			location.href="index.php?PageID=AC";
		});
		
		showPage(1);
		
		$("[name=Supervisors]").change(function(){
			showPage(1);
		})
		
	});
	
	function EditCollector(CollectorCode){
		location.href="index.php?PageID=EC&CID="+CollectorCode;		
	}
	
	function showPage(page){
		
		$.ajax({
			type	:	"post",
			url		:	"pages/admin/ajax/collector.php",
			dataType:	"json",
			data	:	{action : "Pagination", page : page,Collector:$("[name=Supervisors]").find(":selected").val()},
			success	:	function(data){
				$("#CollectorsTable .table-responsive").html(data.Details);
				$("#CollectorsTable .panel-footer .pagination").html(data.Pagination);
			}
		});
		
	}
</script>

<div id="wrapper">
	<div id="page-wrapper">
        <div id="listingmediaserver">
    
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Collectors</h1>
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
								</form>
							</div>
						</div>
						<!-- div class="panel-footer">
                            <p class = "total">0</p>
                            <p class = "TotalPrint"> Total Print : 0</p>
                            <!--button type="button" class="btn btn-sm btn-primary" name="BtnFieldListingr"><span class="glyphicon glyphicon-print"></span> Field Listing Report</button -->
                            <!-- button type="button" class="btn btn-sm btn-primary" name="BtnFieldListingXls"><span class="glyphicon glyphicon-print"></span> Field Listing</button>
                            <button type="button" class="btn btn-sm btn-primary" name="BtnIncentivesgXls"><span class="glyphicon glyphicon-print"></span>Incentive Report</button>
							<button name="Print" class="btn btn-sm btn-danger" onclick="return DisplayPrintForm();"><span class="glyphicon glyphicon-print"></span> Print</button>
							<!-- button name="Archive" class="btn btn-sm btn-primary" onclick="return Archive();"><span class="glyphicon glyphicon-trash"></span> Archive</button -->
						<!-- /div -->
					</div>
					
				</div>
			</div>
			<div class="row" id="CollectorsTable">
				<div class="col-lg-1" style="padding-bottom:5px;">
					<button class="btn btn-danger btn-xl" name="AddCollector">
						<span class="fa fa-plus fa-fw"></span>
						Add Collector
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