<?php

namespace Linqur\IikoService\Entity\Order;

class Item
{
    /** @var string */
    public $productId;
    /** @var float */
    public $price;
    /** @var string */
    public $positionId;
    /** @var string */
    public $type = "Product";
    /** @var float */
    public $amount;
    
    /** НЕ ИСПОЛЬЗУЮТСЯ */
    private $modifiers;
    private $productSizeId;
    private $comboInformation;
    private $comment;
}
