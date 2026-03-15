<?php
session_start();

require_once 'config/config.php';
require_once 'core/App.php';
require_once 'core/Controller.php';
require_once 'core/Model.php';
require_once 'core/Session.php';
require_once 'helpers/function.php';
require_once 'helpers/validation.php';

$app = new App();