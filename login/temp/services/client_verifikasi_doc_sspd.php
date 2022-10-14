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


	//Route The Request
	if ($method == 'post') {
		 
			if (in_array("1",$multirule))
			{
			post($data);
			}
			else
			{
				$reply = array('status' => 'Anda tidak mempunyai hak untuk mengupdate data');
				echo json_encode($reply);
			}
		 
	} else if ($method == 'get') {
		
			if (in_array("1",$multirule))
			{
			get($data);
			}
			else
			{
				$reply = array('status' => 'Anda tidak mempunyai hak untuk mengupdate data');
				echo json_encode($reply);
			}
	}
	else {
		
		$reply = array('status' => 'Metode kirim data tidak dapat diterima.');
		echo json_encode($reply);
		
	}

} // check session
else
{
	$reply = array('status' => 'Status Autentikasi Anda sudah kadaluarsa. Mohon Login kembali!');
	echo json_encode($reply);
}



 

function post($data) {
global $multirule, $datakey, $username, $session;
//require("../../dist/panel.php");
 
	$response = array('status' => 'Data tidak ditemukan');

//$response = array('status' => 'Data tidak ditemukan');
echo json_encode($response);
exit();
};



function get($data) {
global $multirule, $datakey, $username, $session;
require("../../dist/panel.php");

$no_sspd = CheckString($data['s']) ?? "";
$unik = CheckString($data['c']) ?? "";
$kode = CheckString($data['r']) ?? "";
$ref_no = CheckString($data['ref']) ?? "";
$status = CheckString($data['id']) ?? "";
$keterangan = addslashes(CheckString($data['ket'])) ?? "";
if ($status == "0")
{
$status_doc = "Dokumen tidak ada";
$flag = 0;
}
else
{
$status_doc = "Dokumen ada";
$flag=1;
}
$dbcon = new DB();
$dbcon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$query1 = "SELECT * FROM verifikasi_sspd_skpd WHERE code=? AND kode=?";
$cek = $dbcon->query($query1,"$unik","$kode");
$cek->setFetchMode(PDO::FETCH_ASSOC);
$result_cek=$cek->fetchAll();
$rows = $cek->rowCount();
if ($rows > 0)
{
			$cek->closeCursor();
			$query1 = "INSERT INTO verifikasi_sspd_skpd_copy (no_reg,jenis,kode,ref_no,keterangan,register_date,register_by,modified_by,status,code,flag) 
												VALUES (?,'SSPD',?,?,?,NOW(),?,?,?,?,?)";
			$cek = $dbcon->query($query1,"$no_sspd",$kode,"$ref_no", "$keterangan", "$username","update dari SSPD","$status","$unik","$flag");
			 
			$cek->closeCursor();
			$query1 = "UPDATE verifikasi_sspd_skpd SET no_reg=?, ref_no=?, keterangan=?, modified_date=NOW(), modified_by=?, status_dokumen=?, status=?, flag=? WHERE code=? AND kode=?";
			$cek = $dbcon->query($query1,"$no_sspd","$ref_no","$keterangan","$username", "$status_doc", "$status","$flag","$unik","$kode");
			if ($cek)
			{
			 
			$allfield = "UPDATE verifikasi_sspd_skpd SET ref_no=?, keterangan=?, register_date=NOW(), register_by=?,status=?, flag=0 WHERE code=? AND kode=? # $ref_no,$keterangan,$username,$status,$unik,$no_sspd,$kode";
			$allfield = str_replace("'","\'",$allfield);
			
			$query_history = "INSERT INTO history_activity (event, page, username, register_date, remark)
					   VALUES('$allfield','sspd-doc-update','$username',NOW(),'Update Status Verifikasi Dokumen SSPD kode $kode Unique code=$unik')";
			$cek = $dbcon->query($query_history);
			
			$response = array('status' => 'Dokumen Sukses di Update');
			
			}
			else
			{
				$response = array('status' => 'Dokumen Gagal di Update');
			}
}
else
{
			$cek->closeCursor();
			$query1 = "INSERT INTO verifikasi_sspd_skpd (no_reg,jenis,kode,ref_no,keterangan,register_date,register_by,status,code,status_dokumen,flag) 
												VALUES (?,'SSPD',?,?,?,NOW(),?,?,?,?,'1')";
			$cek = $dbcon->query($query1,"$no_sspd",$kode,"$ref_no", "$keterangan","$username","$status","$unik","$status_doc");
			if ($cek)
			{
			$cek->closeCursor();
			$query1 = "INSERT INTO verifikasi_sspd_skpd_copy (no_reg,jenis,kode,ref_no,keterangan,register_date,register_by,status,code,status_dokumen,flag) 
												VALUES (?,'SSPD',?,?,?,NOW(),?,?,?,?,'1')";
			$cek = $dbcon->query($query1,"$no_sspd",$kode,"$ref_no", "$keterangan","$username","$status","$unik","$status_doc");
			 
			$allfield = "INSERT INTO verifikasi_sspd_skpd (no_reg,jenis,kode,ref_no,keterangan,register_date,register_by,status,code,status_dokumen,flag) # $ref_no,$keterangan,$username,$status,$no_sspd,$kode,$unik,$status_doc";
			$allfield = str_replace("'","\'",$allfield);
			
			$query_history = "INSERT INTO history_activity (event, page, username, register_date, remark)
					   VALUES('$allfield','sspd-doc-update','$username',NOW(),'Update Status Verifikasi Dokumen SSPD kode $kode code=$unik')";
			$cek = $dbcon->query($query_history);
			
			$response = array('status' => 'Dokumen Sukses di Update');
			
			}
			else
			{
				$response = array('status' => 'Dokumen Gagal di Update');
			}
}
//$response = array('status' => 'Data tidak ditemukan');
echo json_encode($response);
exit();
};

 

 


