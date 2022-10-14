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

	$nama_wp = CheckString($data['nama_wp']) ?? "";
	$no_identitas = CheckString($data['no_identitas']) ?? "";
	$no_nop = CheckString($data['no_nop']) ?? "";
	$npwp = CheckString($data['npwp']) ?? "";
	$kelurahan = CheckString($data['kelurahan']) ?? "";
	$kecamatan = CheckString($data['kecamatan']) ?? "";
	$no_hp = CheckString($data['no_hp']) ?? "";
	$email = CheckString($data['email']) ?? "";
	$jenis_wp = CheckString($data['jenis_wp']) ?? "";
	$tgl_daftar_from = CheckString($data['tgl_daftar_from']) ?? "";
	$tgl_daftar_to = CheckString($data['tgl_daftar_to']) ?? "";
	$limit = CheckString($data['limit']) ?? "300";
	 
	 
	if ($nama_wp!="")
	{
		$filter_nama_wp = " a.nama_wp LIKE '%$nama_wp%' ";
	}
	else
	{
		$filter_nama_wp = "";
	}
	if ($no_identitas!="")
	{
		$filter_no_identitas = " a.no_identitas='$no_identitas' ";
	}
	else
	{
		$filter_no_identitas = "";
	}
	if ($no_nop!="")
	{
		$filter_no_nop = " a.no_nop='$no_nop' ";
	}
	else
	{
		$filter_no_nop = "";
	}
	if ($npwp!="")
	{
		$filter_npwp = " a.npwp='$npwp' ";
	}
	else
	{
		$filter_npwp = "";
	}
	if ($kelurahan!="")
	{
		$filter_kelurahan = " a.kelurahan='$kelurahan' ";
	}
	else
	{
		$filter_kelurahan = "";
	}
	if ($kecamatan!="")
	{
		$filter_kecamatan = " a.kecamatan='$kecamatan' ";
	}
	else
	{
		$filter_kecamatan = "";
	}
	if ($no_hp!="")
	{
		$filter_no_hp = " a.no_hp='$no_hp' ";
	}
	else
	{
		$filter_no_hp = "";
	}
	if ($email!="")
	{
		$filter_email = " a.email='$email' ";
	}
	else
	{
		$filter_email = "";
	}
	if ($jenis_wp!="")
	{
		$filter_jenis_wp = " a.jenis_wajib_pajak='$jenis_wp' ";
	}
	else
	{
		$filter_jenis_wp = "";
	}
	if ($tgl_daftar_from!="" && $tgl_daftar_to!="" )
	{
		$filter_tgl_daftar = " a.register_date BETWEEN '$tgl_daftar_from' AND '$tgl_daftar_to' ";
	}
	else
	{
		$filter_tgl_daftar = "";
	}
	
	$filter_data = "";
	
	if ($filter_nama_wp!="")
	{
		$filter_data.=$filter_nama_wp;
	}
	if ($filter_no_identitas != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_no_identitas;
	}
	else
	{
		$filter_data.=$filter_no_identitas;
	}
	if ($filter_no_nop != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_no_nop;
	}
	else
	{
		$filter_data.=$filter_no_nop;
	}
	if ($filter_npwp != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_npwp;
	}
	else
	{
		$filter_data.=$filter_npwp;
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
	if ($filter_no_hp != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_no_hp;
	}
	else
	{
		$filter_data.=$filter_no_hp;
	}
	if ($filter_email != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_email;
	}
	else
	{
		$filter_data.=$filter_email;
	}
	if ($filter_jenis_wp != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_jenis_wp;
	}
	else
	{
		$filter_data.=$filter_jenis_wp;
	}
	if ($filter_tgl_daftar != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_tgl_daftar;
	}
	else
	{
		$filter_data.=$filter_tgl_daftar;
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


