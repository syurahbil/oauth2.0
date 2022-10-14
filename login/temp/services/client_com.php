<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
include('vendor/autoload.php');
include('vendor/host.php');
use prodigyview\network\Curl;
use prodigyview\network\Request;
include("../../dist/encrypt.php");	
$request = new Request();
$reply = array();
//Get The Request Method(GET, POST, PUT, DELETE)
$method = strtolower($request->getRequestMethod());
//RETRIEVE Data From The Request
$data = $request->getRequestData('array');

if (isset($_SESSION['session-login']) && isset($_SESSION['user-session'])) {

$username = $_SESSION['user-session'];
$user_rule = $_SESSION['rule_user'];
$session = $_SESSION['session-login'];
$user_service_office = $_SESSION['user-office'];
$user_primary_office = $_SESSION['primary-office'];
$user_office_name = $_SESSION['user-office-name'];
$user_rule = $_SESSION['rule_user'];
$user_office_external = $_SESSION['office-external'];
$user_external = $_SESSION['external'];
$user_resolver_group = $_SESSION['resolver_group'];
$multirule = $_SESSION['multirule'];


	//Route The Request
	if ($method == 'get') {
		 
			if (in_array("1",$multirule))
			{
			get($data);
			}
			else
			{
				$reply = array('status' => 'Anda tidak mempunyai hak untuk mengakses data');
				echo json_encode($reply);
			}
		 
		 
	}  else {
		
		$reply = array('status' => 'Metode kirim data tidak dapat diterima.');
		echo json_encode($reply);
		
	}

} // check session
else
{
	$reply = array('status' => 'Status Autentikasi Anda sudah kadaluarsa. Mohon Login kembali!');
	echo json_encode($reply);
}


function get($data) {
//require_once("../../dist/encrypt.php");	
global $multirule, $datakey, $username, $session, $host_get_com;
 if (in_array("1",$multirule))
	{
	$allow = encrypt("yes",$datakey);	
	}
	else
	{
	$allow = encrypt("no",$datakey);
	}
$no_ref = CheckString($data['no_ref']) ?? "";
$jenis_com = CheckString($data['jenis_com']) ?? "";
$tgl_com_from = $data['tgl_com_from'] ?? "";
$tgl_com_to = $data['tgl_com_to'] ?? "";
$limit = $data['limit'] ?? "300";
$curl = new Curl($host_get_com);
$curl-> send('get', array(
			'no_ref'=> $no_ref,
			'jenis_com'=> $jenis_com,
			'tgl_com_from'=> $tgl_com_from,
			'tgl_com_to'=> $tgl_com_to,
			'action'=>  encrypt("get",$datakey),
			'reply'=> $allow,
			'token'=> encrypt($username,$datakey),
			'access'=> encrypt($session,$datakey),
			'limit'=>$limit
			));
echo $curl->getResponse();
 
};



