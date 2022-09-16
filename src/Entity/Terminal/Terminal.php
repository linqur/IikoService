<?php

namespace Linqur\IikoService\Entity\Terminal;

class Terminal
{
    public $id;
    public $organizationId;
    public $name;
    public $address;
    /** @var \DateTimeInterface */
    public $created;
}
