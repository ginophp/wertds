<?php
    session_start();
    $function = $_POST['function'];
    $log = array();
    $file = $_POST['file'];
    switch($function) {
    
    	 case('getState'):
        	 if(!file_exists('chatlogs/'.$file)){
               fopen('chatlogs/'.$file, "w");
             }
        
             $lines = file('chatlogs/'.$file);
             $log['state'] = count($lines); 
        	 break;	
    	
    	 case('update'):
        	$state = $_POST['state'];
        	if(file_exists('chatlogs/'.$file)){
        	   $lines = file('chatlogs/'.$file);
        	 }
        	 $count =  count($lines);
        	 if($state == $count){
                     $log['state'] = $state;
                     $log['text'] = false;
        		 }
        		 else{
        			 $text= array();
        			 $log['state'] = $state + count($lines) - $state;
        			 foreach ($lines as $line_num => $line)
                       {
        				   if($line_num >= $state){
                              $text[] =  $line = str_replace("\n", "", $line);
        				   }
         
                        }
        			 $log['text'] = $text; 
        		 }
        	  
             break;
    	 case('send'):
		  $nickname = htmlentities(strip_tags($_SESSION['username']));
			 $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
			  $message = htmlentities(strip_tags($_POST['message']));
		 if(($message) != "\n"){
        	
			 if(preg_match($reg_exUrl, $message, $url)) {
       			$message = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a>', $message);
             } 
             
             
        	//$nickname
             if($_SESSION['position'] == 'supervisor'){
                    //fwrite(fopen('chatlogs/'.$file, 'a'), "<span>". $nickname. "</span>" . $message = str_replace("\n", " ", $message) . "\n");      
                    fwrite(fopen('chatlogs/'.$file, 'a'),' <li class="left clearfix"><span class="chat-img pull-left"><img src="http://placehold.it/50/55C1E7/fff" alt="User Avatar" class="img-circle"></span><div class="chat-body clearfix"><div class="header"><strong class="primary-font">'.$nickname.'</strong></div><p>'.$message = str_replace("\n", " ", $message).'</p></div></li>'."\n");
             }
             
             if($_SESSION['position'] == 'operation'){
                    //fwrite(fopen('chatlogs/'.$file, 'a'), "<span class = 'admin'>".$nickname . "</span>" . $message = str_replace("\n", " ", $message) . "\n");      
                   fwrite(fopen('chatlogs/'.$file, 'a'),' <li class="left clearfix"><span class="chat-img pull-left"><img src="http://placehold.it/50/006D32/fff" alt="User Avatar" class="img-circle"></span><div class="chat-body clearfix"><div class="header"><strong class="primary-font">'.$nickname.'</strong></div><p>'.$message = str_replace("\n", " ", $message).'</p></div></li>'."\n"); 
             }
        
		 }
        	 break;
    	
    }
    
    echo json_encode($log);

?>