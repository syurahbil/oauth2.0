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
		if (in_array("1",$multirule) && in_array("11",$multirule) )
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
	 
	 
	if ($no_ntpd!="")
	{
		$filter_no_ntpd= " a.ntpd='$no_ntpd' ";
	}
	else
	{
		$filter_no_ntpd= "";
	}
	
	if ($no_ref_bank!="")
	{
		$filter_no_ref_bank= " a.no_ref='$no_ref_bank' ";
	}
	else
	{
		$filter_no_ref_bank = "";
	}
	
	if ($no_ref!="")
	{
		$filter_no_ref= " b.no_ref='$no_ref' ";
	}
	else
	{
		$filter_no_ref = "";
	}
	
	if ($kode_billing!="")
	{
		$filter_kode_billing = " a.kode_billing='$kode_billing' ";
	}
	else
	{
		$filter_kode_billing = "";
	}
	 
	
	if ($nama_wp!="")
	{
		$filter_nama_wp = " b.nama_wp LIKE '%$nama_wp%' ";
	}
	else
	{
		$filter_nama_wp = "";
	}
	 
	if ($nop_pbb!="")
	{
		$filter_no_nop = " b.nop='$nop_pbb' ";
	}
	else
	{
		$filter_no_nop = "";
	}
	 
	 
	if ($kelurahan!="")
	{
		$filter_kelurahan = " b.kelurahan='$kelurahan' ";
	}
	else
	{
		$filter_kelurahan = "";
	}
	if ($kecamatan!="")
	{
		$filter_kecamatan = " b.kecamatan='$kecamatan' ";
	}
	else
	{
		$filter_kecamatan = "";
	}
	if ($status_bpn!="")
	{
		$filter_status_bpn = " a.status_bpn='$status_bpn' ";
	}
	else
	{
		$filter_status_bpn = "";
	}
	 
	if ($tgl_bayar_from!="" && $tgl_bayar_to!="" )
	{
		$filter_tgl_bayar = " DATE(a.tgl_pembayaran) BETWEEN '$tgl_bayar_from' AND '$tgl_bayar_to' ";
	}
	else
	{
		$filter_tgl_bayar = "";
	}
	
	$filter_data = "";
	
	if ($filter_no_ref!="")
	{
		$filter_data.=$filter_no_ref;
	}
	if ($filter_no_ntpd != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_no_ntpd;
	}
	else
	{
		$filter_data.=$filter_no_ntpd;
	}
	
	if ($filter_no_ref_bank != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_no_ref_bank;
	}
	else
	{
		$filter_data.=$filter_no_ref_bank;
	}
	 
	if ($filter_kode_billing != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_kode_billing;
	}
	else
	{
		$filter_data.=$filter_kode_billing;
	}
	 
	if ($filter_nama_wp != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_nama_wp;
	}
	else
	{
		$filter_data.=$filter_nama_wp;
	}
	 
	if ($filter_no_nop != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_no_nop;
	}
	else
	{
		$filter_data.=$filter_no_nop;
	}
	 
	if ($filter_kelurahan != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_kelurahan;
	}
	else
	{
		$filter_data.=$filter_kelurahan;
	}
	if ($filter_kecamatan != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_kecamatan;
	}
	else
	{
		$filter_data.=$filter_kecamatan;
	}
	if ($filter_status_bpn != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_status_bpn;
	}
	else
	{
		$filter_data.=$filter_status_bpn;
	}
	 
	if ($filter_tgl_bayar != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_tgl_bayar;
	}
	else
	{
		$filter_data.=$filter_tgl_bayar;
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


