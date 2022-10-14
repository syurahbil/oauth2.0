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
global $multirule, $datakey, $username, $user_rule, $engineer_id, $session, $host_get_sspd;

	$no_skpd_lb = CheckString($data['no_skpd_lb']) ?? "";
	$no_sspd = CheckString($data['no_sspd']) ?? "";
	$kode_billing = CheckString($data['kode_billing']) ?? "";
	$ppat_id = CheckString($data['ppat_id']) ?? "";
	$nama_wp = CheckString($data['nama_wp']) ?? "";
	$npwp = CheckString($data['npwp']) ?? "";
	$no_identitas = CheckString($data['no_identitas']) ?? "";
	$kelurahan = CheckString($data['kelurahan']) ?? "";
	$kecamatan = CheckString($data['kecamatan']) ?? "";
	$nop_pbb_asal = CheckString($data['nop_pbb_asal']) ?? "";
	$nama_wp_asal = CheckString($data['nama_wp_asal']) ?? "";
	$kelurahan_op = CheckString($data['kelurahan_op']) ?? "";
	$kecamatan_op = CheckString($data['kecamatan_op']) ?? "";
	$jenis_perolehan = CheckString($data['jenis_perolehan']) ?? "";
	$status_skpd = CheckString($data['status_skpd']) ?? "";
	$ptsl_status = CheckString($data['ptsl_status']) ?? "No";
	$tgl_skpd_from = $data['tgl_skpd_from'] ?? "";
	$tgl_skpd_to = $data['tgl_skpd_to'] ?? "";
	 
	 
	 
	if ($nama_wp!="")
	{
		$filter_nama_wp = " a.nama_wp LIKE '%$nama_wp%' ";
	}
	else
	{
		$filter_nama_wp = "";
	}
	
	if ($no_skpd_lb!="")
	{
		$filter_no_skpd_lb = " a.no_skpd_lb='$no_skpd_lb' ";
	}
	else
	{
		$filter_no_skpd_lb = "";
	}
	
	if ($no_sspd!="")
	{
		$filter_no_sspd = " a.no_sspd='$no_sspd' ";
	}
	else
	{
		$filter_no_sspd = "";
	}
	
	if ($ppat_id!="")
	{
		$filter_ppat_id = " a.ppat_id='$ppat_id' ";
	}
	else
	{
		$filter_ppat_id = "";
	}
	
	if ($kode_billing!="")
	{
		$filter_kode_biling = " a.kode_billing='$kode_billing' ";
	}
	else
	{
		$filter_kode_biling = "";
	}
	
	 
	if ($nama_wp_asal!="")
	{
		$filter_nama_wp_asal = " a.nama_wp_asal LIKE '%$nama_wp_asal%' ";
	}
	else
	{
		$filter_nama_wp_asal = "";
	}
	
	if ($ptsl_status!="")
	{
		$filter_ptsl_status = " a.ptsl_status='$ptsl_status' ";
	}
	else
	{
		$filter_ptsl_status = "";
	}
	
	if ($no_identitas!="")
	{
		$filter_no_identitas = " a.no_identitas='$no_identitas' ";
	}
	else
	{
		$filter_no_identitas = "";
	}
	if ($nop_pbb_asal!="")
	{
		$filter_no_nop = " a.nop_pbb='$nop_pbb_asal' ";
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
	if ($kelurahan_op!="")
	{
		$filter_kelurahan_op = " a.kelurahan_op='$kelurahan_op' ";
	}
	else
	{
		$filter_kelurahan_op = "";
	}
	if ($kecamatan_op!="")
	{
		$filter_kecamatan_op = " a.kecamatan_op='$kecamatan_op' ";
	}
	else
	{
		$filter_kecamatan_op = "";
	}
	if ($status_skpd!="")
	{
		$filter_status_skpd = " a.status='$status_skpd' ";
	}
	else
	{
		$filter_status_skpd = "";
	}
	if ($jenis_perolehan!="")
	{
		$filter_jenis_perolehan = " a.jenis_perolehan='$jenis_perolehan' ";
	}
	else
	{
		$filter_jenis_perolehan = "";
	}
	if ($tgl_skpd_from!="" && $tgl_skpd_to!="" )
	{
		$filter_tgl_skpd = " a.tgl_skpd_lb BETWEEN '$tgl_skpd_from' AND '$tgl_skpd_to' ";
	}
	else
	{
		$filter_tgl_skpd = "";
	}
	
	$filter_data = "";
	
	if ($filter_nama_wp!="")
	{
		$filter_data.=$filter_nama_wp;
	}
	if ($filter_no_sspd != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_no_sspd;
	}
	else
	{
		$filter_data.=$filter_no_sspd;
	}
	
	if ($filter_no_skpd_lb != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_no_skpd_lb;
	}
	else
	{
		$filter_data.=$filter_no_skpd_lb;
	}
	if ($filter_kode_biling != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_kode_biling;
	}
	else
	{
		$filter_data.=$filter_kode_biling;
	}
	if ($filter_ppat_id != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_ppat_id;
	}
	else
	{
		$filter_data.=$filter_ppat_id;
	}
	if ($filter_nama_wp_asal != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_nama_wp_asal;
	}
	else
	{
		$filter_data.=$filter_nama_wp_asal;
	}
	if ($filter_no_identitas != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_no_identitas;
	}
	else
	{
		$filter_data.=$filter_no_identitas;
	}
	if ($filter_ptsl_status != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_ptsl_status;
	}
	else
	{
		$filter_data.=$filter_ptsl_status;
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
	if ($filter_status_skpd != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_status_skpd;
	}
	else
	{
		$filter_data.=$filter_status_skpd;
	}
	 
	if ($filter_jenis_perolehan != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_jenis_perolehan;
	}
	else
	{
		$filter_data.=$filter_jenis_perolehan;
	}
	if ($filter_tgl_skpd != "" && ($filter_data !=""))
	{
		$filter_data.=" AND ".$filter_tgl_skpd;
	}
	else
	{
		$filter_data.=$filter_tgl_skpd;
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


