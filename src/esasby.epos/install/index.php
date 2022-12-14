<?
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/esasby.epos/install/php_interface/include/sale_payment/esasby_epos/init.php");
use esas\cmsgate\bitrix\CmsgatePaysystem;
use esas\cmsgate\bitrix\InstallHelper;
use esas\cmsgate\CmsConnectorBitrix;
use esas\cmsgate\epos\ConfigFieldsEpos;
use esas\cmsgate\epos\EventHandlerEpos;
use esas\cmsgate\Registry;

if(class_exists('esasby_epos')) return;
class esasby_epos extends CModule
{
    var $MODULE_PATH;
    var $MODULE_ID = 'esasby.epos';
    var $MODULE_VERSION = '';
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_GROUP_RIGHTS = 'Y';
    var $PARTNER_NAME;
    var $PARTNER_URI;
    /**
     * @var \esas\cmsgate\bitrix\InstallHelper
     */
    protected $installHelper;

    public function __construct()
    {
        CModule::IncludeModule("sale");
        $this->installHelper = new InstallHelper($this);
        $this->installHelper->createAndAddMainPaySystem();
        $webpayPS = new CmsgatePaysystem();
        $webpayPS
            ->setName(Registry::getRegistry()->getTranslator()->getConfigFieldDefault(ConfigFieldsEpos::paymentMethodNameWebpay()))
            ->setDescription(Registry::getRegistry()->getTranslator()->getConfigFieldDefault(ConfigFieldsEpos::paymentMethodDetailsWebpay()))
            ->setType("ORDER")
            ->setActionFile("esasby_epos_webpay");
        $this->installHelper->addToInstallPaySystemsList($webpayPS);

        $this->MODULE_PATH = $_SERVER['DOCUMENT_ROOT'] . '/bitrix' . InstallHelper::MODULE_SUB_PATH . CmsConnectorBitrix::getInstance()->getModuleActionName();
        $this->MODULE_VERSION = Registry::getRegistry()->getModuleDescriptor()->getVersion()->getVersion();
        $this->MODULE_VERSION_DATE = Registry::getRegistry()->getModuleDescriptor()->getVersion()->getDate();
        $this->MODULE_NAME = Registry::getRegistry()->getModuleDescriptor()->getModuleFullName();
        $this->MODULE_DESCRIPTION = Registry::getRegistry()->getModuleDescriptor()->getModuleDescription();
        $this->PARTNER_NAME = "esasby"; // for bitrix marketplace
        $this->PARTNER_URI = "esas.by"; // for bitrix marketplace
        $this->PARTNER_NAME = Registry::getRegistry()->getModuleDescriptor()->getVendor()->getFullName();
        $this->PARTNER_URI = Registry::getRegistry()->getModuleDescriptor()->getVendor()->getUrl();
    }

    function InstallEvents()
    {
        //?????????????? OnSaleOrderSetField ???? ????????????????, ??.??. ???????????????????? ?????? ???? ???????????? ???????????????????? ?????????? ???????????? ?? ????????????, ??.??. orderWrapper ???? ?????????? ???????????????? ?? ?????? ????????????
        $eventManager = \Bitrix\Main\EventManager::getInstance();
        $eventManager->registerEventHandler('sale', 'OnSaleOrderSaved', Registry::getRegistry()->getModuleDescriptor()->getModuleMachineName(), EventHandlerEpos::class, 'onSaleOrderSaved');
    }

    function UnInstallEvents()
    {
        $eventManager = \Bitrix\Main\EventManager::getInstance();
        $eventManager->unRegisterEventHandler('sale', 'OnSaleOrderSaved', Registry::getRegistry()->getModuleDescriptor()->getModuleMachineName(), EventHandlerEpos::class, 'onSaleOrderSaved');
    }

    function DoInstall()
    {
        return $this->installHelper->DoInstall();
    }

    function DoUninstall()
    {
        return $this->installHelper->DoUninstall();
    }
}
