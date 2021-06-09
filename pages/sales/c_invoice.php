div id="wrapper">
	<div id="page-wrapper">
        <div id="listingmediaserver">
    
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">CREATE INVOICE</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			<form name = "AddEmployee">
			<div class="row" id="CollectorsTable">
				
				<div class="col-lg-12">
					
					<div class="panel panel-primary">
					
						<div class="panel-heading">Information</div>
							<!-- DEALER INFORMATION -->
							<div class="panel-body">
									<div class="col-lg-6">
					
										<div class="panel panel-danger">
										
											<div class="panel-heading">DEALER INFORMATION</div>
												
												<div class="panel-body">
												
														<table class="table table-striped table-bordered table-hover">
																<tbody>
																
																
																<tr>
																	
																	<td width="50%">DEALER</td>
																	<td>
																	
																	<select onchange = "change_dealer()" class = "form-control" name = "dealer">
																		<option value = 0>[SELECT HERE]</option>
																	
																	<?php
																		$q = $mysqli->query("SELECT dealer.*,CONCAT(dd.`first_name`,' ' ,dd.`middle_name`,' ', dd.`last_name`) mother_name 
																							FROM dealer
																							 LEFT JOIN  dealer dd ON dd.id = dealer.`Mother_ID` order by dealer.first_name asc ");
																							 
																		while($r = $q->fetch_object()){
																			echo "<option value = '{$r->id}'
																			data-address = '{$r->primary_address}'
																			data-mobile = '{$r->mobile_number}'
																			data-creditlimit = '{$r->credit_limit}'
																			data-mother_name = '{$r->mother_name}'
																			>{$r->first_name} {$r->middle_name} {$r->last_name}</option>";
																		}					 
																	?>
																	
																	
																	</select>
																	
																	</td>
																</tr>
																<tr>
																	<td>MOTHER ID</td>
																	<td><input readonly="" class="form-control" type="text" value="" name="mother_name" id=""></td>
																</tr>
																<tr>
																	<td>USER TRANSACTION</td>
																	<td><input readonly="" class="form-control" type="text" value="<?=$_SESSION['username'];?>" name="" id=""></td>
																</tr>
																<tr>
																	<td>AVAILABLE CREDIT LIMIT</td>
																	<td><input readonly="" class="form-control" type="text" value="" name="creditlimit" id=""></td>
																</tr>
																<tr>
																	<td>DELIVERY DATE</td>
																	<td><input readonly="" class="form-control datepicker " type="text" value="<?=date("Y-m-d")?>" name="delivery_date" id=""></td>
																</tr>
																
																</tbody>
														</table>
														
												</div>
											
											<div class="panel-footer"> 
												
											</div>
										
										</div>
									</div>
									<div class="col-lg-6">
					
										<div class="panel panel-danger">
										
											<div class="panel-heading">INVOICE SUMMARY</div>
												
												<div class="panel-body">
														
														<table class="table table-striped table-bordered table-hover">
																	<tbody>
																	<tr>
																		<td width="50%">GROSS AMOUNT</td>
																		<td><input readonly="" class="form-control" type="text" value="" name="total_price" id=""></td>
																	</tr>
																	<tr>
																		<td>DEALER DISCOUNT</td>
																		<td><input readonly="" class="form-control" type="text" value="" name="dealer_discount" id=""></td>
																	</tr>
																	
																	</tbody>
															</table>
														
													<div class="panel-footer"> 
														<button type="button" class="btn btn-danger" onclick="doSave();">REFRESH CL SAVE and Print</button>
													</div>	
												</div>
										
										</div>
									</div>
							
									
						</div>
							<!-- INVOICE DETAILS -->
							<div class="panel-body">
							
									<div class="col-lg-12">
					
										<div class="panel panel-success">
										
											<div class="panel-heading">INVOICE DETAILS</div>
												
												<table id="fetch_data_so_details" class="table table-striped table-bordered table-hover">
																<thead><tr class="warning"><th width = "10%">PRODUCT</th><th width = "50%">PRODUCT DESCRIPTION</th><th>PROMO CODE</th><th>QTY</th><th>UNIT PRICE</th><th>SUB TOTAL</th><th>ACTION</th></tr>
																	</thead>
																	<tbody>
																	<tr id = "rec-0" class = 'rec' style = "display:none;">
																		<td>
																			<input readonly="" class="form-control" type="text" value="" name="product[]" id="product">
																			
																		</td>
																		<td>
																		<input readonly="" class="form-control" type="text" value="" name="product_description[]" id="product_description">
																		</td>
																		<td>
																		<input readonly="" class="form-control" type="text" value="" name="promo_code[]" id="promo_code"></td><td>
																		<input readonly onkeypress="add_line(event,1)" class="form-control" type="text" value="" name="qty[]" id="qty"></td>
																		<td><input readonly="" class="form-control" type="text" value="" name="unit_price[]" id="unit_price"></td>
																		<td><input readonly="" class="form-control" type="text" value="" name="sub_total[]" id="sub_total"></td>
																		<td><a class="btn btn-xs delete-record" data-id="0"><i class="glyphicon glyphicon-trash"></i></a></td>
																	</tr>
																	
																	</tbody>
												</table>
											<div class="panel-footer"> 
												<ul class="pagination" style="margin:0;"></ul>
											</div>
										
										</div>
									</div>
							</div>
						
						<div class="panel-footer"> 
							<ul class="pagination" style="margin:0;"></ul>
						</div>
					
					</div>
				</div>
				
				<div class="col-lg-12">
					
					<div class="panel panel-primary">
					
						<div class="panel-heading">Information</div>
						

					
						<div class="panel-body">
						
									<input onkeypress="" class="form-control" type="text" placeholder = "search barcode - product" value="" id="txt_name" id="">
									<div class="col-lg-12" style = "height:400px;
    overflow:scroll;
" >
										

										<table id="list_of_products" class="table table-striped table-bordered table-hover" >										
										
													<thead>
														<tr>
															<th>BARCODE</th>
															<th>PRODUCT DESCRIPTION</th>
															<th>PROMO CODE</th>
															<th>PRICE</th>
														</tr>
													</thead>
													<tbody>
													
														<?php
															$q = $mysqli->query("select * from product");
															if($q->num_rows > 0){
																while($r = $q->fetch_object()){
																	
																	//promo..
																	$promo = $mysqli->query("select * from promo 
																	 where curdate() between date(date_start) and date(date_end) 
																	 and promo_type = 'SINGLE LINE' and product = '{$r->code}'");

																	$r->promo_code = "N/A";
																	if($promo->num_rows > 0){
																	$promo_fetch 		 = $promo->fetch_object();
																		$r->price		 = $promo_fetch->price;
																		$r->promo_code	 = $promo_fetch->promo_code;
																	}

																	echo "<tr id = 'info'>
																				<td> {$r->code }</td>
																				<td>".strtoupper($r->description)."</td>
																				<td>".strtoupper($r->promo_code)."</td>
																				<td> {$r->price }</td>
																				
																			</tr>";
																}
															}
															
															// for set promo...
															$promo_set = $mysqli->query("select * from promo where promo_condition = 'SET' and curdate() between date_start and date_end");
															if($promo_set->num_rows > 0){
																
																while($promo_set_rows =  $promo_set->fetch_object()){
																	echo "<tr id = 'info'>
																				<td> {$promo_set_rows->promo_code }</td>
																				<td>".strtoupper($promo_set_rows->promo_description)."</td>
																				<td>".strtoupper($promo_set_rows->promo_code)."</td>
																				<td> {$promo_set_rows->price }</td>
																				
																			</tr>";
																	
																	
																}
															}
															
															
															// for b1t1 promo...
															$promo_set = $mysqli->query("SELECT *,
															(SELECT promob1t1.qty * price FROM product WHERE `code` = promob1t1.product) price
															FROM promob1t1 WHERE  CURDATE() BETWEEN date_start AND date_end");
															if($promo_set->num_rows > 0){
																
																while($promo_set_rows =  $promo_set->fetch_object()){
																	
																			
																			echo "<tr id = 'info'>
																				<td> {$promo_set_rows->promo_code }</td>
																				<td>".strtoupper($promo_set_rows->promo_description)."</td>
																				<td>".strtoupper($promo_set_rows->promo_code)."</td>
																				<td> {$promo_set_rows->price }</td>
																				
																			</tr>";
																			
																}
															}
															
															
														?>
														<!--In your case this is auto-generated-->
														<!-- Display this <tr> when no record found while search -->
													   <tr class='notfound'>
														 <td colspan='4'>No record found</td>
													   </tr>
													
													</tbody>
												
										
										</div>
						</div>
						</div>	
						<div class="panel-footer"> 
							<ul class="pagination" style="margin:0;"></ul>
						</div>
					
					</div>
				</div>
			</form>
			</div>
			
		</div>
		

		
	</div>
</div>
<script>
var rows = document.getElementById("list_of_products").children[1].children;
var selectedRow = 0;



$(document).ready(function(){
	
		$(".datepicker").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'yy-mm-dd',
			yearRange: "1000:2020"
		
		});
	
	  // Search on name column only
	  $('#txt_name').keyup(function(){
		// alert('x');
		// Search Text
		var search = $(this).val();

		// Hide all table tbody rows
		$('#list_of_products tbody tr').hide();

		// Count total search result
		var len = $('#list_of_products tbody tr:not(.notfound) td:nth-child(2):contains("'+search+'")').length;
		
		//alert(len);
		
		
		if(len > 0){
		  // Searching text in columns and show match row
		  $('#list_of_products  tbody tr:not(.notfound) td:contains("'+search+'")').each(function(){
			 $(this).closest('tr').show();
		  });
		}else{
		  $('.notfound').show();
		}

	  });
	  
	  
	  $(document).delegate('a.delete-record', 'click', function(e) {
		 e.preventDefault();    
		 var didConfirm = confirm("Are you sure You want to delete");
		 if (didConfirm == true) {
			var id = $(this).attr('data-id');
			var targetDiv = $(this).attr('targetDiv');
			$('#rec-' + id).remove();
		 }
		 calculate_sales();
		});


})
	
document.body.onkeydown = function(e){
	
		
		// f2 for any any promo..
		
		if(e.keyCode==113){
			
			
			
			 $.ajax({
				type	:	"post",
				url		:	"pages/hr/ajax/proccess.php",
				dataType:	"json",
				// data	:	{action : "Pagination", page : page, Table : 'employee'},
				data	:	{action:'ANY_PROMO'},
				success	:	function(data){
					
					
					var html1 =''
					// html1 +='<tr ALIGN = "center"><td >PROMO SAMPLE</td><td >PROMO SAMPLE</td><td >PROMO SAMPLE</td><td >PROMO SAMPLE</td><td >PROMO SAMPLE</td><td >PROMO SAMPLE</td></tr>'


					
					if(data['response'] == 'success'){
						//alert(x);//
						for(var x = 0;data['promo_header'].length > x; x++){
							
							 html1 +='<tr ALIGN = "center"><th colspan = 6 style = "text-align: center;">'+data['promo_header'][x].promo_description+' ANY '+data['promo_header'][x].any+'</th></tr>'
							 
							 for(var y = 0;data['promo_header_details'][data['promo_header'][x].id].length > y; y++){
								
								var c_value = '"'+data['promo_header_details'][data['promo_header'][x].id][y].product_code+
								'|'+data['promo_header_details'][data['promo_header'][x].id][y].description+
								'|'+data['promo_header_details'][data['promo_header'][x].id][y].promo_code+
								'|'+data['promo_header_details'][data['promo_header'][x].id][y].price_per_item+'"';
								 html1 +='<tr ALIGN = "center">'+
										'<td><input type = "checkbox" name = "anypromo" value = '+c_value+'></td>'+
										'<td>'+data['promo_header_details'][data['promo_header'][x].id][y].product_code+'</td>'+
										'<td>'+data['promo_header_details'][data['promo_header'][x].id][y].description+'</td>'+
										'<td>'+data['promo_header_details'][data['promo_header'][x].id][y].promo_code+'</td>'+
										'<td>'+data['promo_header_details'][data['promo_header'][x].id][y].price_per_item+'</td>'+
										'</tr>';
							 }
							 
						}
					}
					
					
					html = '<div class="col-lg-12">'+
						'<div class="panel panel-primary">'+			
						'<div class="panel-heading">PROMO DETAILS</div>'+
						'<div class="table-responsive">'+
						'<table border=1 id = "data_promisetopay" class="table table-striped table-bordered table-hover">'+
							html1+
						'</table>'+
						'</div>'+
						'<div class="panel-footer"> '+
						'<ul class="pagination" style="margin:0;"></ul>'+
						'</div>'+
						'</div>'+
						'</div>';
					 var ButtonList = '<button type="button" class="btn btn-info" onclick="doProcessAny();">Save</button>'+
								 '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
					$("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-lg");
					$("#MyModal .modal-title").html("ANY PROMO..");
					$("#MyModal .modal-body").html(html);
					$("#MyModal .modal-footer").html(ButtonList);
					$("#MyModal").modal('show');
				}
			  });
			
			
			
		}
		
		
		
	
		$("#list_of_products").find("tr").css("backgroundColor","#FFFFFF");
		var key_arrows_validated = 0;
        //Prevent page scrolling on keypress
        //e.preventDefault();
        //Clear out old row's color
        rows[selectedRow].style.backgroundColor = "#FFFFFF";
        //Calculate new row
        if(e.keyCode == 38){
            selectedRow--;
        } else if(e.keyCode == 40){
            selectedRow++;
			key_arrows_validated++;
        }
        if(selectedRow >= rows.length){
            selectedRow = 0;
        } else if(selectedRow < 0){
            selectedRow = rows.length-1;
			key_arrows_validated++;
        }
        //Set new row's color
        rows[selectedRow].style.backgroundColor = "#8888FF";
		
		var sample = rows[selectedRow].innerText;
		var value_of_table = sample.replace(/\	/g, '|');
			
			//alert(x);
			// this function is executed for all 'code' elements, and
			// 'this' refers to one element from the set of all 'code'
			// elements each time it is called.
		
		
		if(key_arrows_validated==0){
			if(e.keyCode == 13){
				alert(value_of_table);
			}
		}
	
		
		
		
		
    };
    //Set the first row to selected color
    rows[0].style.backgroundColor = "#8888FF";
	
	
	
$("tr#info td").click(function(e){     //function_td

$("#list_of_products").find("tr").css("backgroundColor","#FFFFFF");
$(this).closest('tr').css("backgroundColor","#8888FF");

var x = $.trim($(this).closest('tr').text());


var y  = $.trim(x.replace(/[\t\n]+/g,'|'));


var person = prompt("Please Fillup Qty for "+y);

if (person == null || person == "") {
  txt = "User cancelled the prompt.";
} else {
  
  

  
	
     var content = jQuery('#fetch_data_so_details #rec-0'),
	 size = jQuery('#fetch_data_so_details >tbody >tr').length,
     element = null,    
     element = content.clone();
	 
	 //alert(content.html());
	 
     element.attr('id', 'rec-'+size);
     element.find('.delete-record').attr('data-id', size);
     element.appendTo('#fetch_data_so_details');
	 result= y.split('|');
	 
	 // $('#rec-'+size+" #product").html(y[0]);
	 $('#rec-'+size+" #product").val(result[0]);
	 $('#rec-'+size+" #product_description").val(result[1]);
	 $('#rec-'+size+" #qty").val(person);
	 $('#rec-'+size+" #promo_code").val(result[2]);
	 $('#rec-'+size+" #unit_price").val(result[3]);
	 
	 var sub_total = parseFloat(person) * parseFloat(result[3]);
	  $('#rec-'+size+" #sub_total").val(sub_total);
	 
	 $('#rec-'+size).show();
	 
	 //CALCULATE SALES ..
	 
	 calculate_sales();
	 
     //element.find('.sn').html(size);
  
  	
}


//var value_of_table = x.replace(/\	/g, '|');

return false;
//e.stopPropagation();
});

function calculate_sales()
{
	var GrossAmount 	= 0;
	var DealerDiscount = 0;
	
	// alert("calculate_sales");
	$(".rec").each(function(){
		if($(this).find("#sub_total").val() != ""){
			GrossAmount = parseFloat(GrossAmount) + parseFloat($(this).find("#sub_total").val());
		}
	});
	$("[name=total_price]").val(GrossAmount);
	DealerDiscount = parseFloat(GrossAmount) * .20; 
	$("[name=dealer_discount]").val(DealerDiscount);
	//DealerDiscount = parseFloat(GrossAmount) * .20; 
	//net_amount
	//alert(DealerDiscount);
}	
	
function change_dealer(){
			// alert($("[name=dealer]").find(":selected").data("details"));
			
			// alert($("[name=dealer]").find("selected").toSource());
			// alert($("[name=dealer]").find("selected").val());
			
			// $("[name=dealer]").each(function( index, value ) {
			  // alert( index + ": " + value );
			// });
			
			
			if($("[name=dealer]").find(":selected").data("creditlimit") == '0'){
				alert('Credit Limit has already exceed. please create a payment for other transaction');
				$("[name=dealer]").val("");
				//$("#information_details").html("");
				return false;
			}
			//$("#information_details").html($("[name=dealer]").find(":selected").data("details"));
			
			$("[name=creditlimit]").val($("[name=dealer]").find(":selected").data("creditlimit"));
			$("[name=mother_name]").val($("[name=dealer]").find(":selected").data("mother_name"));
			
}

function doProcessAny()
{
	if(confirm("are u sure of this any promo?")==true){
		var person = 1;
		$("input:checkbox[name=anypromo]:checked").each(function(){
			// alert();
			var content = jQuery('#fetch_data_so_details #rec-0'),
			 size = jQuery('#fetch_data_so_details >tbody >tr').length,
			 element = null,    
			 element = content.clone();
			 
			 //alert(content.html());
			 
			 element.attr('id', 'rec-'+size);
			 element.find('.delete-record').attr('data-id', size);
			 element.appendTo('#fetch_data_so_details');
			 result= $(this).val().split('|');
			 
			 // $('#rec-'+size+" #product").html(y[0]);
			 $('#rec-'+size+" #product").val(result[0]);
			 $('#rec-'+size+" #product_description").val(result[1]);
			 $('#rec-'+size+" #qty").val(person);
			 $('#rec-'+size+" #promo_code").val(result[2]);
			 $('#rec-'+size+" #unit_price").val(result[3]);
			 
			 var sub_total = parseFloat(person) * parseFloat(result[3]);
			  $('#rec-'+size+" #sub_total").val(sub_total);
			 
			 $('#rec-'+size).show();
			 
			 //CALCULATE SALES ..
			 
			 calculate_sales();
			 
			 //element.find('.sn').html(size);
			
		});
		$("#MyModal").modal('hide');

	}
	
	
}




 function doSave()
    {
		
		// total_price
		// alert($("[name=dealer]").find(":selected").data("creditlimit"));
        var dgs_amount = (parseFloat($("[name=total_price]").val())) - (parseFloat($("[name=total_price]").val()) * .20);
		// if()
		// alert(parseFlqoat($("[name=dealer]").find(":selected").data("creditlimit"))+" < "+parseFloat(dgs_amount));
		// return false; 
		var error_msg = "";
		// if(parseFloat($("[name=dealer]").find(":selected").data("creditlimit")) < parseFloat(dgs_amount)){
			// error_msg += "Credit Limit has already exceed. please create a payment for other transaction \n";
			// error_msg += "DGS :"+dgs_amount+" \n";
			// error_msg += "AVAILABLE CREDIT LIMIT :"+$("[name=dealer]").find(":selected").data("creditlimit")+" \n";
			
			// alert(error_msg);
			// return false;
		// }
		
		if(confirm("Are you sure want to save?")==true){
            $.ajax({
			type	:	"post",
			url		:	"pages/hr/ajax/proccess.php",
			dataType:	"json",
			// data	:	{action : "Pagination", page : page, Table : 'employee'},
			data	:	$("[name=AddEmployee]").serialize()+"&action=Save&Table=so",
			success	:	function(data){
              
				
				if(data['id'] == 0){
					alert('Credit Limit has already exceed. please create a payment for other transaction');
					return false;
				}else{
					window.open('pages/generate_si.php?id='+data['id'],'TheWindow', 'scrollbars=1,resizable=1,width='+window.outerWidth+',height='+window.outerHeight+',left=0,top=0');
					location.reload();
				}	
			}
		  });
        }
}


</script>

<style>
.notfound{
  display: none;
}
</style>