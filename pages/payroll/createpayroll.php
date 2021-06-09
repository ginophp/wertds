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
                    <h1 class="page-header">Payroll</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
			<div class="row" id="">
                
				<div class="col-lg-12">
					
					<div class="panel panel-primary">
						<div class="panel-heading">Parameters</div>
                        <div class="panel-body">
                            <div class="form-group">
                                    <label>Emp ID</label>
                                    <input class="form-control">
                                    <p class="help-block">Note: Search Employee ID Keywords</p>
                            </div>
                        </div>
						  
                            
						
						<div class="panel-footer"> 
                            <button type="button" class="btn btn-danger">Search</button>
                            <!-- button type="button" onclick = "return addemployee();" class="btn btn-warning">Add</button -->
                            <!-- button type="button" class="btn btn-primary">Add Deductions</button -->
						</div>
					
					</div>
				</div>
				
			</div>
			
			<div class="row" id="">
				<div class="col-lg-12">
					
					<div class="panel panel-primary" id = "data">
					
						<div class="panel-heading">Information</div>
						
                        <div class="table-responsive">
							<table class="table table-striped table-bordered table-hover">
								<thead>
                                <tr>
                                    <th>EmpID</th>
                                    <th>Full Name</th>
                                    <th>Gender</th>
                                    <th>Birthday</th>
                                    <th>Department</th>
                                    <th>Position</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td align="center" colspan="10">Fetching Data Loading... Please wait...</td>
                                    </tr>
                                </tbody>
                                
							</table>
						</div>
						
						<div class="panel-footer"> 
							<ul class="pagination" style="margin:0;"></ul>
						</div>
					
					</div>
				</div>
				
			</div>
            <!-- /.row -->
        </div>
	</div>
    <!-- /#wrapper -->
</div>
<script>
$(document).ready(function(){
    showPage(1);
})
function addentry(ID)
{
    var html = "";
    var ButtonList = '<button type="button" class="btn btn-info" onclick="save_entry_payroll();">Save</button>'+
								 '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
    
    
    html += '<form name = "form">';
    
    html += '<div class="form-group">'+
            '<label>Emp ID</label>'+
            '<input class="form-control" name="emp_id" value = "'+ID+'" readonly>'+
            '</div>';
    
    html += '<div class="form-group">'+
            '<label>Days Work</label>'+
            '<input class="form-control" name="days_work">'+
            '</div>';
    
    
    html += '<div class="form-group">'+
            '<label>OT Hours</label>'+
            '<input class="form-control" name="ot_hours">'+
            '</div>';
    
    
    html += '<div class="form-group">'+
            '<label>Allowances</label>'+
            '<input class="form-control" name="allowances">'+
            '</div>';
    
    
    html += '<div class="form-group" name = "gender">'+
            '<label>Advances</label>'+
            '<input class="form-control" name="advances">'+
            '</div>';
    
    
    html += '<div class="form-group" name = "gender">'+
            '<label>Paluwagan</label>'+
            '<input class="form-control" name="paluwagan">'+
            '</div>';
    
    html += '<div class="form-group">'+
            '<label>Date Period From </label>'+
            '<input class="form-control datepicker" name="date_from">'+
            '</div>';
    
    html += '<div class="form-group">'+
            '<label>Date Period To </label>'+
            '<input class="form-control datepicker" name="date_to">'+
            '</div>';

    html += '</form>';
    
    $("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-md");
    $("#MyModal .modal-title").html("Add Payroll Entry");
    $("#MyModal .modal-body").html(html);
    $("#MyModal .modal-footer").html(ButtonList);
    $("#MyModal").modal('show');
    
    $("[name=date_from], [name=date_to]").datepicker({
					changeYear	:	true,
					changeMonth	:	true,
					maxDate		:	0	
        });
     
}
    
