<?php

require_once('vendor/autoload.php');

$db_user = "username";
$db_password = "password";
$db_connect_string="mysql:host=localhost;dbname=qdp;charset=utf8";
$default_theme="thelist";

$config_version = 0.1;
$site_name = 'qdp';
$base_url = '';
$install_path = '/var/www/html';
$friendly_urls=true;

$cas_host="login.creativecommons.org";
$cas_port=443;
$cas_context="";

// Path to the ca chain that issued the cas server certificate
$cas_server_ca_cert_path = '/path/to/cachain.pem';
