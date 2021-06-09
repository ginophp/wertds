<?php 
require_once("pages/tpl/header.php"); ?>
        <!-- Page Content -->
        
		<?php 
        if(isset($_GET['PageID'])){
			if($mysqli->query("select * from submodule where Code = '".$_GET['PageID']."' and Access like '%".$_SESSION['position']."%'")->num_rows == 0){
				require_once("pages/404notfound.php"); 
				die();
			}
			require_once($mysqli->query("select FileLocation from submodule where Code='".$_GET['PageID']."'")->fetch_object()->FileLocation); 
		}else{
            
			//require_once("pages/main.php"); 
			require_once("pages/dashboard/".$_SESSION['position'].".php"); 
		}
		?>
<?php require_once("pages/tpl/footer.php"); ?>