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
	$ntpd = CheckString($data['ntpd']) ?? "";
	$kode_billing = CheckString($data['kode_billing']) ?? "";
	$tgl_transaksi_from = $data['tgl_transaksi_from'] ?? "";
	$tgl_transaksi_to = $data['tgl_transaksi_to'] ?? "";
	
	if ($no_ref!="")
	{
		$filter_no_ref= " a.no_ref='$no_ref' ";
	}
	else
	{
		$filter_no_ref = "";
	}
	
	if ($ntpd!="")
	{
		$filter_ntpd= " a.ntpd='$ntpd' ";
	}
	else
	{
		$filter_ntpd = "";
	}
	
	if ($kode_billing!="")
	{
		$filter_kode_billing= " a.com_type='$jenis_com' ";
	}
	else
	{
		$filter_kode_billing = "";
	}
	  
	 
	if ($tgl_transaksi_from!="" && $tgl_transaksi_to!="" )
	{
		$filter_tgl_transaksi = " DATE(a.tgl_pembayaran) BETWEEN '$tgl_transaksi_from' AND '$tgl_transaksi_to' ";
	}
	else
	{
		$filter_tgl_transaksi = "";
	}
	
	$filter_data = "";
	
	if ($filter_no_ref!="")
	{
		$filter_data.=$filter_no_ref;
	}
	if ($filter_kode_billing != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_kode_billing;
	}
	else
	{
		$filter_data.=$filter_kode_billing;
	}
	if ($filter_ntpd != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_ntpd;
	}
	else
	{
		$filter_data.=$filter_ntpd;
	}
	
	
	if ($filter_tgl_transaksi != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_tgl_transaksi;
	}
	else
	{
		$filter_data.=$filter_tgl_transaksi;
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


