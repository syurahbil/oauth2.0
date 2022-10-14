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
		$action = decrypt($data['action'],$datakey);
		if ($action=="get")
		{
			if (in_array("1",$multirule) || in_array("2",$multirule) || in_array("3",$multirule))
			{
			get($data);
			}
			else
			{
				$reply = array('status' => 'Anda tidak mempunyai hak untuk memposting data');
				echo json_encode($reply);
			}
		}
		else if ($action=="post")
		{
			if (in_array("1",$multirule) || in_array("2",$multirule) || in_array("3",$multirule))
			{
			post($data);
			}
			else
			{
				$reply = array('status' => 'Anda tidak mempunyai hak untuk memposting data');
				echo json_encode($reply);
			}
		}
		else
		{
			$reply = array('status' => 'Metode Action kirim data tidak dapat diterima (1).');
			echo json_encode($reply);
		}
	}  else {
		
		$reply = array('status' => 'Metode kirim data tidak dapat diterima (2).');
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
global $multirule, $datakey, $username, $session, $host_get_post_bpn;

if (in_array("1",$multirule) || in_array("2",$multirule) || in_array("3",$multirule))
	{
	$allow = encrypt("yes",$datakey);
	}
	else
	{
	$allow = encrypt("no",$datakey);
	}
$akta_id = CheckString($data['akta_id']) ?? "";
$nop = CheckString($data['nop']) ?? "";
$ppat = CheckString($data['ppat']) ?? "";
$nama_wp = CheckString($data['nama_wp']) ?? "";
$npwp = CheckString($data['npwp']) ?? "";
$no_sertifikat = CheckString($data['no_sertifikat']) ?? "";
$no_akta = CheckString($data['no_akta']) ?? "";
$tgl_akta_from = $data['tgl_akta_from'] ?? "";
$tgl_akta_to = $data['tgl_akta_to'] ?? "";
$limit = $data['limit'] ?? "300";
$curl = new Curl($host_get_post_bpn);
$curl-> send('get', array(
			'akta_id'=> $akta_id,
			'nop'=> $nop,
			'ppat'=> $ppat,
			'nama_wp'=> $nama_wp, 
			'npwp'=> $npwp,
			'no_sertifikat'=> $no_sertifikat,
			'no_akta'=> $no_akta,
			'tgl_akta_from'=> $tgl_akta_from,
			'tgl_akta_to'=> $tgl_akta_to,
			'action'=>  encrypt("get",$datakey),
			'reply'=> $allow,
			'token'=> encrypt($username,$datakey),
			'access'=> encrypt($session,$datakey),
			'limit'=>$limit
			));
echo $curl->getResponse();
};

function check($data) {
//require_once("../../dist/encrypt.php");	
global $multirule, $datakey, $username, $session, $host_get_pbb;
 if (in_array("2",$multirule))
	{
	$allow = encrypt("yes",$datakey);	
	}
	else
	{
	$allow = encrypt("no",$datakey);
	}
$nop_pbb_asal = CheckString($data['nop_pbb_asal']) ?? "";
$curl = new Curl($host_get_pbb);
$curl-> send('get', array(
			'nop_pbb_asal'=> $nop_pbb_asal,
			'action'=>  encrypt("check",$datakey),
			'reply'=> $allow,
			'token'=> encrypt($username,$datakey),
			'access'=> encrypt($session,$datakey)
			));
// $data = json_decode($curl->getResponse());
// echo $data[0]->status;
echo $curl->getResponse();
};

function post($data) {
global $multirule, $datakey, $username, $session, $host_send_bpn;

if (in_array("1",$multirule) || in_array("2",$multirule))
	{
		
		$allow = encrypt("yes",$datakey);	
	
	}
	else
	{
	$allow = encrypt("no",$datakey);
	}
$curl = new Curl($host_send_bpn);
$curl-> send('post', array(
			'ntpd'=> CheckString($data['ntpd']),
			'token'=> encrypt($username,$datakey),
			'access'=> encrypt($session,$datakey),
			'reply'=> $allow,
			'action'=> CheckString($data['action'])
			));

echo $curl->getResponse();
};


function delete($data) {
//require_once("../../dist/encrypt.php");	
global $multirule, $datakey, $username, $session, $host_get_wp;

if ((in_array("1",$multirule) || in_array("2",$multirule)) && in_array("10",$multirule) )
	{
	$allow = encrypt("yes",$datakey);
	}
	else
	{
	$allow = encrypt("no",$datakey);
	}
$curl = new Curl($host_get_wp);
$curl-> send('get', array(
			'ref'=> CheckString($data['ref']),
			'token'=> encrypt($username,$datakey),
			'access'=> encrypt($session,$datakey),
			'reply'=> $allow,			
			'action'=> encrypt("delete",$datakey)
			));
echo $curl->getResponse();
};

 


