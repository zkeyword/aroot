<?php
session_start();
require('../../aroot.php');
require(SOURCE_PATH . '/class/checkcode.class.php');
$checkcode = new checkcode();
$_SESSION['randCode'] = $checkcode->get_code();
?>