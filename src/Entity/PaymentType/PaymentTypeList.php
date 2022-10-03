<?php

namespace Linqur\IikoService\Entity\PaymentType;

use Linqur\IikoService\Api\Api;
use Linqur\IikoService\Entity\Organization\OrganizationList;
use Linqur\Singleton\SingletonTrait;

class PaymentTypeList
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
     * @return PaymentType|null
     */
    public function getById($id)
    {
        if (!isset($this->list[$id])) {
            $this->setById($id);
        }

        return isset($this->list[$id]) ? $this->list[$id] : null;
    }

     /**
     * Получить все типы оплат
     * 
     * @return PaymentType[]
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
        $paymentType = $repository->getById($id);

        $needToUpdate = !$paymentType || $paymentType->createdTime->format('U') + self::TIME_UPDATE_LIMIT <= date('U');

        if ($needToUpdate && !$this->updated) {
            $this->update();
            $this->setById($id);
            return;
        }

        if ($paymentType) {
            $this->list[$paymentType->id] = $paymentType;
        }
    }

    private function setAll()
    {
        $repository = new Repository();
        $paymentTypeList = $repository->getAll();
        
        $lastUpdated = $repository->getAllLastUpdated();
        $needToUpdate = !$paymentTypeList || !$lastUpdated || $lastUpdated->format('U') + self::TIME_UPDATE_LIMIT <= date('U');

        if ($needToUpdate && !$this->updated) {
            $paymentTypeList = $this->update() ?: $paymentTypeList;
        }

        foreach ($paymentTypeList as $paymentType) {
            $this->list[$paymentType->id] = $paymentType;
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

        $paymentTypes = (new Api())->getPaymentTypes($organizationIds);

        $paymentTYpeList = array();
        if (!empty($paymentTypes['paymentTypes'])) {
            foreach ($paymentTypes['paymentTypes'] as $paymentType) {
                $paymentTYpeList[] = Builder::byResponse($paymentType);
            }
            $repository->saveAll($paymentTYpeList);
        }

        $this->updated = true;

        return $paymentTYpeList;
    }
}
