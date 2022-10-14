<?PHP
include('vendor/autoload.php');
include('vendor/encrypt.php');
use prodigyview\network\Curl;
use prodigyview\network\Request;
use prodigyview\network\Response;
include('Route.php');


function getAuthorizationHeader(){
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }
/**
 * get access token from header JWT-TOKEN = /Bearer\s((.*)\.(.*)\.(.*))/
 * */
function getBearerToken() {
    $headers = getAuthorizationHeader();
    // HEADER: Get the access token from the header
    if (!empty($headers)) {
        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
            return $matches[1];
        }
    }
    return null;
}

	
Route::add('/getTokenService',function(){
  //$token = 'c11661251f18559fc654460ecd0eb5b33f5d97eb'; 
  $request = new Request();
  $method = strtolower($request->getRequestMethod());
  $data = $request->getRequestData('array');
  
  $host_get_token = "10.10.192.30:8888/generateToken";
  if (isset($data['username']))
  {
	$client_id = CheckString($data['username']) ?? "";  
  }
  else
  {
	$inputJSON = file_get_contents('php://input');
	$input = json_decode($inputJSON);
	if (isset($input->username))
	{ 
		$client_id = CheckString($input->username) ?? "";
	}
	else
	{
		$client_id = "";
	}
	
  }
  if (isset($data['password']))
  {
	$client_secret = CheckString($data['password']) ?? "";  
  }
  else
  {
	$inputJSON = file_get_contents('php://input');
	$input = json_decode($inputJSON);
	if (isset($input->password))
	{ 
		$client_secret = CheckString($input->password) ?? "";
	}
	else
	{
		$client_secret = "";
	}
  }
  // $client_id = CheckString($data['username']) ?? "";
  // $client_secret = CheckString($data['password']) ?? "";
 // echo "==#$client_id==";
  $curl = new Curl($host_get_token);
  $curl-> send('post', array(
			'client_id'=> $client_id, 
			'client_secret'=> $client_secret,
			'grant_type'=> "client_credentials"
			));
// $data = json_decode($curl->getResponse());
// echo $data[0]->status;
$reply = json_decode($curl->getResponse());
if (isset($reply->access_token))
{
$token = $reply->access_token;
$result = array('status' => '00', 'message' => 'Request Berhasil', 'token' => $token);
}
else if (isset($reply->error))
{
	
$error = $reply->error;
if ($error == "invalid_client")
{
	$error = "Username atau password salah";
}
$result = array('status' => '11', 'message' => $error);
}
else
{
$result = array('status' => '90', 'message' => 'Parameter input salah');	
}
$response = array('Result'=>$result);
echo Response::createResponse(200, json_encode($response));
exit();	

},'post');

// Another base route example
Route::add('/index.php',function(){
  $result = array('status' => '90', 'message' => 'Parameter input salah');
  $response = array('Result'=>$result);
  echo Response::createResponse(200, json_encode($response));
  exit();	
});


Route::add('/testGetToken',function(){
  $token = getBearerToken();
  $result = array('status' => '90', 'message' => 'Parameter input salah', 'token' =>  $token);
  $response = array('Result'=>$result);
  echo Response::createResponse(200, json_encode($response));
  exit();	
});

Route::add('/testSendToken',function(){
  $request = new Request();
  $method = strtolower($request->getRequestMethod());
  $data = $request->getRequestData('array');
  $host_get_token = "127.0.0.1:8888/test1";
  $client_id = CheckString($data['username']) ?? "";
  $client_secret = CheckString($data['password']) ?? "";
  $curl = new Curl($host_get_token);
  $curl-> send('post', array(
			'client_id'=> $client_id, 
			'client_secret'=> $client_secret,
			'grant_type'=> "client_credentials",
			));
// $data = json_decode($curl->getResponse());
// echo $data[0]->status;
echo $curl->getResponse();
},'post');


// Add a 404 not found route
Route::pathNotFound(function($path){
  $result = array('status' => '90', 'message' => 'Parameter input salah. Path is not found. Error 404');
  $response = array('Result'=>$result);
  echo Response::createResponse(200, json_encode($response));
  exit();	
});

// Add a 405 method not allowed route
Route::methodNotAllowed(function($path, $method){
  $result = array('status' => '90', 'message' => 'Parameter input salah. Method is wrong. Method '.$method.' is not allowed. Error 405 ');
  $response = array('Result'=>$result);
  echo Response::createResponse(200, json_encode($response));
  exit();
});

// Run the Router with the given Basepath
// If your script lives in the web root folder use a / or leave it empty
Route::run('/');

// If your script lives in a subfolder you can use the following example
// Do not forget to edit the basepath in .htaccess if you are on apache
// Route::run('/api/v1');

// Enable case sensitive mode and trailing slashes by setting both to true
// Route::run('/', true, true);

?>
