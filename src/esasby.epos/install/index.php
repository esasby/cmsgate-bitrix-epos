<?
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/esasby.epos/install/php_interface/include/sale_payment/esasby_epos/init.php");
use esas\cmsgate\bitrix\CmsgateCModule;
use esas\cmsgate\bitrix\CmsgatePaysystem;
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
     * @var \esas\cmsgate\bitrix\CmsgateCModule
     */
    protected $installHelper;

    /**
     * CmsgateCModule constructor.
     */
    public function __construct()
    {
        CModule::IncludeModule("sale");
        $this->installHelper = (new CmsgateCModule())
            ->addToInstallFilesList(CmsgateCModule::MODULE_SUB_PATH . "esasby_webpay")
            ->addToInstallFilesList(CmsgateCModule::MODULE_IMAGES_SUB_PATH . "esasby_webpay.png");

        $webpayPS = new CmsgatePaysystem();
        $webpayPS
            ->setName("Оплата картой")
            ->setDescription("Онлайн оплата картой Visa, MasterCard, Белкарт")
            ->setType("ORDER")
            ->setActionFile("esasby_webpay");
        $this->installHelper->addToInstallPaySystemsList($webpayPS);

        $this->MODULE_PATH = $_SERVER['DOCUMENT_ROOT'] . '/bitrix' . CmsgateCModule::MODULE_SUB_PATH . $this->installHelper->getModuleActionName();
        $this->MODULE_VERSION = Registry::getRegistry()->getModuleDescriptor()->getVersion()->getVersion();
        $this->MODULE_VERSION_DATE = Registry::getRegistry()->getModuleDescriptor()->getVersion()->getDate();
        $this->MODULE_NAME = Registry::getRegistry()->getModuleDescriptor()->getModuleFullName();
        $this->MODULE_DESCRIPTION = Registry::getRegistry()->getModuleDescriptor()->getModuleDescription();
        $this->PARTNER_NAME = "esasby";
        $this->PARTNER_URI = "esas.by";
    }


    function InstallDB($arParams = array())
    {
        return $this->installHelper->InstallDB($arParams);
    }

    function UnInstallDB($arParams = array())
    {
        return $this->installHelper->UnInstallDB($arParams);
    }

    function InstallEvents()
    {
        return $this->installHelper->InstallEvents();
    }

    function UnInstallEvents()
    {
        return $this->installHelper->UnInstallEvents();
    }

    function InstallFiles($arParams = array())
    {
        return $this->installHelper->InstallFiles();
    }

    function UnInstallFiles()
    {
        return $this->installHelper->UnInstallFiles();
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
