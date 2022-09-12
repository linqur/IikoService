<?php

namespace Linqur\IikoService\Api\Request;

use Linqur\IikoService\Api\Request\Exception\RequestException;

class ResponseValidator
{
    /** @var Response */
    private $response;

    /** @param Response $response */
    public function __construct($response)
    {
        $this->response = $response;
    }

    /** 
     * Проверить ответ на ошибки
     * 
     * @throws RequestException
     * 
     * @return void
     */
    public function validate()
    {
        if ($this->response->getStatus() !== 200) {
            $errorText = !empty($this->response->getParsedBody()['errorDescription']) ? $this->response->getParsedBody()['errorDescription'] : '';
            throw new RequestException($errorText, $this->response->getStatus());
        }
    }
}