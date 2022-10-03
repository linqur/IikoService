<?php

namespace Linqur\IikoService\Entity\PaymentType;

class Builder
{
    public static function byRepository($row)
    {
        return self::build(
            $row->id, 
            $row->code,
            $row->name, 
            $row->comment,
            (bool) $row->combinable,
            (int) $row->external_revision,
            (bool) $row->is_deleted,
            (bool) $row->print_cheque,
            $row->payment_processing_type,
            $row->payment_type_kind,
            (new \DateTime())->setTimestamp($row->created)
        );
    }

    public static function byResponse($body)
    {
        return self::build(
            $body['id'], 
            $body['code'],
            $body['name'], 
            $body['comment'],
            (bool) $body['combinable'],
            (int) $body['externalRevision'],
            (bool) $body['isDeleted'],
            (bool) $body['printCheque'],
            $body['paymentProcessingType'],
            $body['paymentTypeKind'],            
            new \DateTime('now')
        );
    }

    private static function build($id, $code, $name, $comment, $combinable, $externalRevision, $isDeleted, $printCheque, $paymentProcessingType, $paymentTypeKind, $created)
    {
        $paymentType = new PaymentType();

        $paymentType->id = $id;
        $paymentType->code = $code;
        $paymentType->name = $name;
        $paymentType->comment = $comment;
        $paymentType->combinable = $combinable;
        $paymentType->externalRevision = $externalRevision;
        $paymentType->isDeleted = $isDeleted;
        $paymentType->printCheque = $printCheque;
        $paymentType->paymentProcessingType = $paymentProcessingType;
        $paymentType->paymentTypeKind = $paymentTypeKind;
        $paymentType->created = $created;

        return $paymentType;
    }
}