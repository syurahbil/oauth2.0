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
$error='';
if (isset($_REQUEST['submit'])) //here give the name of your button on which you would like    //to perform action.
{
// here check the submitted text box for null value by giving there name.
 $error ="";
 if ($_POST['captcha_images'] == $_SESSION['captcha']['code'])
 {
	 if($_POST['username']=="" || $_POST['password']=="")
	 {
		$error='<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Field must be filled</div>';
		 
	 }
	else
	{	
		
		require_once("dist/encrypt.php");

		$username = CheckString($_POST['username']);
		$password = CheckString($_POST['password']);
		
		$username_pattern = "/^[a-zA-Z0-9\.]{3,14}$/"; // username should contain only letters and numbers, and length should be between 3 and 15 characters
        if(preg_match($username_pattern, $username)){
			
		try{ // Check connection before executing the SQL query 
			  require_once("dist/panel.php");
		
		//$host_get_token = "202.157.189.177:8686/generateToken";
		$host_get_token = "localhost:8686/generateToken";
        $curl = new Curl($host_get_token);
		$curl-> send('post', array(
			'client_id'=> $username, 
			'client_secret'=> $password,
			'grant_type'=> "client_credentials"
			));

			$reply = json_decode($curl->getResponse());
      echo var_dump($reply);
			if (isset($reply->access_token))
			{
			$token = $reply->access_token;
			$_SESSION['token']=$token;
			$_SESSION['userid']=$username;
				$error="<div class='alert alert-success'> <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Access Granted! $token</div>";
				redirect('home.php');
			}
			else if (isset($reply->error))
			{
				$message = $reply->error_description;
				$error="<div class='alert alert-danger'> <span class='glyphicon glyphicon-info-sign'></span> &nbsp;$message</div>";
			}
		 
			}
			catch(Exception $e){
			   
			  error_log($e->getMessage(), 0);
			  http_response_code(500);
			  die('Somehow Error in database prosessing');
			} 
		}
		else
				{
					$error='<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Username is not allowed!</div>';
					
				}
	} // post
}
else
{
	$error='<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; CAPTCHA Code is wrong. </div>';
}

}   
$_SESSION = array();
include("simple-php-captcha.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V1</title>
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
				<form class="login100-form validate-form" role="form" action="<?php $_SERVER['PHP_SELF'];?>" method="post" name="form_login">
					<span class="login100-form-title">
						Member Login
					</span>
					<?php echo $error;?>
					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="username" placeholder="username">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" placeholder="Captcha" name="captcha_images">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					 <div class="form-group has-feedback">
                        <span class="glyphicon glyphicon-qrcode form-control-feedback"></span>
								   <?php
										$_SESSION['captcha'] = simple_php_captcha();
										echo '<img src="' . $_SESSION['captcha']['image_src'] . '" width="100"  alt="CAPTCHA code" align="left">'; ?>
						<p style="margin-top:6px;"><button type="submit" name="submit" class="btn btn-success pull-right" onclick="sanitize(document.getElementById('username').value))" >Login</button></p>
                    </div>
					<div class="container-login100-form-btn">
						
					</div>

					<div class="text-center p-t-12">
						<span class="txt1">
							Forgot
						</span>
						<a class="txt2" href="#">
							Username / Password?
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
