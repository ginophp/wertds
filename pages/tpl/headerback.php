<?php

	session_start();
	require_once("class/config.php");
	require_once("class/function.php");
	require_once("library/pagination.php");

	if(isset($_GET['logout'])){
		if(file_exists("pages/supervisor/pdf/letters/signatures/signature{$_SESSION['empid']}.png")){
			unlink("pages/supervisor/pdf/letters/signatures/signature{$_SESSION['empid']}.png");
		}
		session_destroy();
        loginaccount($_SESSION['empid']);
		header("Location: login.php");
	}	
	if(!isset($_SESSION['empid'])){
		session_destroy();
		header("Location: login.php");
		die();
	}
	
	$module = "";
	$submenus = "";
	$submenusmultiple = "";
	$arrayid = array();

	$qmodule = $mysqli->query("select * from module where trim(Access) like ('%".$_SESSION['position']."%') order by Ordering ASC");

   

	if( $qmodule->num_rows > 0 ){
        $cnt = 0;
		while($r = $qmodule->fetch_object()){
			$submenus = "";
			$module .= '<li>';
			//$module .= '<a href="#"><i class="fa '.$r->Icon.' fa-fw"></i>'.$r->Description.'<span class="fa arrow"></span></a>';
			$module .= '<a href="javascript:;" data-toggle="collapse" data-target="#demo'.$cnt.'"><i class="fa fa-fw '.$r->Icon.'"></i> '.$r->Description.' <i class="fa fa-fw fa-caret-down"></i></a>';
			// $module .= '<ul id="demo'.$cnt.'" class="nav nav-second-level">';
			$module .= '<ul id="demo'.$cnt.'" class="collapse">';
			
			$qsubmodule = $mysqli->query("SELECT * FROM submodule where ModuleID = ".$r->ID);
			if($qsubmodule->num_rows > 0){
				while($rr = $qsubmodule->fetch_object()){
					$array_access = explode(',',$rr->Access);
					foreach($array_access as $access){
							if($_SESSION['position'] == $access){
								if($rr->IsMultipleMenu == 1){
									$submenus 	.= '<li>';
									$submenus	.= '<a href="#"><i class="fa '.$rr->Icon.' fa-fw"></i>'.$rr->Description.' <span class="fa arrow"></span></a>';
									$submenusmultiple = $mysqli->query("select * from submodule where ParentID = ".$rr->ID);
									if($submenusmultiple->num_rows > 0){
										$submenus .= '<ul class="nav nav-third-level">';
										while($rrr = $submenusmultiple->fetch_object()){
												$arrayid[] = $rrr->ID;
												$submenus .= '<li>';
												$submenus .= '<a href="index.php?PageID='.$rrr->Code.'"><i class="fa '.$rrr->Icon.' fa-fw"></i>'.$rrr->Description.' <span class="fa arrow"></span></a>';
												$submenus .= '</li>';
										}
										$submenus .='</ul>';
									}
									$submenus 	.= '</li>';
								}else{
									if(!in_array($rr->ID,$arrayid)){
										$submenus 	.= '<li>';
										$submenus	.= '<a href="index.php?PageID='.$rr->Code.'"><i class="fa '.$rr->Icon.' fa-fw"></i>'.$rr->Description.' <span class="fa arrow"></span></a>';
										$submenus 	.= '</li>';
									}
								}
							}
					}
				}
			}	
			
			$module .= $submenus;
			$module .= '</ul>';
			$module .= '</li>';
            $cnt++;
		}
	}
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Alexis A. Molaer</title>

    <!-- Bootstrap Core CSS -->
    <link href="themes2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="themes2/css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="themes2/css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="themes2/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
   <!-- jQuery -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="js/jquery/jquery-ui.js"></script>
    <link href="js/jquery/jquery-ui.css" rel="stylesheet">

    <!-- Bootstrap Core JavaScript -->
    <script src="themes2/js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <!-- script src="themes2/js/plugins/morris/raphael.min.js"></script>
    <script src="themes2/js/plugins/morris/morris.min.js"></script>
    <script src="themes2/js/plugins/morris/morris-data.js"></script -->
    <script src="js/globalfunction.js"></script>
    <script>
		function logout(){
			if(confirm("are you sure want to logout?")==true){
				location.href = "index.php?logout";
			}
			return false
		}
		
		$(function(){
			$('[data-toggle="tooltip"]').tooltip();
		});
	</script>
</head>
<style>
    
.navbar-inverse .navbar-brand {
    color: yellow;
}
    
/*.top-nav>li>a {
    color: yellow;
}*/
</style>
</style>
<body style="background-color:white;">

    <!-- div id="wrapper" -->

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php?ID=0">( AAM )</a>
                <a class="navbar-brand">Welcome <?=$_SESSION['username'];?> !</a>
            </div>
            
             
            
            
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                
               
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user">
                        </i> 
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu" style="width: 250px;">
                        <li>
							<a href="#" onclick="ViewProfile();">
								<i class="fa fa-user fa-fw"></i>View Profile
							</a>
						</li>
                        <li class="divider"></li>
                        <li>
                            <?php
                                if($_SESSION['position'] == 'supervisor'):
                            ?>
                                <a href="#" onclick="ViewCollectors(1);">
								    <i class="fa fa-users fa-fw"></i>View Collectors
							    </a>
                            <?php
                                else:
                            ?>
                                <a href="#" onclick="ViewDriver(2);">
								    <i class="fa fa-users fa-fw"></i>View Driver
							    </a>
							<?php endif;

                            ?>
						</li>
                        <li class="divider"></li>
                            <li>
								<a href="#" onclick="ChangePassword();">
									<i class="fa fa-lock fa-fw"></i>Change Password
								</a>
							</li>
                        </li>
                       <li class="divider"></li>
                        <li>
                            <a href="#" onclick="logout();"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div  class = "collapse navbar-collapse navbar-ex1-collapse">
                <ul class = "nav navbar-nav side-nav" id="side-menu">
                    <?=$module;?>
                    <!-- li class="active">
                        <a href="index.html"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="charts.html"><i class="fa fa-fw fa-bar-chart-o"></i> Charts</a>
                    </li>
                    <li>
                        <a href="tables.html"><i class="fa fa-fw fa-table"></i> Tables</a>
                    </li>
                    <li>
                        <a href="forms.html"><i class="fa fa-fw fa-edit"></i> Forms</a>
                    </li>
                    <li>
                        <a href="bootstrap-elements.html"><i class="fa fa-fw fa-desktop"></i> Bootstrap Elements</a>
                    </li>
                    <li>
                        <a href="bootstrap-grid.html"><i class="fa fa-fw fa-wrench"></i> Bootstrap Grid</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Dropdown <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="#">Dropdown Item</a>
                            </li>
                            <li>
                                <a href="#">Dropdown Item</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="blank-page.html"><i class="fa fa-fw fa-file"></i> Blank Page</a>
                    </li>
                    <li>
                        <a href="index-rtl.html"><i class="fa fa-fw fa-dashboard"></i> RTL Dashboard</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        
