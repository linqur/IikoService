<?php

namespace Linqur\IikoService\Entity\Order;

class Payment
{
    /** @var string */
    public $paymentTypeKind;
    /** @var float */
    public $sum;
    /** @var string */
    public $paymentTypeId;

    /** НЕ ИСПОЛЬЗУЮТСЯ */
    private $isProcessedExternally;
    private $paymentAdditionalData;
    private $isFiscalizedExternally;
}
