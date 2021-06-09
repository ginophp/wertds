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
</style>
<script>

</script>
<div id="wrapper">
<div id="page-wrapper">
            <input type = "hidden" value = "" name = "ID" />
            <div id = "listing">
    
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Users</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			<div class="row" id = "param">
				 <div class="col-lg-12">
				  <div class="panel panel-red">
							<div class="panel-footer"> 
                                <button class="btn btn-primary btn btn-xl" type="button" name = "add">
									Add Users
								</button>
							</div>
						</form>
				  </div>
				 </div>
			</div>
            <div class="row" id = "view" style = "">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Information
                        </div>
                        <div class="table-responsive">
						<table id = "fetch_data" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Position</th>
                                <th>Email</th>
                                <th>Name</th>
                                <th>CP</th>
                                <th colspan = "2">Action</th>
							</tr>
						</thead>
						<tbody>
							<tr>
                                <td colspan = "20">please wait..</td>
							</tr>
						</tbody>
						</table>
                        </div>
                        <!-- /.panel-body -->
						<div class="panel-footer"> 
								<div class = "pagination"></div>
						</div>
						
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            </div>
            <div id = "add" style="display:none;">
            
			<div class="row" id = "">
				 <div class="col-lg-8">
				  <div class="panel panel-primary">
						<div class="panel-heading">
                            Information
						</div>
						
						 <form role="form" name = "doAdd">
							<div class="panel-body">
							<div class="row">
								<div class="col-lg-10 fields">
									<div id= "Name" class="form-group">
										<label>username</label>
										<input name = "username" class="form-control" placeholder="Enter text">
										<!-- p class="help-block">Example Gino C. Leabres</p -->
									</div>
                                    <div id= "Name" class="form-group">
										<label>password</label>
										<input name = "password" class="form-control" placeholder="Enter text">
										<!-- p class="help-block">Example Gino C. Leabres</p -->
									</div>
                                    <div id= "Name" class="form-group">
										<label>position</label>
										<select class="form-control" name = "position">
                                            <option>supervisor</option>
                                            <option>operation</option>
                                        </select>
										<!-- p class="help-block">Example Gino C. Leabres</p -->
									</div>
                                    <div id= "Name" class="form-group">
										<label>Name</label>
										<input name = "Name" class="form-control" placeholder="Enter text">
										<!-- p class="help-block">Example Gino C. Leabres</p -->
									</div>
                                    <div id= "Name" class="form-group">
										<label>Email</label>
										<input name = "Email" class="form-control" placeholder="Enter text">
										<!-- p class="help-block">Example Gino C. Leabres</p -->
									</div>
                                    <div id= "Name" class="form-group">
										<label>Address</label>
										<input name = "Address"` class="form-control" placeholder="Enter text">
										<!-- p class="help-block">Example Gino C. Leabres</p -->
									</div>
                                    <div id= "Name" class="form-group">
										<label>CP</label>
										<input name = "CP" class="form-control" placeholder="Enter text">
										<!-- p class="help-block">Example Gino C. Leabres</p -->
									</div>
                                    
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
</div>
<script>
    $(document).ready(function(){
        fetchdata();
        $('body').on('focus',".datepicker", function(){
            $(this).datepicker();
        });
        
        $("[name=add]").click(function(){
            $("#add").fadeIn();
            $("#view").hide();
            $.ajax({
                url:'pages/admin/ajax/ajax.php',
                type:'post',
                data:{action:'getforms'},
                dataType:'json',
                success:function(resp){
                    var html = "";
                    for(x = 0; resp['param_handler'].length>x;x++){
                        html += resp['param_handler'][x];
                    }
                    $(".fields").html(html);
                    
                }
            })
        })
        $("[name=Cancel]").click(function(){
            $("#add").hide();
            $("#view").fadeIn();
        })
        $("[name=Save]").click(function(){
            //$("#add").hide();
            if(confirm("Are you sure want to save this account?")==true){
                $.ajax({
                    url:'pages/admin/ajax/ajax.php',
                    type:'post',
                    data:$("[name=doAdd]").serialize()+"&action=DoSave",
                    dataType:'json',
                    success:function(resp){
						 location.reload();
						 fetchdata();
						 $("#add").hide();
						 $("#view").fadeIn();
                    }
                })
            }
            return false;
            //$("#view").fadeIn();
        })
    })
    
function fetchdata(){
    
    $.ajax({
        url:'pages/admin/ajax/ajax.php',
        type:'post',
        data:{action:'fetch'},
        dataType:'json',
        success:function(resp){
            var html = "";
            var cnt = 1;
            for(x = 0; resp['data_handler'].length>x;x++){
                html += "<tr>";
                    html+="<td>"+cnt+"</td>";
                    html+="<td>"+resp['data_handler'][x].username+"</td>";
                    html+="<td>"+resp['data_handler'][x].position+"</td>";
                    html+="<td>"+resp['data_handler'][x].Email+"</td>";
                    html+="<td>"+resp['data_handler'][x].Name+"</td>";
                    html+="<td>"+resp['data_handler'][x].CP+"</td>";
                    html+="<td><a onclick='changepassword("+resp['data_handler'][x].ID+")'>Change Password</a></td>";
                html += "</tr>";
                cnt++;
            }
            $("#fetch_data").find("tbody").html(html);

        }
    })
}

function changepassword(ID){
	//alert(ID);
	if(confirm("Are you sure want to change this password?") == true){
		var msg = window.prompt("Write New Password", "");
		if (msg === null) {
			//cancel here..
		}else{
			if(msg == null || msg == ""){
				alert("Password required.");
			}else{
				$.ajax({
					url:'pages/admin/ajax/ajax.php',
					type:'post',
					data:{action:'changepassword',ID:ID,password:msg},
					dataType:'json',
					success:function(resp){
						alert(resp['message']);
						fetchdata();
					}
				});
			}
			
		}
	}
	
}

</script>