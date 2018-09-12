<?php
spl_autoload_register('customAutoload', false);

if (file_exists(P_LIBRARY . "vendor/autoload.php"))
    require_once(P_LIBRARY . "vendor/autoload.php");

if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/constants.php"))
    require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/constants.php");
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/functions.php"))
    require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/functions.php");
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/handlers.php"))
    require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/handlers.php");


/**
 * @param $className
 * @return bool
 */
function customAutoload($className)
{
    if (!\Bitrix\Main\Loader::isAutoLoadClassRegistered($className)) {
        $path = P_CLASSES . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
        if (file_exists($path)) {
            require_once $path;
            return true;
        }
        return false;
    }
    return true;
}
