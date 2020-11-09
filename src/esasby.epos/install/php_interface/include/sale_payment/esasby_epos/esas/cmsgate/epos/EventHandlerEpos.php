<?php
/**
 * Created by IntelliJ IDEA.
 * User: nikit
 * Date: 25.06.2020
 * Time: 11:03
 */

namespace esas\cmsgate\epos;


use esas\cmsgate\bitrix\CmsgateEventHandler;
use esas\cmsgate\epos\controllers\ControllerEposInvoiceUpdate;
use esas\cmsgate\Registry;

class EventHandlerEpos extends CmsgateEventHandler
{

    public static function onSaleOrderSaved(\Bitrix\Main\Event $event)
    {
        /** @var \Bitrix\Sale\Order $order */
        $order = $event->getParameter('ENTITY');
        $isNew = $event->getParameter('IS_NEW');
        $oldPrice = $event->getParameter('VALUES')['PRICE'];
        if (!$isNew && $order->getId() > 0 && $oldPrice != null) {
            $orderWrapper = Registry::getRegistry()->getOrderWrapper($order->getId());
            $controller = new ControllerEposInvoiceUpdate();
            $controller->process($orderWrapper);
        }
    }

}