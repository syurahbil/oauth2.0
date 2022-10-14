<?php

/*
 * Simple example to implement OAuth 2.0 in PHP Slim framework Ver 3.9
 * I am using "bshaffer" library @ https://github.com/bshaffer/oauth2-server-php
 * Say HI at email: ch.rajshekar@gmail.com, Skype: ch.rajshekar
 */
date_default_timezone_set("Asia/Jakarta");
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/panel.php';
require __DIR__ . '/vendor/encrypt.php';
// configuration for Oauth2 DB
$config['displayErrorDetails'] = true;
$config['odb']['host'] = "localhost";
$config['odb']['user'] = "syurahbil";
$config['odb']['pass'] = "syurahbil123";
$config['odb']['dbname'] = "oauth2";

$app = new Slim\App(["settings" => $config]);

$container = $app->getContainer();

function generateRandomString($length = 8) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
	$day = date("ym");
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $day.$randomString;
}

function generateCode($length = 15) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
	for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


// Container to create a oauth2 database connection
$container['oauth'] = function($c){
    $db = $c['settings']['odb'];

    OAuth2\Autoloader::register();
    $storage = new OAuth2\Storage\Pdo(array('dsn' => "mysql:dbname=".$db['dbname'].";host=".$db['host'], 'username' => $db['user'], 'password' => $db['pass']));
    return $storage;
};

$app->get('/', function ($request, $response) {
    return 'Welcome to slim 3.9 framework implement OAuth 2.0';
});

$app->post('/test1',function(Request $request, Response $response){
	$client_id = $_POST['client_id'];
    echo var_dump($client_id);
});

$app->post('/generateToken',function(Request $request, Response $response){

    // @ generate a fresh token
    // @ Token is valid till 1 hr or 3600 seconds after which it expires
    // @ Token will not be auto refreshed
    // @ generation of a new token should be handled at application level by calling this api

    // @ add parameter : ,['access_lifetime'=>3600] if you want to extent token life time from default 3600 seconds
	$server = new OAuth2\Server($this->oauth);
    $server->addGrantType(new OAuth2\GrantType\ClientCredentials($this->oauth));
    $server->addGrantType(new OAuth2\GrantType\AuthorizationCode($this->oauth));

    // @ generate a Oauth 2.0 token in json with format below
    // @ {"access_token":"ac7aeb0ee432bf9b73f78985c66a1ad878593530","expires_in":3600,"token_type":"Bearer","scope":null}
    $server->handleTokenRequest(OAuth2\Request::createFromGlobals())->send();
	
});

$app->get('/validateToken',function(Request $request, Response $response){

    // @ Validate Oauth Token passed via http headers in "Authorization bearer"
    $validate = new Tokens($this->oauth);
    $validate->validateToken();

    // @ Pass a Message if Oauth 2.0 token is valid to complete test
    return json_encode(array('status' => '00', 'message' => 'You have a valid Oauth2.0 Token'));

});

$app->post('/getUser',function(Request $request, Response $response){
	try {
    // @ Validate Oauth Token passed via http headers in "Authorization bearer"
	$inputJSON = file_get_contents('php://input');
	$input = json_decode($inputJSON);
	$userid = $input->userid;
	$token = $input->token;
	$dbcon = new DB();
	$dbcon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$com_code = generateCode();
	$merchant = "Not Register";
	$user_id = "System";
	$query1 = "SELECT a.user_id, b.merchant FROM oauth_access_tokens a INNER JOIN oauth_users b ON a.user_id=b.username WHERE a.access_token=?";
	$cek = $dbcon->query($query1,"$token");
	$cek->setFetchMode(PDO::FETCH_ASSOC);
	$result_cek=$cek->fetchAll();			  
	$rows = $cek->rowCount(); 
	if ($rows > 0)
	{
		foreach($result_cek as $row) 
		{
		$merchant = trim($row['merchant']);	
		$user_id = trim($row['user_id']);	
		}
	}	
	$query1 = "INSERT INTO history_send_receive (com_type, com_code, no_ref, status, message, event, token, register_date, register_by, flag) 
				VALUES(?,?,?,?,?,?,?,NOW(),?,'1')";
	$cek = $dbcon->query($query1,"RECEIVE","$com_code", "0", "00","Request Data User $userid", "Request Data User $userid", "$token", "$merchant" );
	
    $validate = new Tokens($this->oauth);
    $validate->validateToken();
	
	$cek->closeCursor();	
	$query1 = "SELECT a.first_name, a.last_name, a.email, a.phone FROM user_profile a WHERE a.username=? AND a.flag=1 ";
	$cek = $dbcon->query($query1,"$userid");
	$cek->setFetchMode(PDO::FETCH_ASSOC);
	$result_cek=$cek->fetchAll();			  
	$rows = $cek->rowCount(); 
	if ($rows > 0) {
		$data = array();
		foreach($result_cek as $row) 
		{
		$firstname = trim($row['first_name']);
		$lastname = trim($row['last_name']);
		$email = trim($row['email']);
		$phone = trim($row['phone']);
		$data = array('firstname'=>$firstname, 
				'lastname'=>$lastname, 
				'email'=>$email, 
				'phone'=>$phone
				);
		}
		
		
		$cek->closeCursor();
		$query1 = "INSERT INTO history_send_receive (com_type, com_code, no_ref, status, message, event, token, register_date, register_by, flag) 
					VALUES(?,?,?,?,?,?,?,NOW(),?,'1')";
		$cek = $dbcon->query($query1,"SEND","$com_code","0", "00","Request Data Successful", "Request Data Successful - Username $userid", "$token", "$merchant" );
	
	    $result = array('status' => '00', 'message' => 'Request Data Successful', 'data'=>$data);
		return json_encode($result);

	}
	else
	{

		
			$cek->closeCursor();
			$query1 = "INSERT INTO history_send_receive (com_type, com_code, no_ref, status, message, event, token, register_date, register_by, flag) 
						VALUES(?,?,?,?,?,?,?,NOW(),?,'1')";
			$cek = $dbcon->query($query1,"SEND","$com_code","0", "14","User is not found", "User is not found - $userid", "$token", "$merchant" );
		
			$result = array('status' => '14', 'message' => 'User is not found.');
			return json_encode($result);
	
	
	}
	$dbcon = null;
    	} catch(Exception $e) {
        $eror =  $e->getMessage();
	$result = array('status' => '90', 'message' => $eror);
	return json_encode($result);

        }
});

$app->run();
