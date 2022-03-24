<?php

require_once "controllers/index.controller.php";
require_once "controllers/users.controller.php";
require_once "controllers/routes.controller.php";
require_once "controllers/areas.controller.php";

require_once "models/users.model.php";
require_once "models/areas.model.php";

require_once 'extensions/vendor/autoload.php';

$index = new IndexController();
$index -> ctrIndex();