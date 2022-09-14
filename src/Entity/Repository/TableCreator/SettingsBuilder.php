<?php

namespace Linqur\IikoService\Entity\Repository\TableCreator;

class SettingsBuilder
{
    public static function fromJson($path)
    {
        $settings = new Settings();
        
        $data = json_decode(file_get_contents($path));

        $settings->tableName = $data->table_name;

        foreach ($data->fields as $field) {
            $fieldObj = new Field();
            $fieldObj->name = $field->name;
            $fieldObj->type = $field->type;

            if ($fieldObj->isIndex = $field->is_index) {
                $fieldObj->indexType = $field->index_type;
            }

            $settings->fields[] = $fieldObj;
        }

        return $settings;
    }
}