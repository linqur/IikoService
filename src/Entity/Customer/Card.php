<?php

namespace Linqur\IikoService\Entity\Customer;

class Card
{
    /** @var string */
    public $id;
    /** @var string */
    public $track;
    /** @var string */
    public $number;
    /** @var \DateTimeInterface */
    public $validToDate;
}