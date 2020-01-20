<?php
// echo "string";
// include ("../../../core/path.php");

$linksg = 'Classes/sendgrid/';
$SG_KEY="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";  // API KEY UNIVIDA

include_once $linksg.'vendor/autoload.php';
include_once $linksg.'lib/SendGrid.php';
include_once $linksg.'lib/SendGrid/Email.php';
include_once $linksg.'lib/SendGrid/Response.php';
include_once $linksg.'lib/SendGrid/Exception.php';

// MAIL ENVIADO A ATENCIÓN AL CLIENTE

$from_nombre = $_POST['name'];
$from_email = $_POST['email'];
$from_mensaje = $_POST['message'];

$toEmail = 'fiso@univida.bo';
$toName = "UNIVida S.A.";
$subject = "Consulta de cliente";

if($from_nombre!=''){
  $body  = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>UNIVida S.A.</title>
  </head>

  <body>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color: #f5f5f3; padding: 0; margin: 0;">
      <tr>
        <td align="center" valign="middle">
          <table width="650" border="0" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-top: 14px solid #124c8c; border-bottom: 14px solid #124c8c;">
      <tr>
        <td align="center" valign="middle">

        	<table width="650" border="0" cellpadding="0" cellspacing="0" style="padding:0; margin: 0;">
              <tr>
                <td align="center" valign="middle">
                	<img src="http://www.univida.bo/soat/lib/logo.png" alt="UNIVIDA" title="UNIVIDA" /></td>
              </tr>
            </table>
        </td>
      </tr>
    <tr>
      <td style="color: #333333; font-family: Arial, Helvetica, sans-serif; font-size:16px; line-height: 20px; text-align:left; padding: 22px 50px;">
  	  <p style="color: #0750a4; font-size:24px; font-weight: 700; text-align:center;">Recibimos un nuevo mensaje</p>
        <p>Estimado Admin,</p>
        <p>Hemos recibido un nuevo mensaje de '.$from_nombre.':</span></p>
        <p><span style="color: #0750a4; font-weight: 700;">Nombre: </span>'.$from_nombre.'</p>
        <p><span style="color: #0750a4; font-weight: 700;">Email: </span>'.$from_email.'</p>
        <p><span style="color: #0750a4; font-weight: 700;">Mensaje: </span></p>
        <p>'.$from_mensaje.'</p>
        <br/><br/>
        <p>Saludos,</p>
        <p style="font-size:14px;"><span style="font-size:18px;">Atención al cliente</span><br />
        <a href="mailto:fiso@univida.com" style="color:#f8981d; text-decoration:none;">fiso@univida.com</a><br />
        UNIVida S.A.</p>
      </td>
    </tr>
    <tr>
      <td align="left" valign="middle">

      </td>
    </tr>
  </table>

      </td>
    </tr>
  </table>

  </body>
  </html>';


  $sendgrid = new SendGrid($SG_KEY);
  $email = new SendGrid\Email();


  $email
  ->addTo($toEmail)
  ->addToName($toName)
  ->setFrom($from_email)
  ->setFromName($from_nombre)
  ->setSubject($subject)
  ->setHtml($body)
  ->addUniqueArgument('logkey', 'univida')
  ;
$sendgrid->send($email);
// die();
  // MAIL ENVIADO AL cliente



  $body  = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Univida</title>
  </head>

  <body>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color: #f5f5f3; padding: 0; margin: 0;">
    <tr>
      <td align="center" valign="middle">
        <table width="650" border="0" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-top: 14px solid #124c8c; border-bottom: 14px solid #124c8c;">
    <tr>
      <td align="center" valign="middle">

      	<table width="650" border="0" cellpadding="0" cellspacing="0" style="padding:0; margin: 0;">
            <tr>
              <td align="center" valign="middle">
              	<img src="http://www.univida.bo/soat/lib/logo.png" alt="UNIVIDA" title="UNIVIDA" />            </td>
            </tr>
          </table>
      </td>
    </tr>
    <tr>
      <td style="color: #585858; font-family: Arial, Helvetica, sans-serif; font-size:16px; line-height: 20px; text-align:left; padding: 22px 50px;">
  	  <p style="color: #124c8c; font-size:24px; font-weight: 700; text-align:center;">Recibimos su mensaje</p>
        <p>Estimado '.$from_nombre.',</p>
        <p>Hemos recibido su mensaje, lo atenderemos lo antes posible.</p>
        <br/><br/><br/>
        <p>Saludos,</p>
        <p style="font-size:14px;"><span style="font-size:18px;">Atención al cliente</span><br />
        <a href="mailto:fiso@univida.com" style="color:#f8981d; text-decoration:none;">fiso@univida.com</a><br />
        UNIVida S.A.</p>
      </td>
    </tr>
    <tr>
      <td align="left" valign="middle">

      </td>
    </tr>
  </table>

      </td>
    </tr>
  </table>

  </body>
  </html>';


      $sendgrid = new SendGrid($SG_KEY);
      $email = new SendGrid\Email();

      $email
      ->addTo($from_email)
      ->addToName($from_nombre)
      ->setFrom($toEmail)
      ->setFromName($toName)
      ->setSubject($subject)
      ->setHtml($body)
      ->addUniqueArgument('logkey', 'univida')
      ;
    $sendgrid->send($email);
// die();
      $msg="Su mensaje se envi&oacute; correctamente.";
}else{
	$msg = "Todos los datos son requeridos.";
}

$_SESSION["MSG"]=$msg;

header('Location: http://www.univida.bo/soat/contactanos');
die;
