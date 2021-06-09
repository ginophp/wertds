<script>
var date = "<?=date("mdY");?>";
</script>
<div id="page-wrapper" style="min-height: 268px;">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-clock-o fa-fw"></i> Clock
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <!-- Calculator Starts Here .. -->
                            <div id="fancyClock"></div>
                            <!-- div class="datepicker"></div -->
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-asterisk"></i> 
                        </div>
                        <div class="panel-body">
                      
                        </div>
                    </div>
                    <!-- /.panel -->
                    <div class="chat-panel panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-comments fa-fw"></i>
                            Chat
                            <div class="btn-group pull-right">
                                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-chevron-down"></i>
                                </button>
                                <ul class="dropdown-menu slidedown">
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-refresh fa-fw"></i> Refresh
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <ul class="chat" id = "chat-area">
                                <!-- li class="left clearfix">
                                    <span class="chat-img pull-left">
                                        <img src="http://placehold.it/50/55C1E7/fff" alt="User Avatar" class="img-circle">
                                    </span>
                                    <div class="chat-body clearfix">
                                        <div class="header">
                                            <strong class="primary-font">Supervisor</strong>
                                        </div>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales.
                                        </p>
                                    </div>
                                </li  -->
                                <!-- li class="left clearfix">
                                    <span class="chat-img pull-left">
                                        <img src="http://placehold.it/50/006D32/fff" alt="User Avatar" class="img-circle">
                                    </span>
                                    <div class="chat-body clearfix">
                                        <div class="header">
                                            <strong class="primary-font">Operation</strong>
                                        </div>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales.
                                        </p>
                                    </div>
                                </li -->
                                <!-- li class="left clearfix">
                                    <span class="chat-img pull-left">
                                        <img src="http://placehold.it/50/F00/fff" alt="User Avatar" class="img-circle">
                                    </span>
                                    <div class="chat-body clearfix">
                                        <div class="header">
                                            <strong class="primary-font">Admin</strong>
                                        </div>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales.
                                        </p>
                                    </div>
                                </li -->
                            </ul>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
                            <textarea id="sendie" class = "form-control" maxlength = '100' ></textarea>
                                
                        </div>
                        <!-- /.panel-footer -->
                    </div>
                    <!-- /.panel .chat-panel -->
                </div>
                <div class="col-lg-4">
                    
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-calendar fa-fw"></i> Calendar
                        </div>
                        <div class="panel-body">
                            <div class="datepicker"></div>
                        </div>
                    </div>
                    <!-- /.panel -->
                    <div class="panel panel-default">
                       <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> As of <?=date('m/d/Y'); ?> Results
                        </div>
                        <div class="panel-body">
                            <div id="morris-donut-chart"></div>
                            <a href="#" class="btn btn-default btn-block">View Details</a>
                        </div>
                    </div>
                    <!-- /.panel -->
                    <div class="panel panel-default">
                       <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Scanned Results Today <?=date("m/d/Y");?>
                        </div>
                        <div class="panel-body ScannedResultToday">
                            <div class="table-responsive">
							<table id = "ScannedResultToday" class="table table-striped table-bordered table-hover">
								<thead>
								<tr>
									<td>Ops Name</td>
									<td>Schedule</td>
									<td>Positive</td>
									<td>Negative</td>
								</tr>
								</thead>
								<tbody>
									<td align="center" colspan = "10">Loading... Please wait...</td>
								</tbody>
							</table>
						
                    </div>
                </div>
        </div>
</div>
<!-- Morris Charts JavaScript -->
<script src="bower_components/raphael/raphael-min.js"></script>
<script src="bower_components/morrisjs/morris.min.js"></script>
<script type="text/javascript" src="js/chat.js"></script>
<script>
    var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);
    google_ad_client = "ca-pub-2783044520727903";

    $(function() {
        $( ".datepicker" ).datepicker();
        
        var chat =  new Chat();
        chat.getState();
        
        // Interval for chat update..
        setInterval(function(){
			
			chat.update();
			ScannedResultToday();
			
			},1500);
        
       $('#sendie').keyup(function(e) {	
              if (e.keyCode == 13) { 
                
                var text = $(this).val();
                var maxLength = $(this).attr("maxlength");  
                var length = text.length; 

                // send 
                if (length <= maxLength + 1) { 

                    chat.send(text, name);	
                    $(this).val("");

                } else {

                    $(this).val(text.substring(0, maxLength));

                }	
              }
         });
		 
		 $.ajax({
			type:'post',
			dataType:'json',
			data:{action:'GetPositiveAndNegativeChart'},
			url:'class/dashboard.php',
			success:function(resp){
				// alert(resp['POSITIVE']);
				Morris.Donut({
					element: 'morris-donut-chart',
					data: [{
						label: "Positive",
						value: resp['POSITIVE']
					}, {
						label: "Negative",
						value: resp['NEGATIVE']
					}],
					resize: true
				});
			}
		 })
        
    });
    
	function ScannedResultToday()
	{
		 $.ajax({
			type:'post',
			dataType:'json',
			data:{action:'ScannedResultToday'},
			url:'class/dashboard.php',
			success:function(resp){
				var html = "";
				if(resp['response']=='success'){
					for(var x =0; resp['data_handler'].length > x; x++){
						html+= '<tr>';
						html+= '<td>'+resp['data_handler'][x].Operation+'</td>';
						html+= '<td>'+resp['data_handler'][x].Schedule+'</td>';
						html+= '<td>'+resp['data_handler'][x].Positive+'</td>';
						html+= '<td>'+resp['data_handler'][x].Negative+'</td>';
						html+= '</tr>';
					}
				}else{
					//resp['message']
				}
				
				
				
				$(".ScannedResultToday").find("tbody").html(html);
			}
			
		 })
	}
    
</script>
<!-- link rel="stylesheet" type="text/css" href="library/clocklibrary/styles.css" / -->
<link rel="stylesheet" type="text/css" href="library/clocklibrary/jquery.tzineClock/jquery.tzineClock.css" />
<script type="text/javascript" src="library/clocklibrary/jquery.tzineClock/jquery.tzineClock.js"></script>
<script type="text/javascript" src="library/clocklibrary/script.js"></script>

<!-- Calculator -->
<!-- link rel="stylesheet" type="text/css" href="library/calculator/reset.css" -->
<link rel="stylesheet" type="text/css" href="library/calculator/main.css">
<script type="text/javascript" src="library/calculator/calculator.js"></script>


<!-- script src="js/morris-data.js"></script -->
