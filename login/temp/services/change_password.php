<?php
session_start();
include('vendor/autoload.php');
include('vendor/host.php');
use prodigyview\network\Curl;
use prodigyview\network\Request;
	
$request = new Request();
$reply = array();
//Get The Request Method(GET, POST, PUT, DELETE)
$method = strtolower($request->getRequestMethod());
//RETRIEVE Data From The Request
$data = $request->getRequestData('array');

if (isset($_SESSION['session-login']) && isset($_SESSION['user-session'])) {
include("../../dist/encrypt.php");	

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
		
		post($data);
			
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
global $username;
include("../../dist/panel.php");
 
$old_password = CheckString($data['old_password']);
$new_password = CheckString($data['new_password']);
$confirm_password = CheckString($data['confirm_password']);
$dbcon = new DB();
$dbcon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
if (($old_password != "" && $new_password != "") && ($new_password == $confirm_password))
{

$query1 = "SELECT * FROM users WHERE username=? AND password=md5(?)";
$cek = $dbcon->query($query1,"$username","$old_password");
$cek->setFetchMode(PDO::FETCH_ASSOC);
$result_cek=$cek->fetchAll();			  
$rows = $cek->rowCount(); 
	 
	if ($rows > 0) {
		$cek->closeCursor();
		$query1 = "UPDATE users SET password=md5(?) WHERE username=? AND password=md5(?)";
		$cek = $dbcon->query($query1,"$new_password","$username","$old_password");	

		$query1 = "INSERT INTO internal_log (username,event,register_date,session,process_id) VALUES('$username','Change Password Username : $username',now(),'$session','login')";
		$cek = $dbcon->query($query1);	
		$reply = array('status' => 'Password successfully updated');
		echo json_encode($reply);
	}
	else
	{
		$reply = array('status' => 'Your Old Password is wrong');
		echo json_encode($reply);
	}
}
else
{
	$reply = array('status' => 'Old Password is empty or New Password and Confirm Password is not same');
	echo json_encode($reply);
}
};

 