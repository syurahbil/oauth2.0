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
				$reply = array('status' => 'Anda tidak mempunyai hak untuk mengakses data', 'error' => 'yes');
				echo json_encode($reply);
			}
		 
		 
	}  else if ($method == 'post') {
		
		if (in_array("1",$multirule) && in_array("13",$multirule))
			{
			post($data);
			}
			else
			{
				$reply = array('status' => 'Anda tidak mempunyai hak untuk mengakses data', 'error' => 'yes');
				echo json_encode($reply);
			}
			
	} else {
		
		$reply = array('status' => 'Metode kirim data tidak dapat diterima.', 'error' => 'yes');
		echo json_encode($reply);
		
	}

} // check session
else
{
	$reply = array('status' => 'Status Autentikasi Anda sudah kadaluarsa. Mohon Login kembali!', 'error' => 'yes');
	echo json_encode($reply);
}


function get($data) {
//require_once("../../dist/encrypt.php");	
global $multirule, $datakey, $username, $session, $host_get_pembayaran;
    if (in_array("1",$multirule))
	{
	$allow = encrypt("yes",$datakey);	
	}
	else
	{
	$allow = encrypt("no",$datakey);
	}
	if (in_array("13",$multirule))
	{
	$rule_bayar = encrypt("yes",$datakey);	
	}
	else
	{
	$rule_bayar = encrypt("no",$datakey);
	}
$no_ntpd = CheckString($data['no_ntpd']) ?? "";
$no_ref = CheckString($data['no_ref']) ?? "";
$no_ref_bank = CheckString($data['no_ref_bank']) ?? "";
$kode_billing = CheckString($data['kode_billing']) ?? "";
$nama_wp = CheckString($data['nama_wp']) ?? "";
$kelurahan = CheckString($data['kelurahan']) ?? "";
$kecamatan = CheckString($data['kecamatan']) ?? "";
$status_bpn = CheckString($data['status_bpn']) ?? "";
$nop_pbb = CheckString($data['nop_pbb']) ?? "";
$tgl_bayar_from = $data['tgl_bayar_from'] ?? "";
$tgl_bayar_to = $data['tgl_bayar_to'] ?? "";
$limit = $data['limit'] ?? "300";
$curl = new Curl($host_get_pembayaran);
$curl-> send('get', array(
			'no_ntpd'=> $no_ntpd,
			'no_ref'=> $no_ref,
			'no_ref_bank'=> $no_ref_bank,
			'kode_billing'=> $kode_billing,
			'nop_pbb'=> $nop_pbb,
			'nama_wp'=> $nama_wp,
			'kelurahan'=> $kelurahan,
			'kecamatan'=> $kecamatan,
			'status_bpn'=> $status_bpn,
			'tgl_bayar_from'=> $tgl_bayar_from,
			'tgl_bayar_to'=> $tgl_bayar_to,
			'action'=>  encrypt("get",$datakey),
			'reply'=> $allow,
			'rule'=> $rule_bayar,
			'user'=> encrypt($username,$datakey),
			'access'=> encrypt($session,$datakey),
			'limit'=>$limit
			));
echo $curl->getResponse();
 
};


function post($data) {
//require_once("../../dist/encrypt.php");	
global $multirule, $datakey, $username, $session, $host_post_pembayaran;
 if (in_array("1",$multirule) && in_array("13",$multirule))
	{
	$allow = encrypt("yes",$datakey);	
	}
	else
	{
	$allow = encrypt("no",$datakey);
	}
$no_ntpd = CheckString($data['no_ntpd_bayar']) ?? "";
$status_bayar = CheckString($data['status_bayar']) ?? "";
$status_bpn = CheckString($data['status_bpn']) ?? "";
$no_ref_bank = CheckString($data['no_ref_bank']) ?? "";
$kode_billing = CheckString($data['kode_billing']) ?? "";
$nama_wp = CheckString($data['nama_wp']) ?? "";
$tgl_posting = CheckString($data['tgl_posting']) ?? "";
$message = CheckString($data['message']) ?? "";
$nop_pbb = CheckString($data['nop_pbb']) ?? "";
$action_bayar = $data['action_bayar'] ?? "";
$tgl_bayar = $data['tgl_bayar'] ?? "";
$jlh_bayar = str_replace(",","",$data['jlh_bayar']) ?? "";
$token = $data['token'] ?? "";

$curl = new Curl($host_post_pembayaran);
$curl-> send('post', array(
			'no_ntpd'=> $no_ntpd,
			'status_bayar'=> $status_bayar,
			'no_ref_bank'=> $no_ref_bank,
			'kode_billing'=> $kode_billing,
			'nop_pbb'=> $nop_pbb,
			'nama_wp'=> $nama_wp,
			'tgl_posting'=> $tgl_posting,
			'message'=> $message,
			'status_bpn'=> $status_bpn,
			'tgl_bayar'=> $tgl_bayar,
			'jlh_bayar'=> $jlh_bayar,
			'action'=>  $action_bayar,
			'reply'=> $allow,
			'user'=> encrypt($username,$datakey),
			'access'=> encrypt($session,$datakey),
			'token'=>$token
			));
echo $curl->getResponse();
 
};



