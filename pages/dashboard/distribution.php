<script>
var date = "<?=date("mdY");?>";
</script>
<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
           
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> LTO Monitoring 6 months notification
                            <div class="pull-right">
                                <div class="btn-group">
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table id = "birthday" class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Code</th>
                                                    <th>Name</th>
                                                    <th>LTO</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- tr>
                                                    <td>3326</td>
                                                    <td>10/21/2013</td>
                                                    <td>3:29 PM</td>
                                                    <td>$321.33</td>
                                                </tr>
                                                <tr>
                                                    <td>3325</td>
                                                    <td>10/21/2013</td>
                                                    <td>3:20 PM</td>
                                                    <td>$234.34</td>
                                                </tr>
                                                <tr>
                                                    <td>3324</td>
                                                    <td>10/21/2013</td>
                                                    <td>3:03 PM</td>
                                                    <td>$724.17</td>
                                                </tr>
                                                <tr>
                                                    <td>3323</td>
                                                    <td>10/21/2013</td>
                                                    <td>3:00 PM</td>
                                                    <td>$23.71</td>
                                                </tr>
                                                <tr>
                                                    <td>3322</td>
                                                    <td>10/21/2013</td>
                                                    <td>2:49 PM</td>
                                                    <td>$8345.23</td>
                                                </tr>
                                                <tr>
                                                    <td>3321</td>
                                                    <td>10/21/2013</td>
                                                    <td>2:23 PM</td>
                                                    <td>$245.12</td>
                                                </tr>
                                                <tr>
                                                    <td>3320</td>
                                                    <td>10/21/2013</td>
                                                    <td>2:15 PM</td>
                                                    <td>$5663.54</td>
                                                </tr>
                                                <tr>
                                                    <td>3319</td>
                                                    <td>10/21/2013</td>
                                                    <td>2:13 PM</td>
                                                    <td>$943.45</td>
                                                </tr -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.col-lg-4 (nested) -->
                                <div class="col-lg-8">
                                    <div id="morris-bar-chart"></div>
                                </div>
                                <!-- /.col-lg-8 (nested) -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    
                    <!-- /.panel -->
                </div>
                
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
<!-- Morris Charts JavaScript -->
<script src="bower_components/raphael/raphael-min.js"></script>
<script src="bower_components/morrisjs/morris.min.js"></script>
<script type="text/javascript" src="js/chat.js"></script>

<!-- link rel="stylesheet" type="text/css" href="library/clocklibrary/styles.css" / -->
<link rel="stylesheet" type="text/css" href="library/clocklibrary/jquery.tzineClock/jquery.tzineClock.css" />
<script type="text/javascript" src="library/clocklibrary/jquery.tzineClock/jquery.tzineClock.js"></script>
<script type="text/javascript" src="library/clocklibrary/script.js"></script>

<!-- Calculator -->
<!-- link rel="stylesheet" type="text/css" href="library/calculator/reset.css" -->
<link rel="stylesheet" type="text/css" href="library/calculator/main.css">
<script type="text/javascript" src="library/calculator/calculator.js"></script>


<!-- script src="js/morris-data.js"></script -->

<script>
	$(document).ready(function(){
		getBirthdays();
	});
	
	function getBirthdays()
	{
		var html = "";
		$.ajax({
			url:'pages/hr/ajax/dashboard.php',
			type:'post',
			dataType:'json',
			data:{action:'birthdays'},
			success:function(resp){
				if(resp['response'] == 'success'){
					for(var x = 0; resp['data_handler'].length > x; x++){
						html += '<tr align = "center">';
						html += '<td>'+x+'</td>';
						html += '<td>'+resp['data_handler'][x].company_id_no+'</td>';
						html += '<td>'+resp['data_handler'][x].first_name+' '+resp['data_handler'][x].middle_name+'. '+resp['data_handler'][x].last_name+'</td>';
						html += '<td>'+resp['data_handler'][x].account+'</td>';
						html += '<td>'+resp['data_handler'][x].birthdate+'</td>';
						html += '<td>'+resp['data_handler'][x].age+'</td>';
						html += '</tr>';
					}
				}else{
					html += '<tr align = "center">';
					html += '<td colspan = 10>'+resp['message']+'</td>';
					html += '</tr>';
				}
				$("#birthday").find("tbody").html(html);
			}
		})
	}
</script>
