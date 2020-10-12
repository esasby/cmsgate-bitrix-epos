<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use esas\cmsgate\CmsConnectorBitrix;
use esas\cmsgate\ConfigFields;
use esas\cmsgate\messenger\MessagesBitrix;
use esas\cmsgate\Registry;
use esas\cmsgate\utils\htmlbuilder\Attributes as attribute;
use esas\cmsgate\utils\htmlbuilder\Elements as element;

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/php_interface/include/sale_payment/esasby_epos/init.php");

Loc::loadMessages(__FILE__);

// все настройки хранятся в корневом модуле esasby_hutkigrosh
$data = array(
    'NAME' => Registry::getRegistry()->getTranslator()->getConfigFieldDefault(ConfigFields::paymentMethodName()),
    'SORT' => 500);
$description = element::div(
    attribute::style("color:red"),
    element::content(
        Registry::getRegistry()->getTranslator()->translate(MessagesBitrix::PARENT_PS_CONFIG) .
        element::a(
            attribute::href('/bitrix/admin/sale_pay_system_edit.php?ID=' . CmsConnectorBitrix::getInstance()->getPaysystemId()),
            element::content(Registry::getRegistry()->getModuleDescriptor()->getModuleMachineName())
        )
    )

);

