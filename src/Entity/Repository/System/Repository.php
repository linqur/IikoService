<?php

namespace Linqur\IikoService\Entity\Repository\System;

use Linqur\IikoService\Entity\Repository\Repository as IikoServiceRepository;
use Linqur\IikoService\Entity\Repository\TableCreator\SettingsBuilder;

class Repository
{
    const TABLE_NAME = 'System';

    /**
     * Получить значение
     * 
     * @param string $key
     * 
     * @return string|null|bool
     */
    public function get($key)
    {
        if (!IikoServiceRepository::getInstance()->isOn() || !$this->isTableExists()) {
            return null;
        }

        $row = IikoServiceRepository::getInstance()->getRow(self::TABLE_NAME, array('key' => $key));

        return empty($row) ? false : $row['value'];
    }

    public function set($key, $value)
    {
        if (!IikoServiceRepository::getInstance()->isOn()) return;

        if (!$this->isTableExists()) $this->createTable();

        if ($this->get($key) === false) {
            IikoServiceRepository::getInstance()
                ->insert(self::TABLE_NAME, array('key' => $key, 'value' => $value))
            ;
        } else {
            IikoServiceRepository::getInstance()
                ->update(self::TABLE_NAME, array('value' => $value), array('key' => $key))
            ;
        }

    }

    private function isTableExists()
    {
        return IikoServiceRepository::getInstance()->isTableExists(self::TABLE_NAME);
    }

    private function createTable()
    {
        IikoServiceRepository::getInstance()->createTable(
            SettingsBuilder::fromJson(__DIR__ . '/SystemTable.json')
        );
    }
}
