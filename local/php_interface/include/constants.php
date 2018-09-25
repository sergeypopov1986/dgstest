<?php
define("P_APP", "/local/");
define("P_DR", $_SERVER["DOCUMENT_ROOT"]);
define("P_APP_PATH", P_DR . P_APP);
define("P_PHP_INTERFACE", P_APP_PATH . "php_interface/");

define("P_INCLUDE", SITE_DIR . "include_areas/");

define("P_LIBRARY", P_APP_PATH . "libs/");
define("P_CLASSES", P_LIBRARY . "classes/");
define("P_MARKUP", P_APP . "");
define("IBLOCK_PROPOSAL_ID", "4");
define("IBLOCK_PROPOSAL_TYPE", "proposals");
define("PROPOSAL_EMAIL_EVENT", "PROPOSAL_EMAIL_EVENT");