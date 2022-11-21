<?php

namespace Linqur\IikoService\Api;

use Linqur\IikoService\Api\Request\Request;

class Api
{
    /**
     * Получить список организаций
     * 
     * @param array|null $organizationId Идентификаторы организаций, которые необходимо вернуть. По умолчанию - все организации
     * @param bool $returnAdditionalInfo Признак, следует ли возвращать дополнительную информацию об организации
     * @param bool $includeDisabled Возвращать отключенные организации
     * 
     * @return array
     */
    public function getOrganizations($organizationIds = null, $returnAdditionalInfo = false, $includeDisabled = false)
    {
        return (new Request())->getOrganizations($organizationIds, $returnAdditionalInfo, $includeDisabled);
    }

    /**
     * Получить группы терминалов
     * 
     * @param array $organizationIds 
     * @param bool $includeDisabled
     * 
     * @return array|null
     */
    public function getTerminalGroups($organizationIds, $includeDisabled = false)
    {
        return (new Request())->getTerminalGroups($organizationIds, $includeDisabled);
    }

    /**
     * Получить список способов оплат
     * 
     * @param array $organizationIds 
     * @param bool $includeDisabled
     * 
     * @return array|null
     */
    public function getPaymentTypes($organizationIds)
    {
        return (new Request())->getPaymentTypes($organizationIds);
    }

    /**
     * Получить нуменклатуру организации
     * 
     * Если передать версию ревизии, то ответ вернется только в том случае,
     * если есть более новая ревизия
     * 
     * @param string $organizationId 
     * @param int $startRevision версия ревизии
     * 
     * @return array|null
     */
    public function getNumenclature($organizationId, $startRevision = 0)
    {
        return (new Request())->getNumenclature($organizationId, $startRevision);
    }

    /**
     * Создать заказ
     * 
     * @param string $organizationId
     * @param string $terminalGroupId
     * @param array $order
     * 
     * @return array
     */
    public function deliveryOrderCreate($organizationId, $terminalGroupId, $order)
    {
        return (new Request())->deliveryOrderCreate($organizationId, $terminalGroupId, $order);
    }

    /**
     * Получить список типов заказа
     * 
     * @param array $organizationId
     * 
     * @return array
     */
    public function getOrderTypes($organizationIds)
    {
        return (new Request())->getOrderTypes($organizationIds);
    }

    /**
     * Получить список Городов
     * 
     * @param array $organizationId
     * 
     * @return array
     */
    public function getCityes($organizationIds)
    {
        return (new Request())->getCities($organizationIds);
    }

    /**
     * Получить список Улиц города
     * 
     * @param string $organizationId
     * @param string $cityId
     * 
     * @return array
     */
    public function getStreets($organizationId, $cityId)
    {
        return (new Request())->getStreets($organizationId, $cityId);
    }

    /**
     * Получить заказы
     * 
     * 
     * @param array $organizationIds
     * @param array|null $orderIds
     * @param array|null $sourceKeys
     * @param array|null $posOrderIds
     * 
     * @return array
     */
    public function getOrder($organizationIds, $orderIds = null, $sourceKeys = null, $posOrderIds = null)
    {
        return (new Request())->getOrder($organizationIds, $orderIds, $sourceKeys);
    }

    /**
     * Получить список стоп листов
     * 
     * @param array $organizationIds
     * 
     * @return array
     */
    public function getStopList($organizationIds)
    {
        return (new Request())->getStopList($organizationIds);
    }
}
