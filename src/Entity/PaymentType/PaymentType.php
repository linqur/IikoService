<?php

namespace Linqur\IikoService\Entity\PaymentType;

class PaymentType
{
    const PAYMENT_TYPE_UNKNOWN = 'Unknown';
    const PAYMENT_TYPE_CASH = 'Cash';
    const PAYMENT_TYPE_CARD = 'Card';
    const PAYMENT_TYPE_CREDIT = 'Credit';
    const PAYMENT_TYPE_WRITEOFF = 'Writeoff';
    const PAYMENT_TYPE_VOUCHER = 'Voucher';
    const PAYMENT_TYPE_EXTERNAL = 'External';
    const PAYMENT_TYPE_IIKO_CARD = 'IikoCard';

    /** @var string */
    public $id;
    /** @var string */
    public $code;
    /** @var string */
    public $name;
    /** @var string */
    public $comment;
    /** @var bool */
    public $combinable;
    /** @var int */
    public $externalRevision;
    /** @var bool */
    public $isDeleted;
    /** @var bool */
    public $printCheque;
    /** @var string */
    public $paymentProcessingType;
    /** @var string */
    public $paymentTypeKind;
    /** @var \DateTimeInterface */
    public $created;

    private $applicableMarketingCampaigns;
    private $terminalGroups;
}