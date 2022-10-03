<?php

namespace Linqur\IikoService\Entity\PaymentType;

use Linqur\IikoService\Entity\Repository\Repository as IikoServiceRepository;
use Linqur\IikoService\Entity\Repository\System\Repository as SystemRepository;
use Linqur\IikoService\Entity\Repository\TableCreator\SettingsBuilder;

class Repository
{
    const TABLE_NAME = 'Payment_Type';
    const ALL_UPDATED_SYSTEM_FIELD = 'payment_type_all_updated';

    /** @return PaymentType|null */
    public function getById($id)
    {
        if (!IikoServiceRepository::getInstance()->isOn() || !$this->isTableExists()) {
            return null;
        }
        
        $row = IikoServiceRepository::getInstance()->getRow(self::TABLE_NAME, ['id' => $id]);

        return $row ? Builder::byRepository($row) : null;
    }

    /** @return PaymentType[] */
    public function getAll()
    {
        if (!IikoServiceRepository::getInstance()->isOn() || !$this->isTableExists()) {
            return array();
        }

        $rows = IikoServiceRepository::getInstance()->getRows(self::TABLE_NAME) ?: array();

        $list = array();
        foreach ($rows as $row) {
            $list[] = Builder::byRepository($row);
        }

        return $list;
    }

    /** @return \DateTimeInterface|null */
    public function getAllLastUpdated()
    {
        if (!$lastUpdated = (new SystemRepository())->get(self::ALL_UPDATED_SYSTEM_FIELD)) {
            return null;
        }

        return (new \DateTime())->setTimestamp($lastUpdated);
    }

    /** @param PaymentType $terminal */
    public function save($paymentType)
    {
        if (!IikoServiceRepository::getInstance()->isOn()) return;

        if (!$this->isTableExists()) $this->createTable();

        if ($this->getById($paymentType->id)) {
            IikoServiceRepository::getInstance()->update(
                self::TABLE_NAME, 
                array(
                    'code' => $paymentType->code,
                    'name' => $paymentType->name,
                    'comment' => $paymentType->comment,
                    'combinable' => (int) $paymentType->combinable,
                    'external_revision' => (int) $paymentType->externalRevision,
                    'is_deleted' => (int) $paymentType->isDeleted,
                    'print_cheque' => (int) $paymentType->printCheque,
                    'payment_processing_type' => $paymentType->paymentProcessingType,
                    'payment_type_kind' => $paymentType->paymentTypeKind,
                    'created' => $paymentType->created->format('U'),
                ), 
                array('id' => $paymentType->id)
            );
        } else {
            IikoServiceRepository::getInstance()->insert(
                self::TABLE_NAME, 
                array(
                    'id' => $paymentType->id,
                    'code' => $paymentType->code,
                    'name' => $paymentType->name,
                    'comment' => $paymentType->comment,
                    'combinable' => (int) $paymentType->combinable,
                    'external_revision' => (int) $paymentType->externalRevision,
                    'is_deleted' => (int) $paymentType->isDeleted,
                    'print_cheque' => (int) $paymentType->printCheque,
                    'payment_processing_type' => $paymentType->paymentProcessingType,
                    'payment_type_kind' => $paymentType->paymentTypeKind,
                    'created' => $paymentType->created->format('U'),
                )
            );
        }
    }

    /** @param PaymentType[] $patmentTypeList */
    public function saveAll($patmentTypeList)
    {
        foreach ($patmentTypeList as $patmentType) {
            $this->save($patmentType);
        }

        (new SystemRepository())->set(self::ALL_UPDATED_SYSTEM_FIELD, date('U'));
    }

    public function deleteAll()
    {
        if (!IikoServiceRepository::getInstance()->isOn()) return;
        IikoServiceRepository::getInstance()->delete(self::TABLE_NAME);
    }

    private function isTableExists()
    {
        return IikoServiceRepository::getInstance()->isTableExists(self::TABLE_NAME);
    }

    private function createTable()
    {
        IikoServiceRepository::getInstance()->createTable(
            SettingsBuilder::fromJson(__DIR__.'/PaymentTypeTable.json')
        );
    }
}
