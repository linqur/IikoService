<?php

namespace Linqur\IikoService\Api\Request;

class Response
{
    /** @var string */
    private $response;
    private $responseInfo;

    /**
     * @param array $response
     * @param array $responseInfo
     */
    public function __construct($response, $responseInfo)
    {
        $this->response = $response;
        $this->responseInfo = $responseInfo;   
    }

    /** @return int */
    public function getStatus()
    {
        return $this->responseInfo['http_code'];
    }

    /** @return array */
    public function getParsedBody()
    {
        return json_decode($this->response, true);
    }
}