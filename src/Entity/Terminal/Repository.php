<?php

namespace Linqur\IikoService\Entity\Terminal;

use Linqur\IikoService\Entity\Repository\Repository as IikoServiceRepository;
use Linqur\IikoService\Entity\Repository\System\Repository as SystemRepository;
use Linqur\IikoService\Entity\Repository\TableCreator\SettingsBuilder;

class Repository
{
    const TABLE_NAME = 'Terminal';
    const ALL_UPDATED_SYSTEM_FIDEL = 'terminal_all_updated';

    /** @return Terminal|null */
    public function getById($id)
    {
        if (!IikoServiceRepository::getInstance()->isOn() || !$this->isTableExists()) {
            return null;
        }
        
        $row = IikoServiceRepository::getInstance()->getRow(self::TABLE_NAME, ['id' => $id]);

        return $row ? Builder::byRepository($row) : null;
    }

    /** @return Terminal[] */
    public function getAll()
    {
        if (!IikoServiceRepository::getInstance()->isOn() || !$this->isTableExists()) {
            return null;
        }

        $rows = IikoServiceRepository::getInstance()->getRows(self::TABLE_NAME) ?: array();

        $list = [];
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

    /** @param Terminal $terminal */
    public function save($terminal)
    {
        if (!IikoServiceRepository::getInstance()->isOn()) return;

        if (!$this->isTableExists()) $this->createTable();

        if ($this->getById($terminal->id)) {
            IikoServiceRepository::getInstance()->update(
                self::TABLE_NAME, 
                array(                    
                    'organization_id' => $terminal->organizationId,
                    'name' => $terminal->name,
                    'address' => $terminal->address,
                    'created' => $terminal->created->format('U'),
                ), 
                array('id' => $terminal->id)
            );
        } else {
            IikoServiceRepository::getInstance()->insert(
                self::TABLE_NAME, 
                array(
                    'id' => $terminal->id,
                    'organization_id' => $terminal->organizationId,
                    'name' => $terminal->name,
                    'address' => $terminal->address,
                    'created' => $terminal->created->format('U'),
                )
            );
        }
    }

    /** @param Terminal[] $terminalList */
    public function saveAll($terminalList)
    {
        foreach ($terminalList as $terminal) {
            $this->save($terminal);
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
            SettingsBuilder::fromJson(__DIR__.'/TerminalTable.json')
        );
    }
}
