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
		 
	}  else {
		
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
require("../../dist/panel.php");

$no_sspd = CheckString($data['no_sspd_status']) ?? "";
$code = CheckString($data['code_status']) ?? "";
$kode_billing = CheckString($data['kode_billing_status']) ?? "";
$status_verifikasi = CheckString($data['status_verifikasi']) ?? "";
$status_doc = CheckString($data['status_dokumen']) ?? "";
$keterangan = addslashes(CheckString($data['keterangan_verifikasi'])) ?? "";

$dbcon = new DB();
$dbcon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$query1 = "SELECT * FROM sspd WHERE no_sspd=?";
$cek = $dbcon->query($query1,"$no_sspd");
$cek->setFetchMode(PDO::FETCH_ASSOC);
$result_cek=$cek->fetchAll();
$rows = $cek->rowCount(); 
if ($rows > 0)
{
			$cek->closeCursor();
			$query1 = "UPDATE sspd SET status=?, status_doc=?, modified_date=NOW(), modified_by=? WHERE no_sspd=?";
			$cek = $dbcon->query($query1,"$status_verifikasi","$status_doc","$username", "$no_sspd");
			if ($cek)
			{
			$cek->closeCursor();
			$query1 = "UPDATE tagihan SET status_doc=? WHERE kode_billing=?";
			$cek = $dbcon->query($query1,"$status_doc","$kode_billing");
			$cek->closeCursor();
			$query_doc = "INSERT INTO history_status_sspd (no_sspd,status,keterangan,register_date,register_by,flag) VALUES(?,?,'Update Status SSPD = $status_verifikasi dan Status Dokumen= $status_doc dengan keterangan : $keterangan',NOW(),'$username','1')";
			$cek = $dbcon->query($query_doc,"$no_sspd","$status_verifikasi");
			
			$allfield = "UPDATE sspd SET status=?,status_doc=?,  modified_date=NOW(), modified_by=? WHERE no_sspd=? # $status_verifikasi,$status_doc,$username,$no_sspd";
			$allfield = str_replace("'","\'",$allfield);
			
			$query_history = "INSERT INTO history_activity (event, page, username, register_date, remark)
					   VALUES('$allfield','sspd-baru','$username',NOW(),'Update Status Verifikasi SSPD')";
			$cek = $dbcon->query($query_history);
			$response = array('status' => 'Data Sukses di Update');
			
			$cek->closeCursor();
			$query1 = "SELECT a.data_id as data_id,a.filename as filename, a.ref_no as ref_no, a.status, a.kind_of_file as kind_of_file,a.size as size, a.url as url,a.document_id as document_id,a.page as page,DATE_FORMAT(a.upload_date,'%d-%b-%Y %H:%i') AS upload_date,a.uploaded_by as uploaded_by, b.name as name FROM document_upload a LEFT JOIN users b ON a.uploaded_by=b.username WHERE a.document_id=? AND a.flag=1";
			$cek = $dbcon->query($query1,"$code");
			$cek->setFetchMode(PDO::FETCH_ASSOC);
			$result_cek=$cek->fetchAll();			  
			$rows = $cek->rowCount(); 
			if ($rows > 0) {
				$i=0;
				$status_file = "Belum Verifikasi";
				foreach($result_cek as $row) 
				{
					$data_id = $row['data_id']; 
					$kode_id = "file_$data_id";
					if (isset($data[$kode_id]))
					{
						$status_file = CheckString($data[$kode_id]);
						$query1 = "UPDATE document_upload SET status=? WHERE data_id=?";
						$cek2 = $dbcon->query($query1,"$status_file","$data_id");
					}
					
				}
			}
			
			}
			else
			{
				$response = array('status' => 'Data Gagal di Update');
			}
}
else
{
	$response = array('status' => 'Data tidak ditemukan');
}
//$response = array('status' => 'Data tidak ditemukan');
echo json_encode($response);
exit();
};

 

 


