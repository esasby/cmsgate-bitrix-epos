<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use esas\cmsgate\epos\RegistryEposBitrix;
use esas\cmsgate\view\admin\ConfigFormBitrix;

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/php_interface/include/sale_payment/esasby_epos/init.php");

Loc::loadMessages(__FILE__);

$data = RegistryEposBitrix::getRegistry()->getConfigFormWebpay()->generate();
$description = ConfigFormBitrix::generateModuleDescription()->__toString();

