<?php

namespace Linqur\IikoService\Api\Request;

class RequestBody
{
    private $headers = array();
    private $post = array();
    private $get = array();

    /**
     * Установить ссылку запроса
     * 
     * @param string $url
     * 
     * @return static
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Установить заголовки запроса
     * 
     * @param array|string $headers
     * 
     * @return static
     */
    public function addHeaders($headers)
    {
        $headers = is_array($headers) ? $headers : array($headers);
        $this->headers = array_merge($this->headers, $headers);
        return $this;
    }
    
    /**
     * Установить GET параметры
     * 
     * @param string $key ключ парметра
     * @param string $value значение парметра
     * 
     * @return static
     */
    public function addGet($key, $value)
    {
        $this->get[$key] = $value;
        return $this;
    }

    /**
     * Установить POST параметры
     * 
     * @param string $key ключ парметра
     * @param string $value значение парметра
     * 
     * @return static
     */
    public function addPost($key, $value)
    {
        $this->post[$key] = $value;
        return $this;
    }
    
    public function getUrl()
    {
        return $this->getUrlWithGets();
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getPost()
    {
        return $this->post;
    }

    private function getUrlWithGets()
    {
        $url = $this->url;

        if (!empty($this->get)) {
            $url .= strpos($url, '?') !== false ? '&' : '?';
            $url .= http_build_query($this->get, '', '&');
        }

        return $url;
    }
}