<?php

namespace Linqur\IikoService\Entity\Delivery\OrderType;

use Linqur\IikoService\Entity\Repository\Repository as IikoServiceRepository;
use Linqur\IikoService\Entity\Repository\System\Repository as SystemRepository;
use Linqur\IikoService\Entity\Repository\TableCreator\SettingsBuilder;

class Repository
{
    const TABLE_NAME = 'Order_Type';
    const ALL_UPDATED_SYSTEM_FIELD = 'order_type_all_updated';

    /** @return OrderyType|null */
    public function getById($id)
    {
        if (!IikoServiceRepository::getInstance()->isOn() || !$this->isTableExists()) {
            return null;
        }
        
        $row = IikoServiceRepository::getInstance()->getRow(self::TABLE_NAME, ['id' => $id]);

        return $row ? Builder::byRepository($row) : null;
    }

    /** @return OrderyType[] */
    public function getAll()
    {
        if (!IikoServiceRepository::getInstance()->isOn() || !$this->isTableExists()) {
            return array();
        }

        $rows = IikoServiceRepository::getInstance()->getRows(self::TABLE_NAME) ?: array();

        $list = array();
        foreach ($rows as $row) {
            $list[] = Builder::byRepository($row);
        }

        return $list;
    }
    
    /** @return \DateTimeInterface|null */
    public function getAllLastUpdated()
    {
        if (!$lastUpdated = (new SystemRepository())->get(self::ALL_UPDATED_SYSTEM_FIELD)) {
            return null;
        }

        return (new \DateTime())->setTimestamp($lastUpdated);
    }

    /** @param OrderyType $orderyType */
    public function save($orderyType)
    {
        if (!IikoServiceRepository::getInstance()->isOn()) return;

        if (!$this->isTableExists()) $this->createTable();

        if ($this->getById($orderyType->id)) {
            IikoServiceRepository::getInstance()->update(
                self::TABLE_NAME, 
                array(
                'organization_id' => $orderyType->organizationId,
                'name' => $orderyType->name,
                'order_service_type' => $orderyType->orderServiceType,
                'created' => $orderyType->created->format('U'),
                ),
                array('id' => $orderyType->id)
            );
        } else {
            IikoServiceRepository::getInstance()->insert(
                self::TABLE_NAME, 
                array(
                    'id' => $orderyType->id,
                    'organization_id' => $orderyType->organizationId,
                    'name' => $orderyType->name,
                    'order_service_type' => $orderyType->orderServiceType,
                    'created' => $orderyType->created->format('U'),
                )
            );
        }
    }

    /** @param OrderyType[] $orderyTypeList */
    public function saveAll($orderyTypeList)
    {
        foreach ($orderyTypeList as $orderType) {
            $this->save($orderType);
        }

        (new SystemRepository())->set(self::ALL_UPDATED_SYSTEM_FIELD, date('U'));
    }

    public function deleteAll()
    {
        if (!IikoServiceRepository::getInstance()->isOn()) return;
        IikoServiceRepository::getInstance()->delete(self::TABLE_NAME);
    }

    private function isTableExists()
    {
        return IikoServiceRepository::getInstance()->isTableExists(self::TABLE_NAME);
    }

    private function createTable()
    {
        IikoServiceRepository::getInstance()->createTable(
            SettingsBuilder::fromJson(__DIR__.'/OrderTypetable.json')
        );
    }
}
