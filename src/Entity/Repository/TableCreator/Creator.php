<?php

namespace Linqur\IikoService\Entity\Repository\TableCreator;

use Linqur\IikoService\Entity\Repository\Repository;

class Creator
{
    private $settings;

    /** @param Settings $settings */
    public function __construct($settings)
    {
        $this->settings = $settings;
    }

    /**
     * Получить sql запросы
     * 
     * @return string[]
     */
    public function getQueryes()
    {
        $tableName = Repository::getInstance()->tableNamePrepare($this->settings->tableName);
        $fields = '';
        foreach ($this->settings->fields as $field) {
            $fields .= $fields ? ',' : '';
            $fields .= "`{$field->name}`";
            $fields .= " ".$this->fieldTypeMap($field->type);
        }

        yield "CREATE TABLE `{$tableName}` ({$fields})";
        
        foreach ($this->settings->fields as $field) {
            if ($field->isIndex) {
                switch ($field->indexType) {
                    case 'primary':
                        yield "ALTER TABLE `{$tableName}` ADD PRIMARY KEY (`{$field->name}`)";
                        break;
                }
            }
        }
    }

    private function fieldTypeMap($type)
    {
        switch ($type) {
            case 'string': return 'varchar(255)';
        }
    }

}
