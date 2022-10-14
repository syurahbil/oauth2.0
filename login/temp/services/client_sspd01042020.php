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
		if (in_array("1",$multirule) || in_array("2",$multirule))
		{
		get($data);
		}
		else
		{
			$reply = array('status' => 'Anda tidak mempunyai hak untuk mengakses data', 'error' => 'yes');
			echo json_encode($reply);
		}
	}
	else
	{
		if ((in_array("1",$multirule) || in_array("2",$multirule)) && in_array("10",$multirule))
		{
		cancel($data);
		
		}
		else
		{
			$reply = array('status' => 'Anda tidak mempunyai hak untuk membatalkan data sspd', 'error' => 'yes');
			echo json_encode($reply);
		}
	}
} else if ($method == 'post') {
	if (in_array("1",$multirule) || in_array("2",$multirule))
	{
	$action = decrypt($data['action'],$datakey);
	if ($action == "edit")
		{
			if (in_array("9",$multirule) )
			{
				post($data);
			}
			else
			{
				$reply = array('status' => 'Anda tidak mempunyai hak untuk edit/update data', 'error' => 'yes');
				echo json_encode($reply);
			}
		}
		else
		{
			post($data);
		}
	}
	else
	{
	$reply = array('status' => 'Anda tidak mempunyai hak untuk register data baru', 'error' => 'yes');
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
global $multirule, $datakey, $username, $user_rule, $engineer_id, $session, $host_get_sspd;

if (in_array("1",$multirule) || in_array("2",$multirule))
	{
	$allow = encrypt("yes",$datakey);
	}
	else
	{
	$allow = encrypt("no",$datakey);
	}
	if ($user_rule == "2")
	{
		$eng_id = $engineer_id;
	}
	else
	{
		$eng_id = "0";
	}
$no_sspd = CheckString($data['no_sspd']) ?? "";
$kode_billing = CheckString($data['kode_billing']) ?? "";
$ppat_id = CheckString($data['ppat_id']) ?? "";
$nama_wp = CheckString($data['nama_wp']) ?? "";
$no_identitas = CheckString($data['no_identitas']) ?? "";
$npwp = CheckString($data['npwp']) ?? "";
$kelurahan = CheckString($data['kelurahan']) ?? "";
$kecamatan = CheckString($data['kecamatan']) ?? "";
$nama_penjual = CheckString($data['nama_penjual']) ?? "";
$nop_pbb_asal = CheckString($data['nop_pbb_asal']) ?? "";
$nama_wp_asal = CheckString($data['nama_wp_asal']) ?? "";
$kelurahan_op = CheckString($data['kelurahan_op']) ?? "";
$kecamatan_op = CheckString($data['kecamatan_op']) ?? "";
$jenis_perolehan = CheckString($data['jenis_perolehan']) ?? "";
$status_sspd = CheckString($data['status_sspd']) ?? "";
$ptsl_status = CheckString($data['ptsl_status']) ?? "";
$tgl_sspd_from = $data['tgl_sspd_from'] ?? "";
$tgl_sspd_to = $data['tgl_sspd_to'] ?? "";
$limit = $data['limit'] ?? "300";
$curl = new Curl($host_get_sspd);
$curl-> send('get', array(
			'no_sspd'=> $no_sspd,
			'kode_billing'=> $kode_billing,
			'ppat_id'=> $ppat_id,
			'nama_wp'=> $nama_wp, 
			'npwp'=> $npwp,
			'no_identitas'=> $no_identitas,
			'kelurahan'=> $kelurahan,
			'kecamatan'=> $kecamatan,
			'nama_penjual'=> $nama_penjual,
			'nop_pbb_asal'=> $nop_pbb_asal,
			'nama_wp_asal'=> $nama_wp_asal,
			'kelurahan_op'=> $kelurahan_op,
			'kecamatan_op'=> $kecamatan_op,
			'jenis_perolehan'=> $jenis_perolehan,
			'status_sspd'=> $status_sspd,
			'ptsl_status'=> $ptsl_status,
			'tgl_sspd_from'=> $tgl_sspd_from,
			'tgl_sspd_to'=> $tgl_sspd_to,
			'action'=>  encrypt("get",$datakey),
			'reply'=> $allow,
			'eng_id'=> $eng_id,
			'resolver'=> $user_rule,
			'token'=> encrypt($username,$datakey),
			'access'=> encrypt($session,$datakey),
			'limit'=>$limit
			));
echo $curl->getResponse();
};

function post($data) {
global $multirule, $datakey, $username, $user_rule, $session, $host_post_sspd, $host_get_pbb;
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
$curl = new Curl($host_post_sspd);
$curl-> send('post', array(
			'no_sspd'=> CheckString($data['no_sspd']),
			'kode_billing'=> CheckString($data['kode_billing']),
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
			'jumlah_setoran'=> str_replace(",","",CheckString($data['jumlah_setoran'])),
			'keterangan'=> CheckString($data['keterangan']),
			'stpd_skpd_kb'=> CheckString($data['stpd_skpd_kb']),
			'tgl_stpd_skpd_kb'=> CheckString($data['tgl_stpd_skpd_kb']),
			'jlh_stpd_skpd_kb'=> CheckString($data['jlh_stpd_skpd_kb']),
			'keterangan_lainnya'=> CheckString($data['keterangan_lainnya']),
			'token'=> encrypt($username,$datakey),
			'access'=> encrypt($session,$datakey),
			'resolver'=> $user_rule,
			'reply'=> $allow,
			'action'=> CheckString($data['action']),
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
global $multirule, $datakey, $username, $session, $host_get_sspd;

if ((in_array("1",$multirule) || in_array("2",$multirule)) && in_array("10",$multirule) )
	{
	$allow = encrypt("yes",$datakey);
	}
	else
	{
	$allow = encrypt("no",$datakey);
	}
$username =  encrypt($_SESSION['user-session'],$datakey);
$curl = new Curl($host_get_sspd);
$curl-> send('get', array(
			'no_sspd'=> encrypt(CheckString($data['no_sspd']),$datakey),
			'keterangan'=> encrypt(CheckString($data['comment']),$datakey),
			'token'=> $username,
			'access'=> encrypt($session,$datakey),
			'reply'=> $allow,			
			'action'=> encrypt("cancel",$datakey)
			));
echo $curl->getResponse();
};

 


