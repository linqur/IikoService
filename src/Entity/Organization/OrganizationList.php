<?php

namespace Linqur\IikoService\Entity\Organization;

use Linqur\IikoService\Api\Api;
use Linqur\Singleton\SingletonTrait;

class OrganizationList
{
    use SingletonTrait;

    const TIME_UPDATE_LIMIT = 86400;

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
            $this->setOrganization($id);
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
    private function setOrganization($id)
    {
        $repository = new Repository();
        $organization = $repository->getById($id);

        do {
            $needToUpdate = !$organization || $organization->createdTime->format('U') + self::TIME_UPDATE_LIMIT <= date('U');

            if (!$needToUpdate) break;
            
            $responseBody = (new Api())->getOrganizations(array($id));

            if (empty($responseBody['organizations'][0])) break;

            $organization = Builder::byResponse($responseBody['organizations'][0]);

            $repository->save($organization);
        } while(false);

        if ($organization) {
            $this->list[$organization->id] = $organization;
        }
    }

    private function setAll()
    {
        $repository = new Repository();
        $organizationList = $repository->getAll();

        do {
            $lastUpdated = $repository->getAllLastUpdated();
            $needToUpdate = !$organizationList || !$lastUpdated || $lastUpdated->format('U') + self::TIME_UPDATE_LIMIT <= date('U');

            if (!$needToUpdate) break;
            
            $responseBody = (new Api())->getOrganizations();

            if (empty($responseBody['organizations'])) break;

            $repository->deleteAll();

            $organizationList = array();
            foreach ($responseBody['organizations'] as $organization) {
                $organizationList[] = Builder::byResponse($organization);
            }

            $repository->saveAll($organizationList);
        } while(false);

        if ($organizationList) {
            foreach ($organizationList as $organization) {
                $this->list[$organization->id] = $organization;
            }
        }
    }
}
