<?php

namespace Linqur\IikoService;

use Linqur\IikoService\Api\Api;
use Linqur\IikoService\Api\Token\Token;
use Linqur\IikoService\Entity\Delivery\OrderType\OrderTypeList;
use Linqur\IikoService\Entity\Organization\Organization;
use Linqur\IikoService\Entity\Organization\OrganizationList;
use Linqur\IikoService\Entity\PaymentType\PaymentTypeList;
use Linqur\IikoService\Entity\Terminal\TerminalList;
use Linqur\IikoService\Settings\Settings;
use Linqur\IikoService\Settings\SettingsValues;
use Linqur\IikoService\Settings\SettingsValuesInterface;
use Linqur\Singleton\SingletonTrait;

class IikoProvider
{
    use SingletonTrait;

    /**
     * Получить объект настроек
     * 
     * @return SettingsValues
     */
    public function getSettingsValues()
    {
        return new SettingsValues();
    }

    /**
     * Установить настройки
     * 
     * @param SettingsValuesInterface $settingsValues
     */
    public function setSettings($settingsValues)
    {
        Settings::getInstance()->setValues($settingsValues);
    }

    /** 
     * Получить список организаций
     * 
     * @return OrganizationList 
     */
    public function getOrganizationList()
    {
        return OrganizationList::getInstance();
    }

    /** 
     * Получить список терминалов
     * 
     * @return TerminalList 
     */
    public function getTerminalList()
    {
        return TerminalList::getInstance();
    }

    /** 
     * Получить список типов оплаты
     * 
     * @return PaymentTypeList
     */
    public function getPaymentTypeList()
    {
        return PaymentTypeList::getInstance();
    }

    /** 
     * Получить список типов заказа
     * 
     * @return OrderTypeList
     */
    public function getOrderTypeList()
    {
        return OrderTypeList::getInstance();
    }

    /**
     * Получить нуменклатуру
     * 
     * @param Organization $organization
     * @param int $startRevision
     * 
     * @return array|null
     */
    public function getNumenclature($organization, $startRevision = 0)
    {
        return (new Api())->getNumenclature($organization->id, $startRevision);
    }

    /**
     * Создать зааказ
     * 
     * @param string $organizationId
     * @param string $terminalId 
     * @param array $order
     */
    public function deliveryOrderCreate($organizationId, $terminalId, $order)
    {
        return (new Api())->deliveryOrderCreate($organizationId, $terminalId, $order);
    }

    /**
     * Получить токен
     * 
     * @return Token
     */
    public function getToken()
    {
        return Token::getInstance();
    }
}