<?php

namespace Linqur\IikoService\Entity\Terminal;

use Linqur\IikoService\Api\Api;
use Linqur\IikoService\Entity\Organization\OrganizationList;
use Linqur\Singleton\SingletonTrait;

class TerminalList
{
    use SingletonTrait;

    const TIME_UPDATE_LIMIT = 86400;

    private $list = array();
    private $initAll = false;
    private $updated = false;
    
    /**
     * Получить по id в системе IIKO
     * 
     * @param string $id
     * 
     * @return Terminal|null
     */
    public function getById($id)
    {
        if (!isset($this->list[$id])) {
            $this->setById($id);
        }

        return isset($this->list[$id]) ? $this->list[$id] : null;
    }

    /**
     * Получить список терминалов в id организации
     * 
     * @param string $organizationId
     * 
     * @return Terminal[]
     */
    public function getByOrganizationId($organizationId)
    {
        $result = array();

        foreach ($this->getAll() as $terminal)
        {
            if ($terminal->organizationId == $organizationId) {
                $result[] = $terminal; 
            }
        }

        return $result;
    }

    /**
     * Получить все организации
     * 
     * @return Terminal[]
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
    private function setById($id)
    {
        $repository = new Repository();
        $terminal = $repository->getById($id);

        $needToUpdate = !$terminal || $terminal->createdTime->format('U') + self::TIME_UPDATE_LIMIT <= date('U');

        if ($needToUpdate && !$this->updated) {
            $this->update();
            $this->setById($id);
            return;
        }

        if ($terminal) {
            $this->list[$terminal->id] = $terminal;
        }
    }

    private function setAll()
    {
        $repository = new Repository();
        $terminalList = $repository->getAll();

        $lastUpdated = $repository->getAllLastUpdated();
        $needToUpdate = !$terminalList || !$lastUpdated || $lastUpdated->format('U') + self::TIME_UPDATE_LIMIT <= date('U');

        if ($needToUpdate && !$this->updated) {
            $terminalList = $this->update() ?: $terminalList;
        }

        foreach ($terminalList as $terminal) {
            $this->list[$terminal->id] = $terminal;
        }
    }

    private function update()
    {
        $repository = new Repository();

        $repository->deleteAll();

        $organizationIds = array();
        foreach(OrganizationList::getInstance()->getAll() as $organization) {
            $organizationIds[] = $organization->id;
        }

        $groups = (new Api())->getTerminalGroups($organizationIds);
        
        $terminals = array();
        if (!empty($groups['terminalGroups'])) {
            foreach ($groups['terminalGroups'] as $group) {
                foreach ($group['items'] as $item) {
                    $terminals[] = Builder::byResponse($item);
                }
            }
            $repository->saveAll($terminals);
        }

        $this->updated = true;

        return $terminals;
    }
}
