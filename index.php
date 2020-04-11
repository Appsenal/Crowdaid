<?php
require_once 'util/database.php';
require_once 'util/api.php';
require_once 'model/member.php';
require_once 'model/post.php';
require_once 'model/image.php';
require_once 'model/response.php';
require_once 'controller/control.php';

$control = new Control();

$control->LoadCurrentView();

?>