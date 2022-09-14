<?php

namespace Linqur\IikoService\Entity\Organization;

use Linqur\IikoService\Entity\Repository\Repository as IikoServiceRepository;

class Repository
{
    const TABLE_NAME = 'Organization';

    public function getById($id)
    {
        if (
            !IikoServiceRepository::getInstance()->isOn()
            || !$this->isTableExists()
        ) return null;
        
        $row = IikoServiceRepository::getInstance()->getRow(self::TABLE_NAME, ['id' => $id]);

        return $row ? Builder::byRepository($row) : null;
    }

    private function isTableExists()
    {
        return IikoServiceRepository::getInstance()->isTableExists(self::TABLE_NAME);
    }
}
