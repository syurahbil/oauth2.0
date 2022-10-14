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
		if (in_array("1",$multirule) && in_array("10",$multirule))
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
	if (in_array("1",$multirule))
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
global $multirule, $datakey, $username, $user_rule, $engineer_id, $session, $host_get_skpd_lb;

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
$no_skpd_lb = CheckString($data['no_skpd_lb']) ?? "";
$no_sspd = CheckString($data['no_sspd']) ?? "";
$kode_billing = CheckString($data['kode_billing']) ?? "";
$ppat_id = CheckString($data['ppat_id']) ?? "";
$nama_wp = CheckString($data['nama_wp']) ?? "";
$no_identitas = CheckString($data['no_identitas']) ?? "";
$npwp = CheckString($data['npwp']) ?? "";
$kelurahan = CheckString($data['kelurahan']) ?? "";
$kecamatan = CheckString($data['kecamatan']) ?? "";
$nop_pbb_asal = CheckString($data['nop_pbb_asal']) ?? "";
$nama_wp_asal = CheckString($data['nama_wp_asal']) ?? "";
$kelurahan_op = CheckString($data['kelurahan_op']) ?? "";
$kecamatan_op = CheckString($data['kecamatan_op']) ?? "";
$jenis_perolehan = CheckString($data['jenis_perolehan']) ?? "";
$status_skpd = CheckString($data['status_skpd']) ?? "";
$ptsl_status = CheckString($data['ptsl_status']) ?? "";
$tgl_skpd_from = $data['tgl_skpd_from'] ?? "";
$tgl_skpd_to = $data['tgl_skpd_to'] ?? "";
$limit = $data['limit'] ?? "300";
$curl = new Curl($host_get_skpd_lb);
$curl-> send('get', array(
			'no_skpd_lb'=> $no_skpd_lb,
			'no_sspd'=> $no_sspd,
			'kode_billing'=> $kode_billing,
			'ppat_id'=> $ppat_id,
			'nama_wp'=> $nama_wp, 
			'npwp'=> $npwp,
			'no_identitas'=> $no_identitas,
			'kelurahan'=> $kelurahan,
			'kecamatan'=> $kecamatan,
			'nop_pbb_asal'=> $nop_pbb_asal,
			'nama_wp_asal'=> $nama_wp_asal,
			'kelurahan_op'=> $kelurahan_op,
			'kecamatan_op'=> $kecamatan_op,
			'jenis_perolehan'=> $jenis_perolehan,
			'status_skpd'=> $status_skpd,
			'ptsl_status'=> $ptsl_status,
			'tgl_skpd_from'=> $tgl_skpd_from,
			'tgl_skpd_to'=> $tgl_skpd_to,
			'action'=>  encrypt("get",$datakey),
			'reply'=> $allow,
			'eng_id'=> $eng_id,
			'token'=> encrypt($username,$datakey),
			'access'=> encrypt($session,$datakey),
			'limit'=>$limit
			));
echo $curl->getResponse();
};

function post($data) {
global $multirule, $datakey, $username, $session, $host_post_skpd_lb;
if (isset($data['check_ptsl']))
{
	$check_ptsl = CheckString($data['check_ptsl']);
}
else
{
	$check_ptsl = "Tidak";
}
$pengurangan_ptsl = str_replace(",","",CheckString($data['pengurangan_ptsl']));
$persentase = CheckString($data['persentase']);
$kena_pajak = str_replace(",","",CheckString($data['NPOPKP']));
$setoran_seharusnya = $kena_pajak*($persentase/100);
if ($check_ptsl == "Ya")
{
	$setoran_seharusnya = $setoran_seharusnya*($pengurangan_ptsl/100);
}
$sudah_dibayar = str_replace(",","",CheckString($data['sudah_dibayar']));
if (!is_numeric($sudah_dibayar))
{ $sudah_bayar = 0; }
$lebih_bayar = -1*($setoran_seharusnya-$sudah_dibayar);
$denda = str_replace(",","",CheckString($data['denda']));
if (!is_numeric($denda))
{ $denda = 0; }
$jumlah_setoran = $lebih_bayar+$denda;
if (in_array("1",$multirule))
	{
	$allow = encrypt("yes",$datakey);
	}
	else
	{
	$allow = encrypt("no",$datakey);
	}
 
 

if (in_array("1",$multirule))
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
$curl = new Curl($host_post_skpd_lb);
$curl-> send('post', array(
			'no_skpd_lb'=> CheckString($data['no_skpd_lb']),
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
			'setoran_seharusnya'=>$setoran_seharusnya,
			'sudah_dibayar'=> str_replace(",","",CheckString($data['sudah_dibayar'])),
			'lebih_bayar'=> $lebih_bayar,
			'denda'=> str_replace(",","",CheckString($data['denda'])),
			'jumlah_setoran'=> $jumlah_setoran,
			'keterangan'=> CheckString($data['keterangan']),
			'no_sk'=> CheckString($data['no_sk']),
			'tgl_sk'=> CheckString($data['tgl_sk']),
			'pengurangan'=> str_replace(",","",CheckString($data['pengurangan'])),
			'setoran_berdasarkan'=> CheckString($data['setoran_berdasarkan']),
			'check_ptsl'=> $check_ptsl,
			'no_sk_bpn'=> CheckString($data['no_sk_bpn']),
			'tgl_sk_bpn'=> CheckString($data['tgl_sk_bpn']),
			'pengurangan_ptsl'=> str_replace(",","",CheckString($data['pengurangan_ptsl'])),
			'stpd_skpd_lb'=> CheckString($data['stpd_skpd_lb']),
			'tgl_stpd_skpd_lb'=> CheckString($data['tgl_stpd_skpd_lb']),
			'jlh_stpd_skpd_lb'=> CheckString($data['jlh_stpd_skpd_lb']),
			'keterangan_lainnya'=> CheckString($data['keterangan_lainnya']),
			'token'=> encrypt($username,$datakey),
			'access'=> encrypt($session,$datakey),
			'reply'=> $allow,
			'action'=> CheckString($data['action']),
			'code'=> CheckString($data['code'])
			));
echo $curl->getResponse();
 
};

function cancel($data) {
//require_once("../../dist/encrypt.php");	
global $multirule, $datakey, $username, $session, $host_get_skpd_lb;

if ((in_array("1",$multirule) || in_array("2",$multirule)) && in_array("10",$multirule) )
	{
	$allow = encrypt("yes",$datakey);
	}
	else
	{
	$allow = encrypt("no",$datakey);
	}
$username =  encrypt($_SESSION['user-session'],$datakey);
$curl = new Curl($host_get_skpd_lb);
$curl-> send('get', array(
			'no_skpd_lb'=> encrypt(CheckString($data['no_skpd_lb']),$datakey),
			'keterangan'=> encrypt(CheckString($data['comment']),$datakey),
			'token'=> $username,
			'access'=> encrypt($session,$datakey),
			'reply'=> $allow,			
			'action'=> encrypt("cancel",$datakey)
			));
echo $curl->getResponse();
};


