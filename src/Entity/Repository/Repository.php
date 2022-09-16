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
     * Вставка в таблицу
     * 
     * @param string $tableName
     * @param array $obj [field => value]
     */
    public function insert($tableName, $obj)
    {
        $fields = $values = '';
        foreach ($obj as $key => $val) {
            $fields .= $fields ? ',' : '';
            $fields .= "`{$key}`";

            $values .= $values ? ',' : '';
            $values .= "'{$val}'";
        }

        $tableName = $this->tableNamePrepare($tableName);

        $sql = "INSERT INTO `{$tableName}` ({$fields}) VALUES ({$values})";

        $this->db()->query($sql);
    }

    /**
     * Обновление записи в таблице
     * 
     * @param string $tableName
     * @param array $obj [field => value]
     * @param array|null $where
     */
    public function update($tableName, $obj, $where = null)
    {
        $set = '';

        foreach ($obj as $key => $val) {
            $set .= $set ? ',' : '';
            $set .= "`{$key}` = '{$val}'";
        }

        $tableName = $this->tableNamePrepare($tableName);

        $sql = "UPDATE `{$tableName}` SET {$set}";
        
        if (!empty($where)) $sql .= ' WHERE '.$this->wherePrepare($where);

        $this->db()->query($sql);
    }

    /**
     * Получить запись
     * 
     * @param string $tableName
     * @param array|null $where
     * 
     * @return object|null
     */
    public function getRow($tableName, $where = array())
    {
        $sql = "SELECT * FROM `".$this->tableNamePrepare($tableName)."`";

        if (!empty($where)) $sql .= ' WHERE '.$this->wherePrepare($where);
        
        return $this->db()->get_row($sql);
    }

    /**
     * Получить запись
     * 
     * @param string $tableName
     * @param array|null $where
     * 
     * @return array|null
     */
    public function getRows($tableName, $where = array())
    {
        $sql = "SELECT * FROM `".$this->tableNamePrepare($tableName)."`";

        if (!empty($where)) $sql .= ' WHERE '.$this->wherePrepare($where);
        
        return $this->db()->get_results($sql);
    }
    
    /**
     * Удалить записи
     * 
     * @param string $tableName
     * @param array|null $where
     */
    public function delete($tableName, $where = array())
    {
        $tableName = $this->tableNamePrepare($tableName);

        $sql = "DELETE FROM `{$tableName}`";
        if ($where) $sql .= " WHERE ".$this->wherePrepare($where);

        $this->db()->query($sql);
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

    /** @var array $where */
    private function wherePrepare($where)
    {
        $query = '';
        foreach ($where as $key => $value) {
            $query .= $query ? ' AND ' : '';
            $query .= "`{$key}` =  '{$value}'";
        }
        return $query;
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