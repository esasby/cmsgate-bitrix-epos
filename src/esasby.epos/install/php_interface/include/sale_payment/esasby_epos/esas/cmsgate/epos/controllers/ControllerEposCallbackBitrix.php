<?php

namespace esas\cmsgate\epos\controllers;

use CSaleOrder;
use esas\cmsgate\epos\controllers\ControllerEposCallback;

class ControllerEposCallbackBitrix extends ControllerEposCallback
{
    public function onStatusPayed()
    {
        parent::onStatusPayed();
        CSaleOrder::Update($this->localOrderWrapper->getOrderId(), array("PAYED" => "Y"));
        CSaleOrder::PayOrder($this->localOrderWrapper->getOrderId(), "Y");
    }

}