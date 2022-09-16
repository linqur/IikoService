<?php

namespace Linqur\IikoService\Entity\Terminal;

use Linqur\IikoService\Api\Api;
use Linqur\IikoService\Entity\Organization\OrganizationList;
use Linqur\Singleton\SingletonTrait;

class TerminalList
{
    use SingletonTrait;

    const TIME_UPDATE_LIMIT = 86400;

    private $list;
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
            $this->update();   
            $this->setAll();         
            return;
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

        if (!empty($groups['terminalGroups'])) {
            $terminals = array();
            foreach ($groups['terminalGroups'] as $group) {
                foreach ($group['items'] as $item) {
                    $terminals[] = Builder::byResponse($item);
                }
            }
            $repository->saveAll($terminals);
        }

        $this->updated = true;
    }
}
