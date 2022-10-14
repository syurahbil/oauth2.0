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

function jwt_request($token) {

       header('Content-Type: application/json'); // Specify the type of data
       //$ch = curl_init('202.157.189.177:8686/validateToken'); // Initialise cURL
       //$ch = curl_init('localhost:8686/validateToken'); // Initialise cURL
       $ch = curl_init('103.116.168.102:8686/validateToken'); // Initialise cURL
       $authorization = "Authorization: Bearer ".$token; // Prepare the authorisation token
       curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization )); // Inject the token into the header
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // This will follow any redirects
       $result = curl_exec($ch); // Execute the cURL statement
       curl_close($ch); // Close the cURL connection
       return json_decode($result); // Return the received data

    }


 $validateData= jwt_request("00290b4932d60d46717c95c025ba9268208d44d2");
 $status = $validateData->status;
 $message = $validateData->message;
 echo "Pesan : $status - $message";
 

?>
