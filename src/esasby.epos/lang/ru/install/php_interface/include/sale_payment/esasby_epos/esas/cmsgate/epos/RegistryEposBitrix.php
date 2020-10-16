<?php
/**
 * Используется встроенный механизм локализации bitrix, т.к. при создании ModuleDescriptor нельзя использовать
 * Registry->getTranslator (возникает бесконечная рекурсия)
 */
use esas\cmsgate\view\admin\AdminViewFields;

$MESS[AdminViewFields::ADMIN_PAYMENT_METHOD_NAME] = "Прием платежей через ЕРИП (сервис EPOS)";
$MESS[AdminViewFields::ADMIN_PAYMENT_METHOD_DESCRIPTION] = "Выставление пользовательских счетов в ЕРИП";