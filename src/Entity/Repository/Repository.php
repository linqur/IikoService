<?php

namespace Linqur\IikoService\Entity\Repository;

use Linqur\IikoService\Entity\Repository\TableCreator\Creator;
use Linqur\IikoService\Entity\Repository\TableCreator\Settings as TableCreatorSettings;
use Linqur\IikoService\Settings\Settings;
use Linqur\Singleton\SingletonTrait;

class Repository
{   
    use SingletonTrait;

    const PREFFIX_DEFAULT = 'Iiko_Service';

    private $db;
    
    /**
     * Репозиторий подключен
     * 
     * @return bool
     */
    public function isOn()
    {
        return !empty($this->db());
    }

    /**
     * Существует ли таблица
     * 
     * @param string $table
     * 
     * @return bool
     */
    public function isTableExists($tableName)
    {
        $result = $this->db()->get_var("SHOW TABLES LIKE '".$this->tableNamePrepare($tableName)."'");
        return !empty($result);
    }

    /**
     * Создать таблицу
     * 
     * @param TableCreatorSettings
     */
    public function createTable($settings)
    {
        foreach ((new Creator($settings))->getQueryes() as $query) {
            $this->db()->query($query);
        }
    }

    /**
     * Получить запись
     * 
     * @param string $tableName
     * @param array|null $where
     * 
     * @return object|null
     */
    public function getRow($tableName, $where)
    {
        $queryWhere = '';
        foreach ($where ?: array() as $whereKey => $whereValue) {
            $queryWhere .= $queryWhere ? ' AND ' : '';
            $queryWhere .= "`{$whereKey}` =  '{$whereValue}'";
        }
        $sql = "SELECT * FROM `{$tableName}`";
        $sql .= $queryWhere ? ' WHERE '.$queryWhere : '';

        return $this->db()->get_row($sql);
    }

    /** 
     * Получить преффикс
     * 
     * @return string 
     */
    public function getPreffix()
    {
        return Settings::getInstance()->getRepositoryPreffix() ?: self::PREFFIX_DEFAULT;
    }

    /**
     * Подготовить имя таблицы
     * 
     * @param string $tableName
     * 
     * @return string
     */
    public function tableNamePrepare($tableName)
    {
        return $this->getPreffix().'_'.$tableName;
    }

    /** @return \nc_Db */
    private function db()
    {
        if (!$this->db) {
            $this->db = Settings::getInstance()->getRepositoryConnect();
        }
        return $this->db;
    }    
}