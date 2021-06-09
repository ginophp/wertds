<?php


function clean($string) {
   //$string = trim($string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
}


function GetSettingValue($value=''){
	global $mysqli;
	return $mysqli->query("select * from settings where Code = '".$value."'")->fetch_object()->Value;
		
}


function loginaccount($ID){
	global $mysqli;
    
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    $Country  = "Unknown";
    $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));
    
    if($ip_data && $ip_data->geoplugin_countryName != null){
        $Country = $ip_data->geoplugin_countryName;
    }
    
    $EnrollmentDate = date("Y-m-d H:i:s");
	$mysqli->query("update user set EventID = 0, LastLogin = '".$EnrollmentDate."', LastIPAddress = '".$ip."',LastSessionCountry ='".$Country."' where ID =".$ID);
}


function GetCreditAmount($PlayerID)
{
    global $mysqli;
    return $mysqli->query("select Credit from user where ID  =".$PlayerID)->fetch_object()->Credit;
}

function soa($username="",$Type="",$Amount=0,$EnrollmentDate="",$TransactBy="",$Reference = "",$Comment = "",$GameNo="",$odds="",$MeronOrWala=""){
    global $mysqli;
    return $mysqli->query("insert into soa 
                            (Username,Type,Amount,EnrollmentDate,TransactBy,Reference,Comment,GameNo,Odds,MeronOrWala) 
                            values
                            ('".$username."','".$Type."','".$Amount."','".$EnrollmentDate."','".$TransactBy."','".$Reference."','".$Comment."','".$GameNo."','".$odds."','".$MeronOrWala."')");
}

?>