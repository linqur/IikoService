<?php

namespace Linqur\IikoService\Entity\Delivery\OrderType;

class OrderType
{
    public $id;
    public $organizationId;
    public $name;
    public $orderServiceType;
    /** @var \DateTimeInterface */
    public $created;
}
