
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
				<h1 class="page-header">START | END | of day Routines</h1>
			</div>
			<!-- /.col-lg-12 -->
		</div>
		<!-- /.row -->
		<div class="row" id = "rowCrossCheckValidation">
			<div class="col-lg-6">
				<div class="panel panel-red">
					<div class="panel-heading">
						Parameter
					</div>
					
					 <form class="form-horizontal" role="form" name="DateUploaderForm" enctype="multipart/form-data">
						<div class="panel-body">
							<button class="btn btn-primary btn btn-xl" type="button" name="DataUploader">START OF DAY</button> | 
							<button class="btn btn-danger btn btn-xl" type="button" name="DataUploader">END OF DAY</button>  
							
						</div>
						<div class="panel-footer">
							</div>
					</form>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="panel panel-red">
					<div class="panel-heading">
						LOGS
					</div>
					<div class="panel-body">
						<table class="table table-bordered">
							<tr><td>No result found...</td></tr>
						</table>
					</div>
				
			</div>
		</div>
		<!-- /.row -->
		</div>
	</div>
</div>
