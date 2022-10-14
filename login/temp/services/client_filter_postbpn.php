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
		if ((in_array("1",$multirule) || in_array("2",$multirule) || in_array("3",$multirule)) && in_array("11",$multirule) )
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
	 
	 
	
	if ($nama_wp!="")
	{
		$filter_nama_wp = " a.nama_wp LIKE '%$nama_wp%' ";
	}
	else
	{
		$filter_nama_wp = "";
	}
	
	if ($akta_id!="")
	{
		$filter_akta_id = " a.akta_id='$akta_id' ";
	}
	else
	{
		$filter_akta_id = "";
	}
	
	if ($nop!="")
	{
		$filter_nop = " a.nop='$nop' ";
	}
	else
	{
		$filter_nop = "";
	}
	
	if ($ppat!="")
	{
		$filter_ppat = " a.ppat LIKE '%$ppat%' ";
	}
	else
	{
		$filter_ppat = "";
	}
	
	 
	if ($npwp!="")
	{
		$filter_npwp = " a.npwp='$npwp' ";
	}
	else
	{
		$filter_npwp = "";
	}
	if ($no_sertifikat!="")
	{
		$filter_no_sertifikat = " a.no_sertifikat='$no_sertifikat' ";
	}
	else
	{
		$filter_no_sertifikat = "";
	}
	if ($no_akta!="")
	{
		$filter_no_akta = " a.no_akta='$no_akta' ";
	}
	else
	{
		$filter_no_akta = "";
	}
	
	 
	if ($tgl_akta_from!="" && $tgl_akta_to!="" )
	{
		$filter_tgl_akta = " a.tgl_akta BETWEEN '$tgl_akta_from' AND '$tgl_akta_to' ";
	}
	else
	{
		$filter_tgl_akta = "";
	}
	
	$filter_data = "";
	
	if ($filter_nama_wp!="")
	{
		$filter_data.=$filter_nama_wp;
	}
	if ($filter_akta_id != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_akta_id;
	}
	else
	{
		$filter_data.=$filter_akta_id;
	}
	if ($filter_nop != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_nop;
	}
	else
	{
		$filter_data.=$filter_nop;
	}
	if ($filter_ppat != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_ppat;
	}
	else
	{
		$filter_data.=$filter_ppat;
	}
	 
	if ($filter_npwp != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_npwp;
	}
	else
	{
		$filter_data.=$filter_npwp;
	}
	 
	if ($filter_no_sertifikat != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_no_sertifikat;
	}
	else
	{
		$filter_data.=$filter_no_sertifikat;
	}
	if ($filter_no_akta != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_no_akta;
	}
	else
	{
		$filter_data.=$filter_no_akta;
	}
	 
	if ($filter_tgl_akta != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_tgl_akta;
	}
	else
	{
		$filter_data.=$filter_tgl_akta;
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


