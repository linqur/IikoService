<?php

namespace Linqur\IikoService\Entity\Order;

use Linqur\IikoService\Entity\Customer\Customer;

class Order
{
    /** @var string id в системе iiko */
    public $id;
    /** @var string номер заказа в интернет-магазине */
    public $externalNumber;
    
    /** @var Customer */
    public $customer;
    /** @var string */
    public $phone;
    /** @var array */
    public $guests;
    /** @var Item[] */
    public $items;
    /** @var Payment[] */
    public $payments;

    /** НЕ ИСПОЛЬЗУЮТСЯ */
    private $tableIds;
    private $tabName;
    private $combos;
    private $tips;
    private $sourceKey;
    private $discountsInfo;
    private $iikoCard5Info;
    private $orderTypeId;
}
