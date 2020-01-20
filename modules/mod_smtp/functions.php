<?php
function smtp_get_instance($debug = false)
{
	$settings 		= (object)sb_get_parameter('smtp_settings', array());
	if( $debug )
		print_r($settings);

       /* print_r($settings);*/
 
	sb_include_lib('PHPMailer/PHPMailerAutoload.php');
	$mailer 		= new PHPMailer($debug);
	$mailer->SMTPOptions = array(
		'ssl' => array(
			'verify_peer' 		=> false,
			'verify_peer_name'	=> false,
			'allow_self_signed'	=> true
		)
	);
	$use_smtp 		= isset($settings->use) && (int)$settings->use ? true : false;
	$smtp_server 	= $settings->server;
	$smtp_port		= $settings->port;
	$smtp_username 	= $settings->username;
	$smtp_password	= $settings->password;

/*	echo $smtp_server
        echo $smtp_port
        echo $smtp_username
        echo $smtp_password*/

	$secure			= $settings->security;
	$mailer->CharSet = 'utf-8';
	if( $use_smtp )
	{
		$mailer->isSMTP();
		$mailer->SMTPDebug = $debug;
	}
	if( !empty($smtp_server) )
	{
		$mailer->Host		= $smtp_server;// . ':' . $smtp_port;
		$mailer->Port		= $smtp_port;
	}
	if( !empty($smtp_username) )
	{
		$mailer->SMTPAuth 	= true;
		$mailer->Username	= $smtp_username;
		$mailer->Password	= $smtp_password;
		$mailer->AuthType	= $settings->authentication ? $settings->authentication : 'LOGIN';
	}
	if( !empty($secure) )
	{
		$mailer->SMTPSecure = $secure;//'ssl';//tls';
	}
	//else
	{
		//var_dump(function_exists('mail'));
		//$mailer->isSendmail();
		//$mailer->isMail();
		//$mailer->isSMTP();
	}
	return $mailer;
}
