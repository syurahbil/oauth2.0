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
		$action = $data['action'];
		if ($action=="get")
		{
			if (in_array("2",$multirule))
			{
			get($data);
			}
			else
			{
				$reply = array('status' => 'Anda tidak mempunyai hak untuk mengakses data');
				echo json_encode($reply);
			}
		}
		else
		{
			if (in_array("2",$multirule))
			{
			check($data);
			}
			else
			{
				$reply = array('status' => 'Anda tidak mempunyai hak untuk mengakses data');
				echo json_encode($reply);
			}
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
$limit = $data['limit'] ?? "5";
$curl = new Curl($host_get_pbb);
$curl-> send('get', array(
			'nop_pbb_asal'=> $nop_pbb_asal,
			'action'=>  encrypt("get",$datakey),
			'reply'=> $allow,
			'token'=> encrypt($username,$datakey),
			'access'=> encrypt($session,$datakey),
			'limit'=>$limit
			));
// $data = json_decode($curl->getResponse());
// echo $data[0]->status;
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
global $multirule, $datakey, $username, $session, $host_post_wp;

if (in_array("1",$multirule) || in_array("2",$multirule))
	{
		if (decrypt($data['action'],$datakey) == "edit")
		{
			if (in_array("10",$multirule))
			{
			$allow = encrypt("yes",$datakey);
			}
			else
			{
			$allow = encrypt("no",$datakey);	
			}
		}
		else
		{
		$allow = encrypt("yes",$datakey);	
		}
	}
	else
	{
	$allow = encrypt("no",$datakey);
	}
$curl = new Curl($host_post_wp);
$curl-> send('post', array(
			'row_id'=> CheckString($data['row_id']),
			'nama_wp'=> CheckString($data['nama_wp']), 
			'no_identitas'=> CheckString($data['no_identitas']), 
			'no_nop'=> CheckString($data['no_nop']),
			'npwp'=> CheckString($data['npwp']),
			'alamat_wp'=> CheckString($data['alamat_wp']),
			'rt'=> CheckString($data['rt']),
			'rw'=> CheckString($data['rw']),
			'kelurahan'=> CheckString($data['kelurahan']),
			'kecamatan'=> CheckString($data['kecamatan']),
			'kabupaten'=> CheckString($data['kabupaten']),
			'provinsi'=> CheckString($data['provinsi']),
			'kode_pos'=> CheckString($data['kode_pos']),
			'no_telp'=> CheckString($data['no_telp']),
			'no_hp'=> CheckString($data['no_hp']),
			'email'=> CheckString($data['email']),
			'jenis_wp'=> CheckString($data['jenis_wp']),
			'token'=> encrypt($username,$datakey),
			'access'=> encrypt($session,$datakey),
			'reply'=> $allow,
			'action'=> CheckString($data['action']),
			'code'=> CheckString($data['code'])
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

 


