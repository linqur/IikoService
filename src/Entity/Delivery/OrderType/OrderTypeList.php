<?php

namespace Linqur\IikoService\Entity\Delivery\OrderType;

use Linqur\IikoService\Api\Api;
use Linqur\IikoService\Entity\Organization\OrganizationList;
use Linqur\Singleton\SingletonTrait;

class OrderTypeList
{
    use SingletonTrait;

    const TIME_UPDATE_LIMIT = 86400;

    private $list = array();
    private $initAll = false;
    private $updated = false;

    /**
     * Получить по id в системе IIKO
     * 
     * @param string $id
     * 
     * @return OrderType|null
     */
    public function getById($id)
    {
        if (!isset($this->list[$id])) {
            $this->setById($id);
        }

        return isset($this->list[$id]) ? $this->list[$id] : null;
    }

    /**
     * Получить все типы зказов
     * 
     * @return OrderType[]
     */
    public function getAll()
    {
        
        if (!$this->initAll) {
            $this->setAll();
            $this->initAll = true;
        }
        return $this->list;
    }

    private function setById($id)
    {
        $repository = new Repository();
        $orderType = $repository->getById($id);

        $needToUpdate = !$orderType || $orderType->created->format('U') + self::TIME_UPDATE_LIMIT <= date('U');

        if ($needToUpdate && !$this->updated) {
            $this->update();
            $this->setById($id);
            return;
        }

        if ($orderType) {
            $this->list[$orderType->id] = $orderType;
        }
    }

    private function setAll()
    {
        $repository = new Repository();
        $orderTypeList = $repository->getAll();
        
        $lastUpdated = $repository->getAllLastUpdated();
        $needToUpdate = !$orderTypeList || !$lastUpdated || $lastUpdated->format('U') + self::TIME_UPDATE_LIMIT <= date('U');

        if ($needToUpdate && !$this->updated) {
            $orderTypeList = $this->update() ?: $orderTypeList;
        }

        foreach ($orderTypeList as $orderType) {
            $this->list[$orderType->id] = $orderType;
        }
    }

    private function update()
    {
        $organizationIds = array();
        foreach(OrganizationList::getInstance()->getAll() as $organization) {
            $organizationIds[] = $organization->id;
        }

        $orderTypes = (new Api())->getOrderTypes($organizationIds);

        $orderTypeList = array();
        if (!empty($orderTypes['orderTypes'])) {
            foreach ($orderTypes['orderTypes'] as $orderTypeGroup) {
                foreach ($orderTypeGroup['items'] as $orderType) {
                    $orderType['organizationId'] = $orderTypeGroup['organizationId'];
                    $orderTypeList[] = Builder::byResponse($orderType);
                }
            }

            $repository = new Repository();
            $repository->deleteAll();
            $repository->saveAll($orderTypeList);
        }

        $this->updated = true;

        return $orderTypeList;
    }
}