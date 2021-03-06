<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>POS</title>

    <!-- Bootstrap Core CSS -->
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
						<!-- img style = "height:250px;width:334px;" src = "img/logo.jpg" / -->
                        <h3 class="panel-title">POINT OF SALE WERT GLOBAL BRANDS</h3>
                    </div>
                    <div class="panel-body">
                        <form name = "login-form" role="form" method = "post">
							<div class="alert alert-success" style = "display:none;">
								* Username password required..
							</div>
							<div class="alert alert-danger" style = "display:none;">
								<b>X</b> Wrong Username or Password ..
							</div>
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <input type = "submit" name="doLogin" class="btn btn-lg btn-success btn-block" value = "Login" />
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>
	<script>
		$(document).ready(function(){
            
            $('input[type=text] , [type=password]').on('keydown', function(e) {
                if (e.which == 13) {
                    //e.preventDefault();
                    doLogin();
                    return false;
                }
            });
            
			$("[name=doLogin]").click(function(){
				//alert('system maintenance.. ');
				//return false;
				doLogin();
                return false;
			})
			
		});
        
        function doLogin(){
            $.ajax({
					url:'class/login_process.php',
					dataType:'json',
					type:'post',
					data: $("form[name=login-form]").serialize()+"&action=login",
					success:function(resp){
						if(resp.result=='success'){
							location.href = "index.php";
						}else{
							$(".alert-danger").show();
							return false;
						}
					}
				});
        }
	</script>
</body>
</html>
