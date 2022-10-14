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
	$action = decrypt($data['action'],$datakey);
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
global $multirule, $datakey, $username, $user_rule, $engineer_id, $session, $host_post_sspd_aphb;

if (in_array("1",$multirule) || in_array("2",$multirule))
	{
	$allow = encrypt("yes",$datakey);
	}
	else
	{
	$allow = encrypt("no",$datakey);
	}
	 
$code = CheckString($data['code']) ?? "";
 
$curl = new Curl($host_post_sspd_aphb);
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
global $multirule, $datakey, $username, $user_rule, $session, $host_post_sspd_aphb, $host_get_pbb;
if (in_array("1",$multirule) && in_array("14",$multirule))
	{
	$force_edit = encrypt("yes",$datakey);
	}
	else
	{
	$force_edit = encrypt("no",$datakey);
	}
if (in_array("1",$multirule) || in_array("2",$multirule))
	{
	$allow = encrypt("yes",$datakey);
	}
	else
	{
	$allow = encrypt("no",$datakey);
	}
if (isset($data['check_ptsl']))
{
	$check_ptsl = CheckString($data['check_ptsl']);
}
else
{
	$check_ptsl = "Tidak";
}
$setoran_berdasarkan = CheckString($data['setoran_berdasarkan']); 
$pengurangan_ptsl = str_replace(",","",CheckString($data['pengurangan_ptsl']));
$persentase = CheckString($data['persentase']);
$kena_pajak = str_replace(",","",CheckString($data['NPOPKP']));
$setoran_seharusnya = round($kena_pajak*($persentase/100));
$no_sk_bpn = CheckString($data['no_sk_bpn']);
$tgl_sk_bpn = CheckString($data['tgl_sk_bpn']);
if ($check_ptsl == "Ya" && $no_sk_bpn!="" && $tgl_sk_bpn!= "")
{
	$setoran_seharusnya = $setoran_seharusnya-($setoran_seharusnya*($pengurangan_ptsl/100));
}
if ($setoran_berdasarkan == "2")
{
	$jlh_pengurangan = str_replace(",","",CheckString($data['jlh_stpd_skpd_kb']));
	$setoran_seharusnya = $setoran_seharusnya - $jlh_pengurangan;
}
$nop_pbb_asal = CheckString($data['nop_pbb_asal']);
$curl_pbb = new Curl($host_get_pbb);
$curl_pbb-> send('get', array(
			'nop_pbb_asal'=> CheckString($data['nop_pbb_asal']),
			'token'=> encrypt($username,$datakey),
			'access'=> encrypt($session,$datakey),
			'reply'=> $allow,			
			'action'=> encrypt("check",$datakey)
			));
$cek = json_decode($curl_pbb->getResponse());

if (isset($cek[0]->status_bayar))
{
$status = $cek[0]->status_bayar;
}
else
{
	$status = "0";
}

