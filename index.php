<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config/config.php';
require_once 'core/Session.php';
require_once 'core/App.php';
require_once 'core/Controller.php';
require_once 'core/Model.php';
require_once 'helpers/function.php';
require_once 'helpers/validation.php';

Session::init();

$app = new App();

ob_end_flush();
