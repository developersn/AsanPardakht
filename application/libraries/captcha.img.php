<?php 
/**
* @ Version: $Id: captcha.img.php 1878 2008-01-25 21:26:29Z datahell $
* @ Copyright: Copyright (C) 2006-2008 Elxis.org. All rights reserved.
* @ Package: Elxis
* @ Subpackage: Captcha
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Elxis CMS is a Free Software
*/

# Used for Reza Cms pro
# Reza-sh.ir
# info@rezaonline.net


session_start();
include(dirname(__FILE__).'/captcha.class.php');
$captcha = new CaptchaNumbersV2(4,12,'png');
$captcha->display();
$_SESSION['captcha'] = $captcha->getEncString();
?>