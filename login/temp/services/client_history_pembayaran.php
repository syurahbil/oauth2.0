<?php
session_start();
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
global $multirule, $datakey, $username, $session, $host_get_history_pembayaran;
 if (in_array("1",$multirule))
	{
	$allow = encrypt("yes",$datakey);	
	}
	else
	{
	$allow = encrypt("no",$datakey);
	}
$no_ref = CheckString($data['no_ref']) ?? "";
$kode_billing = CheckString($data['kode_billing']) ?? "";
$ntpd = CheckString($data['ntpd']) ?? "";
$tgl_transaksi_from = $data['tgl_transaksi_from'] ?? "";
$tgl_transaksi_to = $data['tgl_transaksi_to'] ?? "";
$limit = $data['limit'] ?? "300";
$curl = new Curl($host_get_history_pembayaran);
$curl-> send('get', array(
			'no_ref'=> $no_ref,
			'ntpd'=> $ntpd,
			'kode_billing'=> $kode_billing,
			'tgl_transaksi_from'=> $tgl_transaksi_from,
			'tgl_transaksi_to'=> $tgl_transaksi_to,
			'action'=>  encrypt("get",$datakey),
			'reply'=> $allow,
			'token'=> encrypt($username,$datakey),
			'access'=> encrypt($session,$datakey),
			'limit'=>$limit
			));
echo $curl->getResponse();
 
};



