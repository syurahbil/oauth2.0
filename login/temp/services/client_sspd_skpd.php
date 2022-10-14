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
if (isset($_SESSION['eng_id']))
{
 $engineer_id = $_SESSION['eng_id'];
}
else
{
 $engineer_id = ""; 
}


//Route The Request
if ($method == 'get') {
	$action = decrypt($data['action'],$datakey);
	if ($action=="get")
	{
		if (in_array("1",$multirule) )
		{
		get($data);
		}
		else
		{
			$reply = array('status' => 'Anda tidak mempunyai hak untuk mengakses data', 'error' => 'yes');
			echo json_encode($reply);
		}
	}
	else
	{
		$reply = array('status' => 'Metode kirim data tidak dapat diterima.', 'error' => 'yes');
		echo json_encode($reply);
	}
}  else {
	
	$reply = array('status' => 'Metode kirim data tidak dapat diterima.', 'error' => 'yes');
	echo json_encode($reply);
	
}

} // check session
else
{
	$reply = array('status' => 'Status Autentikasi Anda sudah kadaluarsa. Mohon Login kembali', 'error' => 'yes');
	echo json_encode($reply);
}


function get($data) {
//require_once("../../dist/encrypt.php");	
global $multirule, $datakey, $username, $user_rule, $engineer_id, $session, $host_get_sspd_skpd;

if (in_array("1",$multirule))
	{
	$allow = encrypt("yes",$datakey);
	}
	else
	{
	$allow = encrypt("no",$datakey);
	}
	if ($user_rule == "2")
	{
		$eng_id = $engineer_id;
	}
	else
	{
		$eng_id = "0";
	}
$no_sspd = CheckString($data['no_sspd']) ?? "";
$kode_billing = CheckString($data['kode_billing']) ?? "";
$ppat_id = CheckString($data['ppat_id']) ?? "";
$nama_wp = CheckString($data['nama_wp']) ?? "";
$no_identitas = CheckString($data['no_identitas']) ?? "";
$npwp = CheckString($data['npwp']) ?? "";
$kelurahan = CheckString($data['kelurahan']) ?? "";
$kecamatan = CheckString($data['kecamatan']) ?? "";
$nop_pbb_asal = CheckString($data['nop_pbb_asal']) ?? "";
$nama_wp_asal = CheckString($data['nama_wp_asal']) ?? "";
$kelurahan_op = CheckString($data['kelurahan_op']) ?? "";
$kecamatan_op = CheckString($data['kecamatan_op']) ?? "";
$jenis_perolehan = CheckString($data['jenis_perolehan']) ?? "";
$status_sspd = CheckString($data['status_sspd']) ?? "";
$tgl_sspd_from = $data['tgl_sspd_from'] ?? "";
$tgl_sspd_to = $data['tgl_sspd_to'] ?? "";
$limit = $data['limit'] ?? "300";
$curl = new Curl($host_get_sspd_skpd);
$curl-> send('get', array(
			'no_sspd'=> $no_sspd,
			'kode_billing'=> $kode_billing,
			'ppat_id'=> $ppat_id,
			'nama_wp'=> $nama_wp, 
			'npwp'=> $npwp,
			'no_identitas'=> $no_identitas,
			'kelurahan'=> $kelurahan,
			'kecamatan'=> $kecamatan,
			'nop_pbb_asal'=> $nop_pbb_asal,
			'nama_wp_asal'=> $nama_wp_asal,
			'kelurahan_op'=> $kelurahan_op,
			'kecamatan_op'=> $kecamatan_op,
			'jenis_perolehan'=> $jenis_perolehan,
			'status_sspd'=> $status_sspd,
			'tgl_sspd_from'=> $tgl_sspd_from,
			'tgl_sspd_to'=> $tgl_sspd_to,
			'action'=>  encrypt("get",$datakey),
			'reply'=> $allow,
			'eng_id'=> $eng_id,
			'token'=> encrypt($username,$datakey),
			'access'=> encrypt($session,$datakey),
			'limit'=>$limit
			));
echo $curl->getResponse();
};

 
 


