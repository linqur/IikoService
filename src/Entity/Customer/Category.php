<?php

namespace Linqur\IikoService\Entity\Customer;

class Category
{
    /** @var string */
    public $id;
    /** @var string */
    public $name;
    /** @var bool */
    public $isActive;
    /** @var bool */
    public $isDefaultForNewGuests;
}