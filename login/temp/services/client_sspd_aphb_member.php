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
		get($data);
	}
	else
	{
		cancel($data);	
	}
} else if ($method == 'post') {
	if (in_array("1",$multirule) || in_array("2",$multirule))
	{
	$action = decrypt($data['action_pemberi'],$datakey);
	if ($action == "posting")
		{ 
			put($data);
			 
		}
		else
		{
			post($data);
		}
	}
	else
	{
	$reply = array('status' => 'Anda tidak mempunyai hak untuk register data SSPD Baru', 'error' => 'yes');
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
global $multirule, $datakey, $username, $user_rule, $engineer_id, $session, $host_post_sspd_aphb_member;

if (in_array("1",$multirule) || in_array("2",$multirule))
	{
	$allow = encrypt("yes",$datakey);
	}
	else
	{
	$allow = encrypt("no",$datakey);
	}
	 
$code = CheckString($data['code']) ?? "";
 
$curl = new Curl($host_post_sspd_aphb_member);
$curl-> send('get', array(
			'code'=> $code,			 
			'action'=>  encrypt("get",$datakey),
			'reply'=> $allow,			 
			'token'=> encrypt($username,$datakey),
			'access'=> encrypt($session,$datakey)
			));
echo $curl->getResponse();
};

function post($data) {
global $multirule, $datakey, $username, $user_rule, $session, $host_post_sspd_aphb_member;
 
if (in_array("1",$multirule) || in_array("2",$multirule))
	{
	$allow = encrypt("yes",$datakey);
	}
	else
	{
	$allow = encrypt("no",$datakey);
	}
 
$curl = new Curl($host_post_sspd_aphb_member);
$curl-> send('post', array(		
			'sertifikat'=> CheckString($data['code_sertifikat']),
			'nama_wp'=> CheckString($data['nama_wp_pemberi']),
			'no_identitas'=> CheckString($data['no_identitas_pemberi']),
			'npwp'=> CheckString($data['npwp_pemberi']),
			'alamat_wp'=> CheckString($data['alamat_wp_pemberi']),
			'rt'=> CheckString($data['rt_pemberi']),
			'rw'=> CheckString($data['rw_pemberi']),
			'kelurahan'=> CheckString($data['kelurahan_pemberi']),
			'kecamatan'=> CheckString($data['kecamatan_pemberi']),
			'kabupaten'=> CheckString($data['kabupaten_pemberi']),
			'provinsi'=> CheckString($data['provinsi_pemberi']),
			'kode_pos'=> CheckString($data['kode_pos_pemberi']),
			'no_telp'=> CheckString($data['no_hp_pemberi']),			 
			'luas_bumi'=> CheckString($data['luas_bumi_pemberi']),
			'luas_bangunan'=> CheckString($data['luas_bangunan_pemberi']),			 
			'token'=> encrypt($username,$datakey),
			'access'=> encrypt($session,$datakey),
			'resolver'=> $user_rule,
			'reply'=> $allow, 
			'action'=> CheckString($data['action_pemberi']),
			'code'=> CheckString($data['code_pemberi'])
			));
echo $curl->getResponse();
 
};


function cancel($data) {
//require_once("../../dist/encrypt.php");	
global $multirule, $datakey, $username, $session, $host_post_sspd_aphb_member;

 
$allow = encrypt("yes",$datakey);
	 
$username =  encrypt($_SESSION['user-session'],$datakey);
$curl = new Curl($host_post_sspd_aphb_member);
$curl-> send('get', array(
			'row_id'=> CheckString($data['ref']),
			'code'=> CheckString($data['code']),
			'token'=> $username,
			'access'=> encrypt($session,$datakey),
			'reply'=> $allow,			
			'action'=> encrypt("cancel",$datakey)
			));
echo $curl->getResponse();
};

function put($data) {
//require_once("../../dist/encrypt.php");	
global $multirule, $datakey, $username, $session, $host_post_sspd_aphb_member;

if (in_array("1",$multirule) || in_array("2",$multirule))
	{
	$allow = encrypt("yes",$datakey);
	}
	else
	{
	$allow = encrypt("no",$datakey);
	}
	 
$username =  encrypt($_SESSION['user-session'],$datakey);
$curl = new Curl($host_post_sspd_aphb_member);
$curl-> send('post', array(
			'code'=> CheckString($data['code']),
			'token'=> $username,
			'access'=> encrypt($session,$datakey),
			'reply'=> $allow,			
			'action'=> encrypt("posting",$datakey)
			));
echo $curl->getResponse();
};

 


