<?php

namespace Linqur\IikoService\Api\Request;

class RequestHandler
{
    /** @var RequestBody */
    private $requestBody;

    /** @param RequestBody $requestBody */
    public function __construct($requestBody)
    {
        $this->requestBody = $requestBody;
    }

    /** @return Response */
    public function run()
    {
        $response = $this
            ->curlCreate()
            ->curlPrepare()
            ->curlHandle()
        ;

        return $response;
    }

    private function curlCreate()
    {
        $this->curl = curl_init();
        return $this;
    }

    private function curlPrepare()
    {
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($this->curl, CURLOPT_TIMEOUT, 30);

        $this
            ->curlSetUrl($this->requestBody->getUrl())
            ->curlSetHeaders($this->requestBody->getHeaders())
            ->curlSetPost($this->requestBody->getPost())
        ;

        return $this;
    }

    private function curlSetUrl($url)
    {
        curl_setopt($this->curl, CURLOPT_URL, $url);
        return $this;
    }

    private function curlSetHeaders($headers)
    {
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
        return $this;
    }

    private function curlSetPost($post)
    {
        if ($post) {
            curl_setopt($this->curl, CURLOPT_POST, 1);
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($post));
        }

        return $this;
    }

    /** @return Response */
    private function curlHandle()
    {        
        $response = new Response(curl_exec($this->curl), curl_getinfo($this->curl));
        $this->curlClose();

        return $response;
    }

    private function curlClose()
    {
        curl_close($this->curl);
    }
}