if ($status == "1")
{

if (in_array("1",$multirule) || in_array("2",$multirule))
	{
		if (decrypt($data['action'],$datakey) == "edit")
		{
			if (in_array("9",$multirule))
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
$curl = new Curl($host_post_sspd_aphb);
$curl-> send('post', array(			 
			'ppat_id'=> CheckString($data['ppat_id']),
			'nama_ppat'=> CheckString($data['nama_ppat']),
			'nama_wp'=> CheckString($data['nama_wp']), 
			'no_identitas'=> CheckString($data['no_identitas']),
			'npwp'=> CheckString($data['npwp']),
			'alamat_wp'=> CheckString($data['alamat_wp']),
			'no_blok'=> CheckString($data['no_blok']),
			'rt'=> CheckString($data['rt']),
			'rw'=> CheckString($data['rw']),
			'kelurahan'=> CheckString($data['kelurahan']),
			'kecamatan'=> CheckString($data['kecamatan']),
			'kabupaten'=> CheckString($data['kabupaten']),
			'provinsi'=> CheckString($data['provinsi']),
			'kode_pos'=> CheckString($data['kode_pos']),
			'nama_penjual'=> CheckString($data['nama_penjual']),
			'alamat_penjual'=> CheckString($data['alamat_penjual']),
			'telp_penjual'=> CheckString($data['telp_penjual']),
			'nop_pbb_asal'=> CheckString($data['nop_pbb_asal']),
			'nama_wp_asal'=> CheckString($data['nama_wp_asal']),
			'no_sertifikat'=> CheckString($data['no_sertifikat']),
			'alamat_op'=> CheckString($data['alamat_op']),
			'rt_op'=> CheckString($data['rt_op']),
			'rw_op'=> CheckString($data['rw_op']),
			'no_blok_op'=> CheckString($data['no_blok_op']),
			'kelurahan_op'=> CheckString($data['kelurahan_op']),
			'kecamatan_op'=> CheckString($data['kecamatan_op']),
			'kabupaten_op'=> CheckString($data['kabupaten_op']),
			'jenis_perolehan'=> CheckString($data['jenis_perolehan']),
			'luas_bumi_asal'=> CheckString($data['luas_bumi_asal']),
			'luas_bangunan_asal'=> CheckString($data['luas_bangunan_asal']),
			'njop_bumi_asal'=> str_replace(",","",CheckString($data['njop_bumi_asal'])),
			'njop_bangunan_asal'=> str_replace(",","",CheckString($data['njop_bangunan_asal'])),
			'total_njop_asal'=> str_replace(",","",CheckString($data['total_njop_asal'])),
			'harga_transaksi'=> str_replace(",","",CheckString($data['harga_transaksi'])),
			'luas_bumi'=> CheckString($data['luas_bumi']),
			'luas_bangunan'=> CheckString($data['luas_bangunan']),
			'njop_bumi'=> str_replace(",","",CheckString($data['njop_bumi'])),
			'njop_bangunan'=> str_replace(",","",CheckString($data['njop_bangunan'])),
			'total_njop'=> str_replace(",","",CheckString($data['total_njop'])),
			'NPOPTKP'=> str_replace(",","",CheckString($data['NPOPTKP'])),
			'NPOPKP'=> str_replace(",","",CheckString($data['NPOPKP'])),
			'persentase'=> CheckString($data['persentase']),
			'pengenaan_hibah'=> str_replace(",","",CheckString($data['pengenaan_hibah'])),
			'no_sk'=> CheckString($data['no_sk']),
			'tgl_sk'=> CheckString($data['tgl_sk']),
			'pengurangan'=> str_replace(",","",CheckString($data['pengurangan'])),
			'check_ptsl'=> $check_ptsl,
			'no_sk_bpn'=> CheckString($data['no_sk_bpn']),
			'tgl_sk_bpn'=> CheckString($data['tgl_sk_bpn']),
			'pengurangan_ptsl'=> str_replace(",","",CheckString($data['pengurangan_ptsl'])),
			'setoran_berdasarkan'=> CheckString($data['setoran_berdasarkan']),
			'jumlah_setoran'=> $setoran_seharusnya,
			'keterangan'=> CheckString($data['keterangan']),
			'stpd_skpd_kb'=> CheckString($data['stpd_skpd_kb']),
			'tgl_stpd_skpd_kb'=> CheckString($data['tgl_stpd_skpd_kb']),
			'jlh_stpd_skpd_kb'=> str_replace(",","",CheckString($data['jlh_stpd_skpd_kb'])),
			'keterangan_lainnya'=> CheckString($data['keterangan_lainnya']),
			'token'=> encrypt($username,$datakey),
			'access'=> encrypt($session,$datakey),
			'resolver'=> $user_rule,
			'reply'=> $allow,
			'force'=> $force_edit,
			'action'=> CheckString($data['action']),
			'code_member'=> CheckString($data['code_member']),
			'code'=> CheckString($data['code'])
			));
echo $curl->getResponse();
}
else
{
	if ($status != "1")
	{
		$reply = array('status' => 'Status PBB masih mempunyai tagihan yang belum dibayar, lunasi terlebih dahulu tagihan tersebut.');
		echo json_encode($reply);
	}
	else
	{
		$reply = array('status' => "NOP Asal $nop_pbb_asal tidak ditemukan!");
		echo json_encode($reply);
	}
}
};


function cancel($data) {
//require_once("../../dist/encrypt.php");	
global $multirule, $datakey, $username, $session, $host_post_sspd_aphb;

 
$allow = encrypt("yes",$datakey);
	 
$username =  encrypt($_SESSION['user-session'],$datakey);
$curl = new Curl($host_post_sspd_aphb);
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
global $multirule, $datakey, $username, $session, $host_post_sspd_aphb;

if (in_array("1",$multirule) || in_array("2",$multirule))
	{
	$allow = encrypt("yes",$datakey);
	}
	else
	{
	$allow = encrypt("no",$datakey);
	}
	 
$username =  encrypt($_SESSION['user-session'],$datakey);
$curl = new Curl($host_post_sspd_aphb);
$curl-> send('post', array(
			'code'=> CheckString($data['code']),
			'token'=> $username,
			'access'=> encrypt($session,$datakey),
			'reply'=> $allow,			
			'action'=> encrypt("posting",$datakey)
			));
echo $curl->getResponse();
};

 


