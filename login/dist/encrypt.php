<?php

define("ENCRYPTEDKEY", "sCr4Mbl3Dkey&*[]\|byxqoyx");
define("SIMPLEENCRYPTEDKEY", "sCr4Mbl3DkeybyxqoyxCikNyobaanDipanjangKeun");
$datakey = "madunl069";

function get_ip_address() {
	
	if (!empty($_SERVER['REMOTE_ADDR']) && validate_ip($_SERVER['REMOTE_ADDR'])) {
		return $_SERVER['REMOTE_ADDR'];
	}
	// check for shared internet/ISP IP
	
	if (!empty($_SERVER['HTTP_CLIENT_IP']) && validate_ip($_SERVER['HTTP_CLIENT_IP'])) {
		return $_SERVER['HTTP_CLIENT_IP'];
	}
	// check for IPs passing through proxies
	if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		// check if multiple ips exist in var
		if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
			$iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
			foreach ($iplist as $ip) {
				if (validate_ip($ip))
					return $ip;
			}
		} else {
			if (validate_ip($_SERVER['HTTP_X_FORWARDED_FOR']))
				return $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
	}
	if (!empty($_SERVER['HTTP_X_FORWARDED']) && validate_ip($_SERVER['HTTP_X_FORWARDED']))
		return $_SERVER['HTTP_X_FORWARDED'];
	if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && validate_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
		return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
	if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && validate_ip($_SERVER['HTTP_FORWARDED_FOR']))
		return $_SERVER['HTTP_FORWARDED_FOR'];
	if (!empty($_SERVER['HTTP_FORWARDED']) && validate_ip($_SERVER['HTTP_FORWARDED']))
		return $_SERVER['HTTP_FORWARDED'];
	// return unreliable ip since all else failed
	return $_SERVER['REMOTE_ADDR'];
}
/**
 * Ensures an ip address is both a valid IP and does not fall within
 * a private network range.
 */

function validate_ip($ip) {
	if (strtolower($ip) === 'unknown')
		return false;
	// generate ipv4 network address
	$ip = ip2long($ip);
	// if the ip is set and not equivalent to 255.255.255.255
	if ($ip !== false && $ip !== -1) {
		// make sure to get unsigned long representation of ip
		// due to discrepancies between 32 and 64 bit OSes and
		// signed numbers (ints default to signed in PHP)
		$ip = sprintf('%u', $ip);
		// do private network range checking
		if ($ip >= 0 && $ip <= 50331647) return false;
		if ($ip >= 167772160 && $ip <= 184549375) return false;
		if ($ip >= 2130706432 && $ip <= 2147483647) return false;
		if ($ip >= 2851995648 && $ip <= 2852061183) return false;
		if ($ip >= 2886729728 && $ip <= 2887778303) return false;
		if ($ip >= 3221225984 && $ip <= 3221226239) return false;
		if ($ip >= 3232235520 && $ip <= 3232301055) return false;
		if ($ip >= 4294967040) return false;
	}
	return true;
}
function CheckString($data)
{
	$string = str_replace("\"","",$data);
	$string = addslashes($string);
	$string = str_replace("script","",$string);
	$string = str_replace("Script","",$string);
	$string = str_replace("SCRIPT","",$string);
	$string = str_replace("<","",$string);
	$string = str_replace(">","",$string);
	$string = str_replace("select","",$string);
	$string = str_replace("drop table","",$string);
	$string = str_replace("union","",$string);
	$string = str_replace("concat","",$string);
	$string = str_replace("SELECT","",$string);
	$string = str_replace("DROP TABLE","",$string);
	$string = str_replace("UNION","",$string);
	$string = str_replace("CONCAT","",$string);
	$string = str_replace(";","",$string);
	// $string = str_replace("{","",$string);
	// $string = str_replace("}","",$string);
	return $string;
}
function RandomString($length = 40) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function encrypt($string, $key) {
	$result = '';
	$string.="<abcd1234>";
	for($i=0; $i<strlen($string); $i++) {
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key)), 1);
		$char = chr(ord($char)+ord($keychar));
		$result.=$char;
	}

	return strtr(base64_encode($result), '+=/', '.%~');
}

function decrypt($string, $key) {
	$result = '';
	$string = base64_decode(strtr($string, '.%~', '+=/'));

	for($i=0; $i<strlen($string); $i++) {
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key)), 1);
		$char = chr(ord($char)-ord($keychar));
		$result.=$char;
	}
	$result = str_replace("<abcd1234>","",$result);
	return $result;
}

