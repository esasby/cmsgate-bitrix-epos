<?php


namespace esas\cmsgate\epos;

use Bitrix\Sale\Order;
use CSaleOrder;
use esas\cmsgate\CmsConnectorBitrix;
use esas\cmsgate\epos\protocol\EposCallbackRq;
use esas\cmsgate\epos\protocol\EposInvoiceGetRs;
use esas\cmsgate\wrappers\OrderWrapper;
use esas\cmsgate\wrappers\OrderWrapperBitrix;

class HooksEposBitrix extends HooksEpos
{
    public function onCallbackRqRead(EposCallbackRq $rq)
    {
        parent::onCallbackRqRead($rq);
        // bitrix has no simple way to create Payment object by ID (fields array only)
        $dbPayment = \Bitrix\Sale\PaymentCollection::getList([
            'select' => ['*'],
            'filter' => [
                '=' . OrderWrapperBitrix::DB_EXT_ID_FIELD => $rq->getInvoiceId(),
            ]
        ]);
        $paymentArray = $dbPayment->fetch();
        $order = Order::load($paymentArray['ORDER_ID']);
        $payment = $paymentCollection = $order->getPaymentCollection()->getItemById($paymentArray['ID']);
        CmsConnectorBitrix::getInstance()->setCurrentPayment($payment);
    }


    public function onCallbackStatusPayed(OrderWrapper $orderWrapper, EposInvoiceGetRs $resp)
    {
        parent::onCallbackStatusPayed($orderWrapper, $resp);
        CSaleOrder::Update($orderWrapper->getOrderId(), array("PAYED" => "Y"));
        CSaleOrder::PayOrder($orderWrapper->getOrderId(), "Y");
    }

}