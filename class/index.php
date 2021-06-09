<?php 

require_once("pages/tpl/header.php"); ?>
        <!-- Page Content -->
        
		<?php 
            $EnrollmentDate = date("Y-m-d H:i:s");
            $EventID = 0;
            if(isset($_GET['EventID'])){
                $EventID = $_GET['EventID'];
                $q = $mysqli->query("SELECT * FROM eventhistory where EventID = ".$EventID." and UserID = ".$_SESSION['empid']);
                if($q->num_rows == 0){
                    $mysqli->query("INSERT INTO `eventhistory` (`UserID`,`EventID`,`EnterDate`)
                                    VALUES
                                    (".$_SESSION['empid'].",".$EventID.",'".$EnrollmentDate."')");
                }
                if(!file_exists('class/chatlogs/Admin'.$_GET['EventID'].".txt")){
                   fopen('class/chatlogs/Admin'.$_GET['EventID'].".txt", "w");
                    //die('x');
                }
                if($_SESSION['position'] == 'player'){
                         fwrite(fopen('class/chatlogs/Admin'.$_GET['EventID'].".txt", 'a'), "<span>". $_SESSION['username']. "</span> Logged in " .$EnrollmentDate. "\n");      
                 }else{
                         fwrite(fopen('class/chatlogs/Admin'.$_GET['EventID'].".txt", 'a'), "<span class = 'admin'>".$_SESSION['username'] . "</span> Logged in " .$EnrollmentDate. "\n");      
                 }
        }
   
        $mysqli->query("update user set EventID = ".$EventID." where ID =".$_SESSION['empid']);
       //  die("select * from submodule where Code = '".$_GET['PageID']."' and Access like '%".$_SESSION['position']."%'");
		if(isset($_GET['PageID'])){
			if($mysqli->query("select * from submodule where Code = '".$_GET['PageID']."' and Access like '%".$_SESSION['position']."%'")->num_rows == 0){
				require_once("pages/404notfound.php"); 
				die();
			}
			
			require_once($mysqli->query("select FileLocation from submodule where Code='".$_GET['PageID']."'")->fetch_object()->FileLocation); 
		}else{

			require_once("pages/main.php"); 
		}
		?>
<?php require_once("pages/tpl/footer.php"); ?>