function printpayroll(ID)
{
    var html = "";
    var ButtonList = '<button type="button" class="btn btn-info" onclick="print_payroll();">Save</button>'+
								 '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
    
    $.ajax({
			type	:	"post",
			dataType:	"json",
			url		:	"pages/payroll/ajax/payroll.php",
			data	:	{action : "getpayroll",ID:ID, table : 'payroll'},
			success	:	function(resp){
                html += '<form name = "form">';
                html +='        <div class="table-responsive">';
                html +='            <table class="table table-striped table-bordered table-hover">';
                html +='                <thead>';
                html +='                <tr>';
                html +='                    <th>#</th>';
                html +='                    <th>Action</th>';
                html +='                    <th>Emp ID</th>';
                html +='                    <th>Date To</th>';
                html +='                    <th>Date To</th>';
                html +='                </tr>';
                html +='                </thead>';
                html +='                <tbody>';
                
                
               if(resp['resp'] == 'success'){
                   y=1;
                   for(var x=0;resp['data_handler'].length>x;x++){
                        html +='                    <tr>';
                        html +='                        <td align="center">'+y+'</td>';
                        html +='                        <td align="center"><input type = "checkbox" name = "ID[]" value = "'+resp['data_handler'][x].ID+'" /></td>';
                        html +='                        <td align="center">'+resp['data_handler'][x].emp_id+'</td>';
                        html +='                        <td align="center">'+resp['data_handler'][x].date_from+'</td>';
                        html +='                        <td align="center">'+resp['data_handler'][x].date_to+'</td>';
                        html +='                    </tr>';
                        y++
                   }
               }else{
                        html +='                    <tr>';
                        html +='                        <td align="center" colspan="11">No Record Found(s).</td>';
                        html +='                    </tr>';

               }
           
                
                html +='                </tbody>';
                html +='        </table>';
                html +='</div>';

                html += '</form>';

                $("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-md");
                $("#MyModal .modal-title").html("Print Payroll");
                $("#MyModal .modal-body").html(html);
                $("#MyModal .modal-footer").html(ButtonList);
                $("#MyModal").modal('show');
            }
    })
    
    

     
}
    
    
function save_entry_payroll()
{
    if(confirm("Are you sure want to save this payroll?")==true){
        $.ajax({
            url:'pages/payroll/ajax/payroll.php',
            type:'post',
            dataType:'json',
            data:$("[name=form]").serialize()+"&action=save&table=payroll",
            success:function(resp){
               $("#MyModal").modal('hide');
            }
        })
    }
    return false;
}
    
function showPage(page){
		//alert(page);
		$.ajax({
			type	:	"post",
			dataType:	"json",
			url		:	"pages/employee/ajax/employee.php",
			data	:	{action : "fetch", page : page, table : 'employee'},
			success	:	function(resp){
                var html = "";
                if(resp['resp']=='success'){
                    var emp_id = "";
                    for(var x = 0; resp['data_handler'].length>x;x++){
                        emp_id = "'"+resp['data_handler'][x].emp_id+"'";
                        html += '<tr>';
                        html += '<td>'+resp['data_handler'][x].emp_id+'</th>';
                        html += '<td>'+resp['data_handler'][x].full_name+'</th>';
                        html += '<td>'+resp['data_handler'][x].gender+'</th>';
                        html += '<td>'+resp['data_handler'][x].birthday+'</th>';
                        html += '<td>'+resp['data_handler'][x].department+'</th>';
                        html += '<td>'+resp['data_handler'][x].position+'</th>';
                        html += '<td><a class="fa fa-user" onclick = "return addentry('+emp_id+')"> Add Payroll Entry</a></th>';
                        html += '<td><a class="fa fa-print" onclick = "return printpayroll('+emp_id+')"> Print</a></th>';
                        html += '</tr>';
                    }
                    $("#data .table").find("tbody").html(html);
                    $("#data .panel-footer").html(resp.Pagination);
                }else{
                    
                }
                
				
			}
		});
		
        return false;
}
    
function print_payroll(){
    alert('x');
    $("[name=form]").attr("method","post");
    $("[name=form]").attr("action",'pages/payroll/ajax/report.php?action=printpayroll');
    $("[name=form]").attr("target","TheWindow");
    window.open('','TheWindow', 'scrollbars=1,resizable=1,width='+window.outerWidth+',height='+window.outerHeight+',left=0,top=0');
    $("[name=form]").submit();
     $("#MyModal").modal('hide');
    return false;
}
    

</script>