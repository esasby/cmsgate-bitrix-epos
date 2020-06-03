## Модуль интеграции с CMS Bitrix
Данный модуль обеспечивает взаимодействие между интернет-магазином на базе CMS Bitrix (с модулем электронной комерции __sale__) и сервисом платежей [ХуткiГрош](https://hutkigrosh.by)
  
### Требования ###
1. PHP 5.6 и выше
1. Библиотека Curl

## Инструкция по установке:
### Автоматическая установка (через Marketplace) 
1. Перейти на страницу _Marketplace > Каталог решений_
1. Введите в поиске _EPOS_
1. Установите решение
### Ручная установка
1. Загрузите архив модуля [esas.epos.zip](https://bitbucket.esas.by/projects/CG/repos/cmsgate-bitrix-epos/browse/esas.epos.zip)
(кодировка cp-1251) 
1. Распакуйте архив в папку 
```/bitrix/modules/```
После распаковки должна появиться папка 
```/bitrix/modules/esas.epos```
1. Убедитесь, что у системы bitrix есть права на запись для директории
```/bitrix/modules/esas.epos/install/php_interface/include/sale_payment/epos/vendor/esas/cmsgate-core/```
Иначе может возникнуть Exception при создании директории с логами модуля
1. Перейти на страницу _Marketplace > Установленные решения_ (/bitrix/admin/partner_modules.php)
1. В контекстном меню решения esasby.hutkigrosh выбрать "Установить".

## Инструкция по настройке
1. Перейти на страницу _Магазин > Настройки > Платежные системы_ (/bitrix/admin/sale_pay_system.php)
1. В контекстном меню платежной системы "EPOS" выбрать "Изменить". 
1. В секции _"Настройка обработчика ПС"_ укажите обязательные параметры
    * Идентификатор клиента – Ваш персональный логи для работы с сервисом EPOS
    * Секрет – Ваш секретный ключ для работы с сервисом EPOS
    * Код ПУ – код поставщика услуги в системе EPOS
    * Код услуги EPOS – код услуги у поставщика услуг в системе EPOS (один ПУ может предоставлять несколько разных услуг)
    * Код торговой точки – код торговой точки ПУ (у одного ПУ может быть несколько торговых точек)
    * Подключение к ESAS – если выбран, то интернет магазин подлючен к EPOS через ООО "Электронные Системы и Сервисы". Иначе через ООО "Универсальные Платежные Системы"
    * Debug mode - запись и отображение дополнительных сообщений при работе модуля
    * Sandbox - перевод модуля в тестовый режим работы. В этом режиме счета выставляются в тестовую систему
    * Срок действия счета - как долго счет, будет доступен в ЕРИП для оплаты    
    * Статус при выставлении счета  - какой статус выставить заказу при успешном выставлении счета в ЕРИП (идентификатор существующего статуса из Магазин > Настройки > Статусы)
    * Статус при успешной оплате счета - какой статус выставить заказу при успешной оплате выставленного счета (идентификатор существующего статуса)
    * Статус при отмене оплаты счета - какой статус выставить заказу при отмене оплаты счета (идентификатор существующего статуса)
    * Статус при ошибке оплаты счета - какой статус выставить заказу при ошибке выставленния счета (идентификатор существующего статуса)
    * Секция "Инструкция" - если включена, то на итоговом экране клиенту будет доступна пошаговая инструкция по оплате счета в ЕРИП
    * Секция QR-code - если включена, то на итоговом экране клиенту будет доступна оплата счета по QR-коду
    * Секция Webpay - если включена, то на итоговом экране клиенту отобразится кнопка для оплаты счета картой (переход на Webpay)
    * Текст успешного выставления счета - текст, отображаемый кленту после успешного выставления счета. Может содержать html. В тексте допустимо ссылаться на переменные @order_id, @order_number, @order_total, @order_currency, @order_fullname, @order_phone, @order_address

## Удаление модуля
1. Для удаления модуля перейти на страницу _Marketplace > Установленные решения_ (/bitrix/admin/partner_modules.php)
В контекстном меню решения esas.epos выбрать "Удалить". Затем "Стереть"
1. Сохраните изменения

### Внимание!
1. Для автоматического обновления статуса заказа (после оплаты клиентом выставленного в ЕРИП счета) необходимо сообщить в службу технической поддержки сервиса «Хуткi Грош» адрес обработчика:
```
http://mydomen.my/bitrix/tools/sale_ps_result.php?handler=epos
```
2. Для корректной работы модуля необходимо включить библиотеку curl. Для подключения curl в bitrix копируем 20-curl.ini.disabled в 20-curl.ini

### Тестовые данные
Для настрой оплаты в тестовом режиме:
 * воспользуйтесь данными для подключения к тестовой системе, полученными при регистрации в EPOS
 * включите в настройках модуля тестовый режим 

_Разработано и протестировано с 1С-Битрикс: Управление сайтом 17.0.9_


