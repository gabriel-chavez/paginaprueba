<?php
require_once dirname(__FILE__) . SB_DS . 'functions.php';
class LT_ModSmtp
{
	protected $settings;
	
	public function __construct()
	{
		$this->settings = (object)sb_get_parameter('smtp_settings', array());
		$this->AddActions();
		if( SB_Request::getTask() == 'test_smtp' )
		{
			define('SMTP_DEBUG', true);
			$email = SB_Request::getString('email', 'marce_nickya@yahoo.es');
			$message = 'Some test message';
			var_dump("Sending test email to: $email");
			$res = lt_mail($email, 'Test subject', $message, array('From:talentohumano@univida.bo'));
			var_dump($res);
			die();
		}
	}
	protected function AddActions()
	{
		SB_Module::add_action('settings_tabs', array($this, 'action_settings_tabs'));
		SB_Module::add_action('settings_tabs_content', array($this, 'action_settings_tabs_content'));
		SB_Module::add_action('save_settings', array($this, 'action_save_settings'));
		if( isset($this->settings->use) && (int)$this->settings->use == 1 )
		{
			SB_Module::add_action('lt_mail_function', array($this, 'lt_mail_function'));
		}
	}
	public function lt_mail_function($func)
	{
		$func = $this->settings->use == '1' ? array($this, 'send_email') : 'mail';
		return $func;
	}
	public function action_settings_tabs()
	{
		?>
		<li>
			<a href="#smtp" data-toggle="tab"><?php _e('SMTP Settings', 'smtp'); ?></a>
		</li>
		<?php 
	}
	public function action_settings_tabs_content($lt_settings)
	{
		$settings = (object)sb_get_parameter('smtp_settings', array());
		?>
		<div id="smtp" role="tabpanel" class="tab-pane">
			<div class="control-group">
				<label><?php _e('Email Sender:', 'smtp'); ?></label>
				<input type="email" name="smtp_settings[email_sender]" value="<?php print @$settings->email_sender; ?>" class="form-control" />
			</div>
			<h4><?php _e('SMTP Settings', 'smtp'); ?></h4>
			<div class="control-group">
				<label>
					<?php print SBText::_('Use SMTP Server:', 'smtp'); ?>
					<input type="checkbox" name="smtp_settings[use]" value="1" <?php print (int)@$settings->use ? 'checked' : ''; ?> />
				</label>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="control-group">
						<label><?php _e('SMTP Server:', 'smtp'); ?></label>
						<input type="text" name="smtp_settings[server]" value="<?php print @$settings->server; ?>" class="form-control" />
					</div>
				</div>
				<div class="col-md-4">
					<div class="control-group">
						<label><?php print SBText::_('SMTP Server Port:', 'smtp'); ?></label>
						<input type="number" name="smtp_settings[port]" value="<?php print @$settings->port; ?>" class="form-control" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="control-group">
						<label><?php _e('SMTP Username:', 'smtp'); ?></label>
						<input type="text" name="smtp_settings[username]" value="<?php print @$settings->username; ?>" class="form-control" />
					</div>
				</div>
				<div class="col-md-4">
					<div class="control-group">
						<label><?php _e('SMTP Password:', 'smtp'); ?></label>
						<input type="password" name="smtp_settings[password]" value="<?php print @$settings->password; ?>" class="form-control" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="control-group">
						<label>
							<?php _e('SMTP Autentication:', 'smtp'); ?>
						</label>
						<select name="smtp_settings[authentication]" class="form-control">
							<option value=""><?php _e('-- any --', 'smtp'); ?></option>
							<option value="LOGIN" <?php print @$settings->authentication == 'LOGIN' ? 'selected' : ''; ?>>LOGIN</option>
							<option value="PLAIN" <?php print @$settings->authentication == 'PLAIN' ? 'selected' : ''; ?>>PLAIN</option>
							<option value="NTLM" <?php print @$settings->authentication == 'NTLM' ? 'selected' : ''; ?>>NTLM</option>
							<option value="CRAM-MD5" <?php print @$settings->authentication == 'CRAM-MD5' ? 'selected' : ''; ?>>CRAM-MD5</option>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="control-group">
						<label><?php _e('SMTP Security:', 'smtp'); ?></label>
						<select name="smtp_settings[security]" class="form-control">
							<option value=""><?php _e('-- any --', 'smtp'); ?></option>
							<option value="ssl" <?php print @$settings->security == 'ssl' ? 'selected' : ''; ?>>SSL</option>
							<option value="tls" <?php print @$settings->security == 'tls' ? 'selected' : ''; ?>>TLS</option>
						</select>
					</div>
				</div>
			</div>
		</div><!-- end id="smtp" -->
		<?php 
	}
	public function action_save_settings()
	{
		$settings = (array)SB_Request::getVar('smtp_settings', array());
		sb_update_parameter('smtp_settings', $settings);
	}
	public function send_email($email, $subject, $message, $headers = null)
	{
		$mailer = smtp_get_instance(defined('SMTP_DEBUG') ? true : false);
		if( strstr($email, ',') )
		{
			foreach(explode(',', $email) as $_email)
			{
				$mailer->addAddress($_email);
			}
		}
		else
		{
			$mailer->addAddress($email);
		}
		
		$mailer->isHTML(true);
		//$mailer->From 		= $this->settings->email_sender;
		//$mailer->FromName	= 'Some Name';
		$headers = $headers ? explode("\r\n", $headers) : array(); 
		if( is_array($headers) && count($headers) )
		{
			for($i = 0; $i < count($headers); $i++)
			{
				list($name, $value) = explode(':', $headers[$i]);
				if( strtolower($name) == 'from' )
				{
					$parts = explode('<', $value);
					$mailer->From	= isset($parts[1]) ? rtrim($parts[1], '>') : $value;
					$mailer->FromName	= strstr($parts[0], '@') ? $email : trim($parts[0]);
					//var_dump($mailer->From);
					//var_dump($mailer->FromName);
				}
			}
		}
		$mailer->addReplyTo($this->settings->email_sender, $mailer->FromName);
		$mailer->Subject	= $subject;
		$mailer->Body 		= $message;
		
		//$mailer->AltBody	= strip_tags(str_replace("<br/>", "\n", $email));
		/*
		if( isset($data['attachment']) && file_exists($data['attachment']) )
			$mailer->addAttachment($data['attachment']);
		*/

		$opts = array(
	        'http' => array(
	            'user_agent' => 'PHPSoapClient'
	        )
	    );
	    $context = stream_context_create($opts);

	    $wsdlUrl = 'https://app-desarrollo.univida.bo/ServicioWebEnvioCorreo//Service1.svc?wsdl';
	    $soapClientOptions = array(
	        'stream_context' => $context,
	        'cache_wsdl' => WSDL_CACHE_NONE
	    );

        $cliente = new SoapClient($wsdlUrl, $soapClientOptions);

        if ($email == 'info@univida.bo')
        {
        	$to = "info@univida.bo";
        	$from = $email;
        	$usuario = "info@univida.bo";
        	$contrasenia = "info123$#";
        }
    	else
    	{
			$to = $email;
        	$from = "talentohumano@univida.bo";
        	$usuario = "talentohumano@univida.bo";
        	$contrasenia = "Personasunivida5";
    	}
    	$smtpCliente = "mail.univida.bo";

	    $param = array("to" => $to, "from" => $from,"subject" => $subject,"body" => $message,"smtpCliente" => $smtpCliente,"puerto" => 587,"usuario" => $usuario,"contrasenia" => $contrasenia);

		$resultado = $cliente->EnviarCorreo($param);


		//$res = $mailer->send();
		return $res;
	}
}
new LT_ModSmtp();