function addDays($date,$days){

    $date = strtotime("+".$days." days", strtotime($date));
    return  date("Y-m-d", $date);

}

function base64_url_encode($input) {
	return strtr(base64_encode($input), '+=/', '.-~');
}

function base64_url_decode($input){
	return base64_decode(strtr($input, '.-~', '+=/'));
}

function secondsToWords($seconds)
{
    $ret = "";

    /*** get the days ***/
    $days = intval(intval($seconds) / (3600*24));
    if($days> 0)
    {
        $ret .= "$days days ";
    }

    /*** get the hours ***/
    $hours = (intval($seconds) / 3600) % 24;
    if($hours > 0)
    {
        $ret .= "$hours hours ";
    }

    /*** get the minutes ***/
    $minutes = (intval($seconds) / 60) % 60;
    if($minutes > 0)
    {
        $ret .= "$minutes minutes ";
    }

    /*** get the seconds ***/
    $seconds = intval($seconds) % 60;
    if ($seconds > 0) {
        $ret .= "$seconds seconds";
    }

    return $ret;
}

function secondsToHours($seconds)
{
  // extract hours
$hours = floor($seconds / 3600);
$seconds -= $hours * 3600;
$minutes = floor($seconds / 60);
$seconds -= $minutes * 60;
$obj_time = "";
if ($hours > 0)
{
$obj_time = "$hours Hours";
}
if ($minutes > 0)
{
$obj_time .= " $minutes Minutes";
}
if ($seconds > 0)
{
$obj_time .= " $seconds Seconds";
}

if ($obj_time == "")
{
	$obj_time = "Not Counting";
}
  return $obj_time;
  
}



// function CheckDueDate($start_date, $next)
// {
// require_once("panel.php");
// $query1 = "SELECT * FROM holiday WHERE YEAR(date_holiday)=YEAR(CURRENT_DATE()) OR YEAR(date_holiday)=(YEAR(CURRENT_DATE())-1)";
// $result_row = mysql_query($query1);

// while ($row = mysql_fetch_array($result_row)) 
// {
	// $holidays[] = $row['date_holiday'];
// }

// $nextBusinessDay = date('Y-m-d', strtotime($start_date . ' +' . $next . ' Weekday'));

// while (in_array($nextBusinessDay, $holidays)) {
	 
    // $next++;
    // $nextBusinessDay = date('Y-m-d', strtotime($start_date . ' +' . $next . ' Weekday'));
	 
// }

// return $nextBusinessDay;
// }

// function CheckDueDate2($start_date, $next)
// {
// require_once("panel.php");
// $query1 = "SELECT * FROM holiday WHERE YEAR(date_holiday)=YEAR(CURRENT_DATE()) OR YEAR(date_holiday)=(YEAR(CURRENT_DATE())-1)";
// $result_row = mysql_query($query1);

// while ($row = mysql_fetch_array($result_row)) 
// {
	// $holidays[] = $row['date_holiday'];
// }

// $nextBusinessDay = date('Y-m-d', strtotime($start_date . ' +' . $next . ' Weekday'));

// while (in_array($nextBusinessDay, $holidays)) {
    // $next++;
    // $nextBusinessDay = date('Y-m-d', strtotime($start_date . ' +' . $next . ' Weekday'));
// }

// return $nextBusinessDay;
// }

function validateDateTime($date)
{
    $d = DateTime::createFromFormat('Y-m-d H:i:s', $date);
    return $d && $d->format('Y-m-d H:i:s') === $date;
}


function slugify($text) {
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        // replace non letter or digits by -
		$text = preg_replace("~[^a-z0-9-.,;@:]~i", " ", $text); 
		$text = filter_var($text,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
        $text = preg_replace('~[^\\pL\d-.,;@:]+~u', ' ', $text);
		
        //setlocale(LC_CTYPE, 'en_GB.utf8');
        // transliterate
        if (function_exists('iconv')) {
           $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }
  
        // remove unwanted characters
        $text = preg_replace('~[^-\w.,;@:]+~', ' ', $text);
        if (empty($text)) {
           return '-';
        }
         
        return $text;
    }
	
	
function daysBetween($dt1, $dt2) {
    return date_diff(
        date_create($dt2),  
        date_create($dt1)
    )->format('%a');
	}

//echo encrypt('',$datakey);
//echo "data = '".decrypt('dc7DzNBhaGyhnw--',$datakey)."'";
//echo uniqid(910210);
//echo RandomString();

//echo $unique_visitor;

?>