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
		if ((in_array("1",$multirule) && in_array("11",$multirule)) || (in_array("2",$multirule) && in_array("11",$multirule)) )
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
	$kode_billing = CheckString($data['kode_billing']) ?? "";
	$billing_type = CheckString($data['billing_type']) ?? "";
	$nop_pbb_asal = CheckString($data['nop_pbb_asal']) ?? "";
	$nama_wp_asal = CheckString($data['nama_wp_asal']) ?? "";
	$kelurahan_op = CheckString($data['kelurahan']) ?? "";
	$kecamatan_op = CheckString($data['kecamatan']) ?? "";
	$status_bayar = CheckString($data['status_bayar']) ?? "";
	$tgl_tagihan_from = $data['tgl_tagihan_from'] ?? "";
	$tgl_tagihan_to = $data['tgl_tagihan_to'] ?? "";
	$limit = $data['limit'] ?? "300";
	 
	
	
	if ($no_ref!="")
	{
		$filter_no_ref= " a.ref_no='$no_ref' ";
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
	
	if ($billing_type!="")
	{
		$filter_billing_type = " a.billing_type='$billing_type' ";
	}
	else
	{
		$filter_billing_type = "";
	}
	
	if ($nama_wp_asal!="")
	{
		$filter_nama_wp_asal = " a.nama_wp LIKE '%$nama_wp_asal%' ";
	}
	else
	{
		$filter_nama_wp_asal = "";
	}
	 
	if ($nop_pbb_asal!="")
	{
		$filter_no_nop = " a.nop='$nop_pbb_asal' ";
	}
	else
	{
		$filter_no_nop = "";
	}
	 
	 
	if ($kelurahan_op!="")
	{
		$filter_kelurahan_op = " a.kelurahan='$kelurahan_op' ";
	}
	else
	{
		$filter_kelurahan_op = "";
	}
	if ($kecamatan_op!="")
	{
		$filter_kecamatan_op = " a.kecamatan='$kecamatan_op' ";
	}
	else
	{
		$filter_kecamatan_op = "";
	}
	if ($status_bayar!="")
	{
		$filter_status_bayar = " a.status_bayar='$status_bayar' ";
	}
	else
	{
		$filter_status_bayar = "";
	}
	 
	if ($tgl_tagihan_from!="" && $tgl_tagihan_to!="" )
	{
		$filter_tgl_tagihan = " DATE(a.register_date) BETWEEN '$tgl_tagihan_from' AND '$tgl_tagihan_to' ";
	}
	else
	{
		$filter_tgl_tagihan = "";
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
	if ($filter_billing_type != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_billing_type;
	}
	else
	{
		$filter_data.=$filter_billing_type;
	}
	if ($filter_nama_wp_asal != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_nama_wp_asal;
	}
	else
	{
		$filter_data.=$filter_nama_wp_asal;
	}
	 
	if ($filter_no_nop != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_no_nop;
	}
	else
	{
		$filter_data.=$filter_no_nop;
	}
	 
	if ($filter_kelurahan_op != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_kelurahan_op;
	}
	else
	{
		$filter_data.=$filter_kelurahan_op;
	}
	if ($filter_kecamatan_op != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_kecamatan_op;
	}
	else
	{
		$filter_data.=$filter_kecamatan_op;
	}
	if ($filter_status_bayar != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_status_bayar;
	}
	else
	{
		$filter_data.=$filter_status_bayar;
	}
	 
	if ($filter_tgl_tagihan != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_tgl_tagihan;
	}
	else
	{
		$filter_data.=$filter_tgl_tagihan;
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


