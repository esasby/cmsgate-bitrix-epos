<?

namespace Sale\Handlers\PaySystem;

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/php_interface/include/sale_payment/esasby_epos/init.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/php_interface/include/sale_payment/esasby_epos/handler.php"); // иначе не находи класс

use Bitrix\Main\Error;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Request;
use Bitrix\Sale\Payment;
use Bitrix\Sale\PaySystem;
use Bitrix\Sale\PaySystem\ServiceResult;
use esas\cmsgate\CmsConnectorBitrix;
use esas\cmsgate\epos\controllers\ControllerEposAddInvoice;
use esas\cmsgate\epos\controllers\ControllerEposWebpayForm;
use esas\cmsgate\Registry;
use Throwable;

class esasby_epos_webpayHandler extends esasby_eposHandler
{
    /**
     * @param Payment $payment
     * @param Request|null $request
     * @return PaySystem\ServiceResult
     * @throws \Bitrix\Main\LoaderException
     */
    public function initiatePay(Payment $payment, Request $request = null)
    {
        if (Loader::includeModule(Registry::getRegistry()->getModuleDescriptor()->getModuleMachineName())) {
            try {
                $orderWrapper = Registry::getRegistry()->getOrderWrapperByOrderNumber($payment->getOrderId());
                CmsConnectorBitrix::getInstance()->setCurrentPayment($payment);
                // проверяем, привязан ли к заказу extId, если да,
                // то счет не выставляем, а просто прорисовываем старницу
                if (!$orderWrapper->isExtIdFilled()) {
                    $controller = new ControllerEposAddInvoice();
                    $controller->process($orderWrapper);
                }
                $controller = new ControllerEposWebpayForm();
                $webpayResp = $controller->process($orderWrapper);
                $extraParams['webpayForm'] = $webpayResp->getHtmlForm();
                $this->setExtraParams($extraParams);
                return $this->showTemplate($payment, 'template');
            } catch (Throwable $e) {
                $this->logger->error("Exception:", $e);
                $result = new ServiceResult();
                $result->addError(new Error($e->getMessage()));
                return $result;
            }
        } else {
            $result = new ServiceResult();
            $result->addError(new Error(Loc::getMessage('SALE_HPS_PAYMENTGATE_MODULE_NOT_FOUND')));
            return $result;
        }
    }
}