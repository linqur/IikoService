<?php

namespace Linqur\IikoService\Api\Request;

use Linqur\IikoService\Api\Request\Exception\RequestException;
use Linqur\IikoService\Api\Token\Token;
use Linqur\IikoService\Entity\Order\Order;
use Linqur\IikoService\Settings\Settings;

class Request
{   
    const API_URL = 'https://api-ru.iiko.services/api/1/';
    
    private $repeatRequest = false;

    /**
     * Создать токен
     * 
     * @return string
     */
    public function getToken()
    {
        $body = $this
            ->getBody()
            ->setUrl(self::API_URL.'access_token')
            ->addHeaders('Content-Type: application/json')
            ->addPost('apiLogin', Settings::getInstance()->getApiLogin())
        ;
        
        return $this->handle($body);
    }

    /**
     * Получить список организаций
     * 
     * @param array|null $organizationIds Идентификаторы организаций, которые необходимо вернуть. По умолчанию - все организации
     * @param bool $returnAdditionalInfo Признак, следует ли возвращать дополнительную информацию об организации
     * @param bool $includeDisabled Возвращать отключенные организации
     * 
     * @return array
     */
    public function getOrganizations($organizationIds = null, $returnAdditionalInfo = true, $includeDisabled = true)
    {
        $body = $this
            ->getBody()
            ->setUrl(self::API_URL.'organizations')
            ->addHeaders('Content-Type: application/json')
            ->addHeaders('Authorization: Bearer '.Token::getInstance()->get())
            ->addPost('organizationIds', $organizationIds)
            ->addPost('returnAdditionalInfo', $returnAdditionalInfo)
            ->addPost('includeDisabled', $includeDisabled)
        ;

        try {
            $response = $this->handle($body);
        } catch (RequestException $e) {
            if ($e->getCode() === 401 && !$this->repeatRequest) {
                $this->repeatRequest = true;
                Token::getInstance()->getNew();
                return $this->getOrganizations($organizationIds, $returnAdditionalInfo, $includeDisabled);
            }
            throw $e;
        }

        return $response;
    }

    /**
     * Получить группы терминалов
     * 
     * @param array $organizationIds 
     * @param bool $includeDisabled
     * 
     * @return array|null
     */
    public function getTerminalGroups($organizationIds, $includeDisabled = true)
    {
        $body = $this
            ->getBody()
            ->setUrl(self::API_URL.'terminal_groups')
            ->addHeaders('Content-Type: application/json')
            ->addHeaders('Authorization: Bearer '.Token::getInstance()->get())
            ->addPost('organizationIds', $organizationIds)
            ->addPost('includeDisabled', $includeDisabled)
        ;

        try {
            $response = $this->handle($body);
        } catch (RequestException $e) {
            if ($e->getCode() === 401 && !$this->repeatRequest) {
                $this->repeatRequest = true;
                Token::getInstance()->getNew();
                return $this->getTerminalGroups($organizationIds, $includeDisabled);
            }
            throw $e;
        }
        
        return $response;
    }

    /**
     * Получить нуменклатуру организации
     * 
     * Если передать версию ревизии, то ответ вернется только в том случае,
     * если есть более новая ревизия
     * 
     * @param string $organizationId 
     * @param int $startRevision версия ревизии
     * 
     * @return array|null
     */
    public function getNumenclature($organizationId, $startRevision = 0)
    {
        $body = $this
            ->getBody()
            ->setUrl(self::API_URL.'nomenclature')
            ->addHeaders('Content-Type: application/json')
            ->addHeaders('Authorization: Bearer '.Token::getInstance()->get())
            ->addPost('organizationId', $organizationId)
            ->addPost('startRevision', $startRevision)
        ;
        
        try {
            $response = $this->handle($body);
        } catch (RequestException $e) {
            if ($e->getCode() === 401 && !$this->repeatRequest) {
                $this->repeatRequest = true;
                Token::getInstance()->getNew();
                return $this->getNumenclature($organizationId, $startRevision);
            }
            throw $e;
        }

        return $response;
    }

    /** 
     * Получить список типов оплат
     * 
     * @param array $organizationIds;
     * 
     * @return array|null
     */
    public function getPaymentTypes($organizationIds)
    {
        $body = $this
            ->getBody()
            ->setUrl(self::API_URL.'payment_types')
            ->addHeaders('Content-Type: application/json')
            ->addHeaders('Authorization: Bearer '.Token::getInstance()->get())
            ->addPost('organizationIds', $organizationIds)
        ;

        try {
            $response = $this->handle($body);
        } catch (RequestException $e) {
            if ($e->getCode() === 401 && !$this->repeatRequest) {
                $this->repeatRequest = true;
                Token::getInstance()->getNew();
                return $this->getPaymentTypes($organizationIds);
            }
            throw $e;
        }
        
        return $response;
    }
    
