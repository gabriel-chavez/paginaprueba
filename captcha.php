<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
sb_captcha(null, SB_Request::getString('var', 'login_captcha'));