<?php

namespace Linqur\IikoService\Api\Token;

use Linqur\IikoService\Api\Request\Request;

class Creator
{
    private $created = false;

    private $token;
    /** @var \DateTimeInterface */
    private $createdTime;

    /** @return string */
    public function getToken()
    {
        if (!$this->created) $this->create();

        return $this->token;
    }

    /** @return \DateTimeInterface */
    public function getCreatedTime()
    {
        if (!$this->created) $this->create();

        return $this->createdTime;
    }

    private function create()
    {
        $response = (new Request())->getToken();

        $this->token = $response['token'];
        $this->createdTime = new \DateTimeImmutable('now');
        $this->created = true;
    }
}