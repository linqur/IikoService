<?php

namespace Linqur\IikoService\Api\Token;

use Linqur\Singleton\SingletonTrait;

class Token
{
    use SingletonTrait;

    const LIFE_LIMIT = 3600;

    private $token;
    /** @var \DateTimeInterface */
    private $createdTime;
    
    /**
     * Получить токен
     * 
     * @return string
     */
    public function get()
    {
        if (!$this->token) {
            $this->setToken();
        }

        if ($this->needToUpdate()) {
            $this->createNewToken();
        }

        return $this->token;
    }

    /**
     * Получить новый токен
     * 
     * @return string
     */
    public function getNew()
    {
        $this->createNewToken();
        return $this->get();
    }

    private function needToUpdate()
    {
        return $this->createdTime->format('U') + self::LIFE_LIMIT < date('U');
    }

    private function setToken()
    {
        $this->setFromRepository();

        if (!$this->token) $this->createNewToken();
    }

    private function setFromRepository()
    {
        $repository = new Repository();
        
        $this->token = $repository->getToken();

        if ($this->token) $this->createdTime = $repository->getCreated();
    }
    

    private function createNewToken()
    {
        $creator = new Creator();

        $this->token = $creator->getToken();
        $this->createdTime = $creator->getCreatedTime();

        if ($this->token) {
            (new Repository())->save($this->token, $this->createdTime);
        }
    }
}