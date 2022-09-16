<?php 

namespace Linqur\IikoService\Api\Token;

use Linqur\IikoService\Entity\Repository\System\Repository as SystemRepository;

class Repository
{
    const REPOSITORY_FIELD_TOKEN = 'token';
    const REPOSITORY_FIELD_CREATED = 'token_created';

    private $token;
    /** @var \DateTimeInterface */
    private $created;

    private $isInit = false;

    /** @return string|null */
    public function getToken()
    {
        $this->init();
        return $this->token;
    }

    /** @return \DateTimeInterface|null */
    public function getCreated()
    {
        $this->init();
        return $this->created;
    }

    /**
     * Сохранить токен
     * 
     * @param string $token
     * @param \DateTimeInterface $created
     */
    public function save($token, $created)
    {
        $repository = new SystemRepository();

        $repository->set(self::REPOSITORY_FIELD_TOKEN, $token);
        $repository->set(self::REPOSITORY_FIELD_CREATED, $created->format('U'));
    }

    private function init()
    {   
        if ($this->isInit) return;

        $repository = new SystemRepository();

        $this->token = $repository->get(self::REPOSITORY_FIELD_TOKEN);

        if ($created = $repository->get(self::REPOSITORY_FIELD_CREATED)) {
            $this->created = (new \DateTime())->setTimestamp($created);
        }

        $this->isInit = true;
    }
}
