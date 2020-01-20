<?php
ini_alter('display_errors','on');
include_once("../simple99/database/connection.php");
include_once("../simple99/core/simple99.php");

$name_regis = SIMPLE99::toSql(safeHtml($_POST["name_regis"]), "Text");
$email_regis = SIMPLE99::toSql(safeHtml($_POST["email_regis"]), "Text");
$pass_regis = SIMPLE99::toSql(safeHtml($_POST["pass_regis"]), "Text");
$phone_regis = SIMPLE99::toSql(safeHtml($_POST["phone_regis"]), "Text");
$mobile_regis = SIMPLE99::toSql(safeHtml($_POST["mobile_regis"]), "Text");
$company_regis = SIMPLE99::toSql(safeHtml($_POST["company_regis"]), "Text");
$charge_regis = SIMPLE99::toSql(safeHtml($_POST["charge_regis"]), "Text");
$country_regis = SIMPLE99::toSql(safeHtml($_POST["country_regis"]), "Text");
$ciudad_regis = SIMPLE99::toSql(safeHtml($_POST["ciudad"]), "Text");

function generate($namespace = '') {
        static $guid = '';
        global $Session;
        $uid = uniqid("", true);
        $data = $namespace;
        $data .= $_SERVER['HTTP_USER_AGENT'];
        $data .= $_SERVER['REMOTE_ADDR'];
        $data .= $_SERVER['REMOTE_PORT'];
        $hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
        $guid = substr($hash, 0, 8) .
        '-' .
        substr($hash, 8, 4) .
        '-' .
        substr($hash, 12, 4) .
        '-' .
        substr($hash, 16, 4) .
        '-' .
        substr($hash, 20, 12);
        return $guid;
      }
      
$SessionFront = new Session('FRONT');
// Verifying required
// echo "aqui";
if ($name_regis && $email_regis && $pass_regis && $company_regis && $charge_regis && $country_regis) {
    // echo "aqui2";
    if (SIMPLE99::getDbValue("SELECT count(*) FROM mdl_user WHERE use_delete <> 1 and use_email='" . $email_regis . "'") == 0) {
    // if(true){
       // echo "aqui3";
        $hashtag = substr(generate(sha1(SITE . uniqid(rand(), TRUE))), 3, 26);
        $sql = "INSERT INTO mdl_user(use_pass, use_name, use_company, use_charge, use_city, use_coun, use_phone, use_phone2, use_email, use_delete, "
                . "use_status, use_code, use_upd, use_upd_date, use_date) VALUES ('" . md5($pass_regis) . "', '" . $name_regis . "', '" 
                . $company_regis . "', '" . $charge_regis . "', '" . $ciudad_regis . "', '" . $country_regis . "', '" . $phone_regis . "', '" 
                . $mobile_regis . "', '" . $email_regis . "', 0, 'INACTIVE', '" . $hashtag . "', 0, NOW(), NOW())";
        $db->query($sql);
        
        $tpl = new TemplateParser(PATH_ROOT . "/skin/mailing_registro.tpl");
        $tpl->initParser();
        $tpl->assign("PATH_DOMAIN", $domain );
        $tpl->assign("HASH_LINK", $domain.'/activar-cuenta/'.$hashtag.'/' );
        $tpl->assign("FULLNAME", $name_regis );
        
        $ct_mailto = $email_regis;
        $ct_nameto = $name_regis;


include_once 'vendor/autoload.php';
include_once 'lib/SendGrid.php';
include_once 'lib/SendGrid/Email.php';
include_once 'lib/SendGrid/Response.php';
include_once 'lib/SendGrid/Exception.php';
// include_once 'sendgrid-php.php';


    $body = $tpl->getString();

        // Plain text body (for mail clients that cannot read HTML)
        $text_body = '
    Estimado
    
    ' . $ct_nameto . ' gracias por registrarte en Aesa Ratings.
        
        Su cuenta ha sido creada exitosamente. Sin embargo, esta se encuentra inactiva por motivos de seguridad.
        Para activar su cuenta debe copiar el siguiente enlace en su navegador.
        
        '.$domain.'/activar-cuenta/'.$hashtag.'/ 
    
        Gracias por su colaboración.';

$sendgrid=new SendGrid('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');
$email = new SendGrid\Email();
$email
    ->addTo(array($ct_mailto))
    //->addTo('bar@foo.com') //One of the most notable changes is how `addTo()` behaves. We are now using our Web API parameters instead of the X-SMTPAPI header. What this means is that if you call `addTo()` multiple times for an email, **ONE** email will be sent with each email address visible to everyone.
    ->setFrom('soporte@aesa-ratings.bo')
    ->setSubject("Registro de usuario | Aesa Ratings")
    ->setText($text_body)
    ->setHtml(utf8_encode($body))
    ->addUniqueArgument('logkey','aesa')
;

$res=$sendgrid->send($email);
// print_r($res);


        // include_once("../phpmailer/class.phpmailer.php");
        // $mail = new PHPMailer();
        // $mail->IsSMTP();
        // $mail->SMTPDebug  = 0;
        // $mail->Mailer   = "smtp";
        // $mail->SMTPSecure = 'tls';
        // $mail->SMTPAuth   = true;
        // $mail->IsHTML(true);
        // $mail->Helo = "www.aesa-ratings.bo";
        // $mail->Host  = "www.aesa-ratings.bo";
        // $mail->From     = "soporte@aesa-ratings.bo";
        // $mail->Username   = "soporte@aesa-ratings.bo";
        // $mail->Password   = "T.+@?P?UN,b3";
        // $mail->FromName = 'Soporte Aesa Ratings';
        // $mail->Subject = utf8_decode("Registro de usuario | Aesa Ratings");
        


        // $mail->Body = $body;
        // $mail->AltBody = $text_body;
        // $mail->AddAddress($ct_mailto, $ct_nameto);

        // if ($mail->Send()) {
        //          $SessionFront->Set('MSG_INFO', 'Su cuenta se ha creado exitosamente');
        // };
        $urlRedirect = SIMPLE99::getFullUrl(58); // registro exitoso
        header("Location: " . $domain . "/" . $urlRedirect);
    } else { 
        $urlRedirect = SIMPLE99::getFullUrl(41); // olvidaste tu contraseña
        $msg = 'El correo electrónico ingresado ya fue usado. Por favor, usa otro correo electrónico o <a href="'.$domain.'/'.$urlRedirect.'">Recupera tu contraseña</a>.';
        $SessionFront->Set('MSG', $msg);
        $urlRedirect = SIMPLE99::getFullUrl(34); // registrase
        header("Location: " . $domain . "/" . $urlRedirect);
    };    
} else {
    $SessionFront->Set('MSG', 'Datos insuficientes');
    $urlRedirect = SIMPLE99::getFullUrl(34); // registrase
    header("Location: " . $domain . "/" . $urlRedirect);
}


