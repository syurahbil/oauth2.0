<?php
ob_start();
session_start();
date_default_timezone_set("Asia/Jakarta");
include('vendor/autoload.php');
use prodigyview\network\Curl;
use prodigyview\network\Request;
use prodigyview\network\Response;

function redirect($url){
    if (headers_sent()){
      die('<script type="text/javascript">window.location.href="' . $url . '";</script>');
  }else{
      header('Location: ' . $url);
      die();
  }    
}

function ReplaceString($data)
{
	$data = strtolower($data);
	$string = str_replace("'","\'",$data);
	$string = str_replace("\"","",$string);
	$string = str_replace("select","",$string);
	$string = str_replace("table","",$string);
	$string = str_replace("drop table","",$string);
	$string = str_replace("union","",$string);
	$string = str_replace("concat","",$string);
	$string = str_replace(";","",$string);
	$string = str_replace("(","",$string);
	$string = str_replace(")","",$string);
    return $string;
}

function get_browser_name($user_agent)
{
    if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return 'Opera';
    elseif (strpos($user_agent, 'Edge')) return 'Edge';
    elseif (strpos($user_agent, 'Chrome')) return 'Chrome';
    elseif (strpos($user_agent, 'Safari')) return 'Safari';
    elseif (strpos($user_agent, 'Firefox')) return 'Firefox';
    elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) return 'Internet Explorer';
    
    return 'Other';
}


if (isset($_GET['error']))
{

    $errorMsg = base64_decode($_GET['error']);
    $error='<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '.$errorMsg.'</div>';   
    echo $error;
}

if (get_browser_name($_SERVER['HTTP_USER_AGENT']) != 'Chrome' && get_browser_name($_SERVER['HTTP_USER_AGENT']) != 'Safari')
{
	 
	$error='<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; You need Chrome Browser for optimal feature. <a href="https://www.google.com/chrome/browser/desktop/"><img alt="Chrome" id="logo" src="../img/new-chrome-logo.png" style="-webkit-mask-image: -webkit-gradient(radial, 17 17, 123, 17 17, 138, from(rgb(0, 0, 0)), color-stop(0.5, rgba(0, 0, 0, 0.2)), to(rgb(0, 0, 0)));" witdh="110"></a> </div>';
	echo $error;
}

$error="";
$firstname = "Default";
$lastname = "";
$email = "";
$phone ="";
if (isset($_SESSION['token']) && isset($_SESSION['userid']))
{ // session
	$token = $_SESSION['token'];
	$userid = $_SESSION['userid'];

	
	//$host_validate_token = "202.157.189.177:8686/validateToken";
	$host_validate_token = "localhost:8686/validateToken";
			$curl = new Curl($host_validate_token);
			$curl-> sendToken('get', array(
			'userid'=> $userid,
			'token'=> $token
			),$token);
    $result = json_decode($curl->getResponse());
	
	if (isset($result->error))
	{
		$message = $result->error_description;
		$error = base64_encode("$message");
		redirect("./?error=$error"); 
	}
	else if (isset($result->status))
	{
		$status = $result->status;
		if ($status == "00")
		{
			//$host_get_token = "202.157.189.177:8686/getUser";
			$host_get_token = "localhost:8686/getUser";
			$curl = new Curl($host_get_token);
			$curl-> sendToken('post', array(
			'userid'=> $userid,
			'token'=> $token
			),$token);

			$reply = json_decode($curl->getResponse());
			
			if (isset($reply->status))
			{
			$firstname =$reply->data->firstname;
			$lastname =$reply->data->lastname;
			$email =$reply->data->email;
			$phone =$reply->data->phone;
			}
			else 
			{
				$firstname = "Default";
				$lastname = "Error!";
				$email = "";
				$phone ="";
			}
		}
		else
		{
			$error = base64_encode("Error status : $status");
		    redirect("./?error=$error"); 
		}
	}
	
}
else
{

		$error = base64_encode("Restricted Page. Please Login to authorize this page.");
		redirect("./?error=$error"); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>HOME PAGE</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/img-01.png" alt="IMG">
				</div>
				<form class="login100-form validate-form" role="form" name="form_login">
					<span class="login100-form-title">
                        Welcome Agent : 
                        <span style="color:red">
                            <?php echo "$firstname $lastname"; ?>
                        </span>
					</span>
					<?php echo $error;?>
					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="username" placeholder="username" value="<?php //echo $userid;?>">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="text" name="email" placeholder="Email" value="<?php //echo $email;?>">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="text" placeholder="Phone Number" name="phone" value="<?php //echo $phone;?>" >
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						
					</div>

					<div class="text-center p-t-12">
                        <!-- 
						<span class="txt1">
							Forgot
						</span>
                        -->
						<a class="txt2" href="logout.php">
						    <b> Logout </b>
						</a>
					</div>

					<div class="text-center p-t-136">
						<a class="txt2" href="#">
							Create your Account
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>

<?php ob_end_flush();
?>
