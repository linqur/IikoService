<?php

namespace Linqur\IikoService\Api;

use Linqur\IikoService\Api\Request\Request;

class Api
{
    /**
     * Получить список организаций
     * 
     * @param array|string|null $organizationId Идентификаторы организаций, которые необходимо вернуть. По умолчанию - все организации
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
     * @param array|string $organizationIds 
     * @param bool $includeDisabled
     * 
     * @return array|null
     */
    public function getTerminalGroups($organizationIds, $includeDisabled = false)
    {
        return (new Request())->getTerminalGroups($organizationIds, $includeDisabled);
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
}
