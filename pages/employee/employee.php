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
                    <h1 class="page-header">Employee</h1>
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
                            <button type="button" onclick = "return addemployee();" class="btn btn-warning">Add</button>
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
	 $('body').on('focus',".datepicker", function(){
        $(this).datepicker();
     });
})
function addemployee()
{
    var html = "";
    var ButtonList = '<button type="button" class="btn btn-info" onclick="SaveEmployee();">Save</button>'+
								 '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
    
    
    html += '<form name = "form">';
    
    html += '<div class="form-group">'+
            '<label>Emp ID</label>'+
            '<input class="form-control" name="emp_id">'+
            '</div>';
    
    html += '<div class="form-group">'+
            '<label>Last name</label>'+
            '<input class="form-control" name="last_name">'+
            '</div>';
    
    
    html += '<div class="form-group">'+
            '<label>First Name</label>'+
            '<input class="form-control" name="first_name">'+
            '</div>';
    
    
    html += '<div class="form-group">'+
            '<label>Initial</label>'+
            '<input class="form-control" name="initial_name">'+
            '</div>';
    
    
    html += '<div class="form-group" name = "gender">'+
            '<label>Gender</label>'+
            '<select class="form-control" name = "gender"><option>Male</option><option>Female</option></select>'+
            '</div>';
    
    html += '<div class="form-group" name = "">'+
            '<label>Complete Present Address</label>'+
             '<input class="form-control" name="complete_present_address">'+
            '</div>';
    
    html += '<div class="form-group" name = "">'+
            '<label>Complete Permanent Address</label>'+
             '<input class="form-control" name="complete_permanent_address">'+
            '</div>';
    
    html += '<div class="form-group" name = "">'+
            '<label>Name of Recommender</label>'+
             '<input class="form-control" name="name_of_recommender">'+
            '</div>';
    
    html += '<div class="form-group">'+
            '<label>Branch</label>'+
            '<input class="form-control" name = "branch">'+
            '</div>';
			
			
    html += '<div class="form-group">'+
            '<label>Birthday</label>'+
            '<input class="form-control" name = "birthday">'+
            '</div>';
			
    html += '<div class="form-group">'+
            '<label>Civil Status</label>'+
            '<select class="form-control" name = "civil_status"><option>Single</option><option>Married</option><option>Separated</option></select>'+
            '</div>';
			
	html += '<div class="form-group">'+
            '<label>No of children (21 and bdlow only)</label>'+
            '<input class="form-control" name = "number_of_children">'+
            '</div>';		
			
    
    html += '<div class="form-group">'+
            '<label>Department</label>'+
            '<select class="form-control" name = "department"><option>IT</option><option>Finance</option><option>Operation</option><option>Accounts</option></select>'+
            '</div>';
    
    html += '<div class="form-group">'+
            '<label>Position</label>'+
            '<input class="form-control" name = "position">'+
            '</div>';
    
    html += '<div class="form-group">'+
            '<label>Rate per day</label>'+
            '<input class="form-control" name = "salary">'+
            '</div>';
    
    html += '<div class="form-group">'+
            '<label>Overtime Rate/Hour</label>'+
            '<input class="form-control" name = "overtime_rate_hour">'+
            '</div>';
			
    
    html += '<div class="form-group">'+
            '<label>Tin</label>'+
            '<input class="form-control" name = "tin">'+
            '</div>';
			
    html += '<div class="form-group">'+
            '<label>SSS #</label>'+
            '<input class="form-control" name = "sss_number">'+
            '</div>';
			
    html += '<div class="form-group">'+
            '<label>Pagibig #</label>'+
            '<input class="form-control" name = "pag_ibig_number">'+
            '</div>';
			
    html += '<div class="form-group">'+
            '<label>Philhealth #</label>'+
            '<input class="form-control" name = "philhealth_number">'+
            '</div>';
			
    html += '<div class="form-group">'+
            '<label>PS Bank Account #</label>'+
            '<input class="form-control" name = "psbank_account_number">'+
            '</div>';
			
    html += '<div class="form-group">'+
            '<label>Date Hired</label>'+
            '<input class="form-control datepicker" name = "date_hired">'+
            '</div>';
			
    html += '<div class="form-group">'+
            '<label>Employment Status</label>'+
            '<select class="form-control" name = "employment_status"><option>Probitionary</option><option>Regular</option>'+
            '</div>';
    
    html += '</form>';
    
    $("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-md");
    $("#MyModal .modal-title").html("Add Employee");
    $("#MyModal .modal-body").html(html);
    $("#MyModal .modal-footer").html(ButtonList);
    $("#MyModal").modal('show');
     
}
function adddeductions()
{
    var html = "";
    var ButtonList = '<button type="button" class="btn btn-info" onclick="SaveEmployee();">Save</button>'+
								 '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
    
    
    html += '<form name = "form">';
    
    html += '<div class="form-group">'+
            '<label>Emp ID</label>'+
            '<input class="form-control" name="emp_id">'+
            '</div>';
    
    html += '<div class="form-group">'+
            '<label>Last name</label>'+
            '<input class="form-control" name="last_name">'+
            '</div>';
    
    
    html += '<div class="form-group">'+
            '<label>First Name</label>'+
            '<input class="form-control" name="first_name">'+
            '</div>';
    
    
    html += '<div class="form-group">'+
            '<label>Initial</label>'+
            '<input class="form-control" name="initial_name">'+
            '</div>';
    
    
    html += '<div class="form-group" name = "gender">'+
            '<label>Gender</label>'+
            '<select class="form-control" name = "gender"><option>Male</option><option>Female</option></select>'+
            '</div>';
    
    html += '<div class="form-group">'+
            '<label>Birthday</label>'+
            '<input class="form-control datepicker" name = "birthday">'+
            '</div>';
    
    html += '<div class="form-group">'+
            '<label>Department</label>'+
            '<select class="form-control" name = "department"><option>IT</option><option>Finance</option><option>Operation</option><option>Accounts</option></select>'+
            '</div>';
    
    html += '<div class="form-group">'+
            '<label>Position</label>'+
            '<input class="form-control" name = "position">'+
            '</div>';
    
    html += '<div class="form-group">'+
            '<label>Rate per day</label>'+
            '<input class="form-control" name = "salary">'+
            '</div>';
    
    html += '<div class="form-group">'+
            '<label>Overtime Rate/Hour</label>'+
            '<input class="form-control" name = "overtime_rate_hour">'+
            '</div>';
    
    html += '</form>';
    
    $("#MyModal .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").addClass("modal-md");
    $("#MyModal .modal-title").html("Add Deductions");
    $("#MyModal .modal-body").html(html);
    $("#MyModal .modal-footer").html(ButtonList);
    $("#MyModal").modal('show');
     
}
    
    
function SaveEmployee()
{
    
    
    if(confirm("Are you sure want to save this employee?")==true){
        $.ajax({
            url:'pages/employee/ajax/employee.php',
            type:'post',
            dataType:'json',
            data:$("[name=form]").serialize()+"&action=save&table=employee",
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
                    for(var x = 0; resp['data_handler'].length>x;x++){
                        html += '<tr>';
                        html += '<td>'+resp['data_handler'][x].emp_id+'</th>';
                        html += '<td>'+resp['data_handler'][x].full_name+'</th>';
                        html += '<td>'+resp['data_handler'][x].gender+'</th>';
                        html += '<td>'+resp['data_handler'][x].birthday+'</th>';
                        html += '<td>'+resp['data_handler'][x].department+'</th>';
                        html += '<td>'+resp['data_handler'][x].position+'</th>';
                        html += '<td><a class="fa fa-user" onclick = "return viewdetails('+resp['data_handler'][x].ID+')"> View Details</a></th>';
                        html += '<td><a class="fa fa-edit" onclick = "return adddeductions('+resp['data_handler'][x].ID+')"> Add Deduction</a></th>';
                        html += '<td><a class="fa fa-edit" onclick = "return viewdetails('+resp['data_handler'][x].ID+')"> Edit Information</a> </th>';
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
    
function viewdetails(id){
    addemployee();
    var ButtonList = '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';  
    $("#MyModal .modal-footer").html(ButtonList);
    $("#MyModal .modal-title").html("View Employee");
    $("[name=form] input").attr("readonly","readonly");
    
    $.ajax({
        type	:	"post",
        dataType:	"json",
        url		:	"pages/employee/ajax/employee.php",
        data	:	{action : "fetchbiid",  table : 'employee',ID:id},
        success	:	function(resp){
            
            var emp_id              = resp['data_handler'][0].emp_id;
            var last_name           = resp['data_handler'][0].last_name;
            var first_name           = resp['data_handler'][0].first_name;
            var initial_name        = resp['data_handler'][0].initial_name;  
            var gender              = resp['data_handler'][0].gender;
            var birthday            = resp['data_handler'][0].birthday;
            var department          = resp['data_handler'][0].department;
            var position            = resp['data_handler'][0].position;
            var salary              = resp['data_handler'][0].salary;
            var overtime_rate_hour  = resp['data_handler'][0].overtime_rate_hour; 
            
            $("[name = emp_id]").val(emp_id);
            $("[name = last_name]").val(last_name);
            $("[name = first_name]").val(first_name);
            $("[name = initial_name]").val(initial_name);
            $("[name = gender]").val(gender);
            $("[name = birthday]").val(birthday);
            $("[name = department]").val(department);
            $("[name = position]").val(position);
            $("[name = salary]").val(salary);
            $("[name = overtime_rate_hour]").val(overtime_rate_hour);
        
        }
    });
    
    return false;
}
</script>