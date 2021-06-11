<?php
/**
 * Используется встроенный механизм локализации bitrix, т.к. при создании ModuleDescriptor нельзя использовать
 * Registry->getTranslator (возникает бесконечная рекурсия)
 */
use esas\cmsgate\view\admin\AdminViewFields;

$MESS['epos_module_name'] = "Прием платежей через ЕРИП (сервис EPOS)";
$MESS['epos_module_description'] = "Выставление пользовательских счетов в ЕРИП";