<?php

namespace Linqur\IikoService\Entity\Organization;

use Linqur\Singleton\SingletonTrait;

class OrganizationList
{
    use SingletonTrait;

    private $list;
    private $initAll = false;
    /**
     * Получить по id в системе IIKO
     * 
     * @param string $id
     * 
     * @return Organization|null
     */
    public function getById($id)
    {
        if (!isset($this->list[$id])) {
            $this->setOrganizationById($id);
        }

        return isset($this->list[$id]) ? $this->list[$id] : null;
    }

    /**
     * Получить все организации
     * 
     * @return Organization[]
     */
    public function getAll()
    {
        if (!$this->initAll) {
            $this->setAll();
            $this->initAll = true;
        }
        return $this->list;
    }

    /**
     * Установить организацию
     * 
     * @param string $id
     * 
     * @return void
     */
    private function setOrganizationById($id)
    {
    }

    private function setAll()
    {
                
    }
}
