<?php


namespace esas\cmsgate\epos;

use CSaleOrder;
use esas\cmsgate\epos\protocol\EposInvoiceGetRs;
use esas\cmsgate\wrappers\OrderWrapper;

class HooksEposBitrix extends HooksEpos
{
    public function onCallbackStatusPayed(OrderWrapper $orderWrapper, EposInvoiceGetRs $resp)
    {
        parent::onCallbackStatusPayed($orderWrapper, $resp);
        CSaleOrder::Update($orderWrapper->getOrderId(), array("PAYED" => "Y"));
        CSaleOrder::PayOrder($orderWrapper->getOrderId(), "Y");
    }

}