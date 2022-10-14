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
				$reply = array('status' => 'Anda tidak mempunyai hak untuk mengakses data', 'error' => 'yes' );
				echo json_encode($reply);
			}
		 
		 
	}  else {
		
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
global $multirule, $datakey, $username, $session, $host_get_tagihan;
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
$billing_type = CheckString($data['billing_type']) ?? "";
$kecamatan = CheckString($data['kecamatan']) ?? "";
$nop_pbb_asal = CheckString($data['nop_pbb_asal']) ?? "";
$nama_wp_asal = CheckString($data['nama_wp_asal']) ?? "";
$kelurahan_op = CheckString($data['kelurahan']) ?? "";
$kecamatan_op = CheckString($data['kecamatan']) ?? "";
$status_bayar = CheckString($data['status_bayar']) ?? "";
$tgl_tagihan_from = $data['tgl_tagihan_from'] ?? "";
$tgl_tagihan_to = $data['tgl_tagihan_to'] ?? "";
$limit = $data['limit'] ?? "300";
$curl = new Curl($host_get_tagihan);
$curl-> send('get', array(
			'no_ref'=> $no_ref,
			'kode_billing'=> $kode_billing,
			'billing_type'=> $billing_type,
			'nop_pbb_asal'=> $nop_pbb_asal,
			'nama_wp_asal'=> $nama_wp_asal,
			'kelurahan_op'=> $kelurahan_op,
			'kecamatan_op'=> $kecamatan_op,
			'status_bayar'=> $status_bayar,
			'tgl_tagihan_from'=> $tgl_tagihan_from,
			'tgl_tagihan_to'=> $tgl_tagihan_to,
			'action'=>  encrypt("get",$datakey),
			'reply'=> $allow,
			'token'=> encrypt($username,$datakey),
			'access'=> encrypt($session,$datakey),
			'limit'=>$limit
			));
echo $curl->getResponse();
 
};



