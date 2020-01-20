<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
$app->ProcessModule(SB_Request::getString('mod', 'content'));
$template_file 	= $app->htmlDocument->GetTemplate();// SB_Request::getString('tpl', 'index.php');
sb_process_template("horarios");
sb_show_template();