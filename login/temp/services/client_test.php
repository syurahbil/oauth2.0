<?php
 
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

  

	//Route The Request
	if ($method == 'get') {
		 
			
			get($data);
			
		 
		 
	}  else {
		
		$reply = array('status' => 'Metode kirim data tidak dapat diterima.', 'error' => 'yes');
		echo json_encode($reply);
		
	}

 


function get($data) {
//require_once("../../dist/encrypt.php");	
global $datakey, $host_get_pembayaran;
  
	$allow = encrypt("yes",$datakey);	
	
$username = 'ismail';
$session = 'TvW4T8w9HmJEOvj0ltJAqpp5UzzLIPdHiWvAOB4B';
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
$curl = new Curl($host_get_pembayaran);
echo $host_get_pembayaran;
$data = array();
$data = array(
			'no_ntpd'=> $no_ntpd,
			'no_ref'=> $no_ref,
			'no_ref_bank'=> $no_ref_bank,
			'kode_billing'=> $kode_billing,
			'nop_pbb'=> $nop_pbb,
			'nama_wp'=> $nama_wp,
			'kelurahan'=> $kelurahan,
			'kecamatan'=> $kecamatan,
			'status_bpn'=> $status_bpn,
			'tgl_bayar_from'=> $tgl_bayar_from,
			'tgl_bayar_to'=> $tgl_bayar_to,
			'action'=>  encrypt("get",$datakey),
			'reply'=> $allow,
			'token'=> encrypt($username,$datakey),
			'access'=> encrypt($session,$datakey),
			'limit'=>$limit
			);
var_dump($data);
$curl-> send('get', array(
			'no_ntpd'=> $no_ntpd,
			'no_ref'=> $no_ref,
			'no_ref_bank'=> $no_ref_bank,
			'kode_billing'=> $kode_billing,
			'nop_pbb'=> $nop_pbb,
			'nama_wp'=> $nama_wp,
			'kelurahan'=> $kelurahan,
			'kecamatan'=> $kecamatan,
			'status_bpn'=> $status_bpn,
			'tgl_bayar_from'=> $tgl_bayar_from,
			'tgl_bayar_to'=> $tgl_bayar_to,
			'action'=>  encrypt("get",$datakey),
			'reply'=> $allow,
			'token'=> encrypt($username,$datakey),
			'access'=> encrypt($session,$datakey),
			'limit'=>$limit
			));
echo $curl->getResponse();
 
};



