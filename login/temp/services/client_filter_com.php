<?php
session_start();
include('vendor/autoload.php');

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
		if (in_array("1",$multirule) && in_array("11",$multirule))
		{
		get($data);
		}
		else
		{
			$reply = array('status' => 'Anda tidak mempunyai hak untuk export data', 'error' => 'yes');
			echo json_encode($reply);
		}
	}
	else
	{
			$reply = array('status' => 'Method Kirim Data tidak di perkenankan', 'error' => 'yes');
			echo json_encode($reply);
	}
} else {
	
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
global $multirule, $datakey, $username, $session;

	$no_ref = CheckString($data['no_ref']) ?? "";
	$jenis_com = CheckString($data['jenis_com']) ?? "";
	$tgl_com_from = $data['tgl_com_from'] ?? "";
	$tgl_com_to = $data['tgl_com_to'] ?? "";
	$limit = $data['limit'] ?? "300";
 
	
	if ($no_ref!="")
	{
		$filter_no_ref= " a.no_ref='$no_ref' ";
	}
	else
	{
		$filter_no_ref = "";
	}
	
	if ($jenis_com!="")
	{
		$filter_jenis_com= " a.com_type='$jenis_com' ";
	}
	else
	{
		$filter_jenis_com = "";
	}
	  
	 
	if ($tgl_com_from!="" && $tgl_com_to!="" )
	{
		$filter_tgl_com = " DATE(a.register_date) BETWEEN '$tgl_com_from' AND '$tgl_com_to' ";
	}
	else
	{
		$filter_tgl_com = "";
	}
	
	$filter_data = "";
	
	if ($filter_no_ref!="")
	{
		$filter_data.=$filter_no_ref;
	}
	if ($filter_jenis_com != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_jenis_com;
	}
	else
	{
		$filter_data.=$filter_jenis_com;
	}
	
	if ($filter_tgl_com != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_tgl_com;
	}
	else
	{
		$filter_data.=$filter_tgl_com;
	}	 

if ($filter_data != "")
	{  // check filter !=0
		$filter= encrypt($filter_data,$datakey);
		$reply = array('status' => 'OK', 'error' => 'no', 'filter' => $filter);
		echo json_encode($reply);
	} // check filter
	else
	{
		$reply = array('status' => 'OK', 'error' => 'no', 'filter' => '');
		echo json_encode($reply);
	}
exit;
};


