<?php

namespace Linqur\IikoService\Entity\Organization;

use Linqur\IikoService\Entity\Repository\Repository as IikoServiceRepository;
use Linqur\IikoService\Entity\Repository\System\Repository as SystemRepository;
use Linqur\IikoService\Entity\Repository\TableCreator\SettingsBuilder;

class Repository
{
    const TABLE_NAME = 'Organization';
    const ALL_UPDATED_SYSTEM_FIDEL = 'organization_all_updated';

    /** @return Organization|null */
    public function getById($id)
    {
        if (!IikoServiceRepository::getInstance()->isOn() || !$this->isTableExists()) {
            return null;
        }
        
        $row = IikoServiceRepository::getInstance()->getRow(self::TABLE_NAME, ['id' => $id]);

        return $row ? Builder::byRepository($row) : null;
    }

    /** @return Organization[] */
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
        if (!$lastUpdated = (new SystemRepository())->get(self::ALL_UPDATED_SYSTEM_FIDEL)) {
            return null;
        }

        return (new \DateTime())->setTimestamp($lastUpdated);
    }

    /** @param Organization $organization */
    public function save($organization)
    {
        if (!IikoServiceRepository::getInstance()->isOn()) return;

        if (!$this->isTableExists()) $this->createTable();

        if ($this->getById($organization->id)) {
            IikoServiceRepository::getInstance()->update(
                self::TABLE_NAME, 
                array(
                    'name' => $organization->name,
                    'created' => $organization->createdTime->format('U'),
                ), 
                array('id' => $organization->id)
            );
        } else {
            IikoServiceRepository::getInstance()->insert(
                self::TABLE_NAME, 
                array(
                    'id' => $organization->id,
                    'name' => $organization->name,
                    'created' => $organization->createdTime->format('U'),
                )
            );
        }
    }

    /** @param Organization[] $organizationList */
    public function saveAll($organizationList)
    {
        foreach ($organizationList as $organization) {
            $this->save($organization);
        }

        (new SystemRepository())->set(self::ALL_UPDATED_SYSTEM_FIDEL, date('U'));
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
            SettingsBuilder::fromJson(__DIR__.'/OrganizationTable.json')
        );
    }
}