    /**
     * Получить список типов заказа
     * 
     * @param array $organizationId
     * 
     * @return array
     */
    public function getOrderTypes($organizationIds)
    {
        $body = $this
            ->getBody()
            ->setUrl(self::API_URL.'deliveries/order_types')
            ->addHeaders('Content-Type: application/json')
            ->addHeaders('Authorization: Bearer '.Token::getInstance()->get())
            ->addPost('organizationIds', $organizationIds)
        ;

        try {
            $response = $this->handle($body);
        } catch (RequestException $e) {
            if ($e->getCode() === 401 && !$this->repeatRequest) {
                $this->repeatRequest = true;
                Token::getInstance()->getNew();
                return $this->getOrderTypes($organizationIds);
            }
            throw $e;
        }
        
        return $response;
    }

    /**
     * Создать заказ
     * 
     * @param string $organizationId
     * @param string $terminalGroupId
     * @param array $order
     * 
     * @return array
     */
    public function deliveryOrderCreate($organizationId, $terminalGroupId, $order)
    {
        $body = $this
            ->getBody()
            ->setUrl(self::API_URL.'deliveries/create')
            ->addHeaders('Content-Type: application/json')
            ->addHeaders('Authorization: Bearer '.Token::getInstance()->get())
            ->addPost('organizationId', $organizationId)
            ->addPost('terminalGroupId', $terminalGroupId)
            ->addPost('order', $order)
        ;

        try {
            $response = $this->handle($body);
        } catch (RequestException $e) {
            if ($e->getCode() === 401 && !$this->repeatRequest) {
                $this->repeatRequest = true;
                Token::getInstance()->getNew();
                return $this->deliveryOrderCreate($organizationId, $terminalGroupId, $order);
            }
            throw $e;
        }
        
        return $response;

    }

    /**
     * Получить список Городов
     * 
     * @param array $organizationId
     * 
     * @return array
     */
    public function getCities($organizationIds)
    {
        $body = $this
            ->getBody()
            ->setUrl(self::API_URL.'cities')
            ->addHeaders('Content-Type: application/json')
            ->addHeaders('Authorization: Bearer '.Token::getInstance()->get())
            ->addPost('organizationIds', $organizationIds)
        ;

        try {
            $response = $this->handle($body);
        } catch (RequestException $e) {
            if ($e->getCode() === 401 && !$this->repeatRequest) {
                $this->repeatRequest = true;
                Token::getInstance()->getNew();
                return $this->getCities($organizationIds);
            }
            throw $e;
        }
        
        return $response;
    }
    
    /**
     * Получить список Улиц города
     * 
     * @param string $organizationId
     * @param string $cityId
     * 
     * @return array
     */
    public function getStreets($organizationId, $cityId)
    {
        $body = $this
            ->getBody()
            ->setUrl(self::API_URL.'streets/by_city')
            ->addHeaders('Content-Type: application/json')
            ->addHeaders('Authorization: Bearer '.Token::getInstance()->get())
            ->addPost('organizationId', $organizationId)
            ->addPost('cityId', $cityId)
        ;

        try {
            $response = $this->handle($body);
        } catch (RequestException $e) {
            if ($e->getCode() === 401 && !$this->repeatRequest) {
                $this->repeatRequest = true;
                Token::getInstance()->getNew();
                return $this->getStreets($organizationId, $cityId);
            }
            throw $e;
        }
        
        return $response;
    }
    
    /**
     * Получить заказы
     * 
     * 
     * @param array $organizationIds
     * @param array|null $orderIds
     * @param array|null $sourceKeys
     * @param array|null $posOrderIds
     * 
     * @return array
     */
    public function getOrder($organizationIds, $orderIds = null, $sourceKeys = null, $posOrderIds = null)
    {
        $body = $this
            ->getBody()
            ->setUrl(self::API_URL.'order/by_id')
            ->addHeaders('Content-Type: application/json')
            ->addHeaders('Authorization: Bearer '.Token::getInstance()->get())
            ->addPost('organizationIds', $organizationIds)
            ->addPost('orderIds', $orderIds)
            ->addPost('sourceKeys', $sourceKeys)
            ->addPost('posOrderIds', $posOrderIds)
        ;

        try {
            $response = $this->handle($body);
        } catch (RequestException $e) {
            if ($e->getCode() === 401 && !$this->repeatRequest) {
                $this->repeatRequest = true;
                Token::getInstance()->getNew();
                return $this->getOrder($organizationIds, $orderIds, $sourceKeys, $posOrderIds);
            }
            throw $e;
        }
        
        return $response;
    }

    /** @return RequestBody */
    private function getBody()
    {
        return new RequestBody();
    }

    /** 
     * @param RequestBody $body  
     * 
     * @return Response
     */
    private function handle($body)
    {
        $response = (new RequestHandler($body))->run();

        (new ResponseValidator($response))->validate();

        return $response->getParsedBody();
    }
}