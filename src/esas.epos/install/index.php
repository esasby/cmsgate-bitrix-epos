<?
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/esas.epos/install/php_interface/include/sale_payment/epos/init.php");
use esas\cmsgate\bitrix\CmsgateCModule;

if(class_exists('esas_epos')) return;
class esas_epos extends CmsgateCModule
{

}
