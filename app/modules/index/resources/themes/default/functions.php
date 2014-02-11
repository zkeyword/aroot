<?php
if(!defined("INC")) exit("Request Error!");

addAction('after_setup_theme', 'default_setup');

function default_setup() {
	echo 'ddd';
}


?>