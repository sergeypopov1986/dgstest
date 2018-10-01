<?php
define("P_APP", "/local/");
define("P_DR", $_SERVER["DOCUMENT_ROOT"]);
define("P_APP_PATH", P_DR . P_APP);
define("P_PHP_INTERFACE", P_APP_PATH . "php_interface/");

define("P_INCLUDE", SITE_DIR . "include_areas/");

define("P_LIBRARY", P_APP_PATH . "libs/");
define("P_CLASSES", P_PHP_INTERFACE . "classes/");
define("P_MARKUP", P_APP . "");

define("HLB_USER_DATA_ID" , 3);