<?php

namespace Linqur\IikoService\Api\Request;

use Linqur\IikoService\Api\Token\Token;
use Linqur\IikoService\Settings\Settings;

class Request
{   
    const API_URL = 'https://api-ru.iiko.services/api/1/';

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
            // ->addHeaders('Authorization: Bearer '.Token::getInstance()->get())
            ->addPost('organizationIds', $organizationIds)
            ->addPost('returnAdditionalInfo', $returnAdditionalInfo)
            ->addPost('includeDisabled', $includeDisabled)
        ;

        return json_decode('{
            "correlationId": "48fb4cd3-2ef6-4479-bea1-7c92721b988c",
            "organizations": [
              {
                "responseType": "string",
                "id": "497f6eca-6276-4993-bfeb-53cbbbba6f08",
                "name": "string"
              }
            ]
          }', true);
        return $this->handle($body);
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
            // ->addHeaders('Authorization: Bearer '.Token::getInstance()->get())
            ->addPost('organizationIds', $organizationIds)
            ->addPost('includeDisabled', $includeDisabled)
        ;

        return json_decode('{
            "correlationId": "48fb4cd3-2ef6-4479-bea1-7c92721b988c",
            "terminalGroups": [
              {
                "organizationId": "7bc05553-4b68-44e8-b7bc-37be63c6d9e9",
                "items": [
                  {
                    "id": "497f6eca-6276-4993-bfeb-53cbbbba6f08",
                    "organizationId": "7bc05553-4b68-44e8-b7bc-37be63c6d9e9",
                    "name": "string",
                    "address": "string"
                  }
                ]
              }
            ]
          }', true);

        return $this->handle($body);
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
            // ->addHeaders('Authorization: Bearer '.Token::getInstance()->get())
            ->addPost('organizationId', $organizationId)
            ->addPost('startRevision', $startRevision)
        ;

        return json_decode('{
            "correlationId": "48fb4cd3-2ef6-4479-bea1-7c92721b988c",
            "groups": [
              {
                "imageLinks": [
                  "string"
                ],
                "parentGroup": "258adf23-5b0c-4f5d-8998-e5cc7a8451dd",
                "order": 0,
                "isIncludedInMenu": true,
                "isGroupModifier": true,
                "id": "497f6eca-6276-4993-bfeb-53cbbbba6f08",
                "code": "string",
                "name": "string",
                "description": "string",
                "additionalInfo": "string",
                "tags": [
                  "string"
                ],
                "isDeleted": true,
                "seoDescription": "string",
                "seoText": "string",
                "seoKeywords": "string",
                "seoTitle": "string"
              }
            ],
            "productCategories": [
              {
                "id": "497f6eca-6276-4993-bfeb-53cbbbba6f08",
                "name": "string",
                "isDeleted": true
              }
            ],
            "products": [
              {
                "fatAmount": 0,
                "proteinsAmount": 0,
                "carbohydratesAmount": 0,
                "energyAmount": 0,
                "fatFullAmount": 0,
                "proteinsFullAmount": 0,
                "carbohydratesFullAmount": 0,
                "energyFullAmount": 0,
                "weight": 0,
                "groupId": "eb54e96e-21b8-4f54-9cd4-80fccbd06f55",
                "productCategoryId": "1e32231d-b8a1-4145-b539-820301c2af64",
                "type": "string",
                "orderItemType": "Product",
                "modifierSchemaId": "51a77930-ad82-4138-b68f-0d444ed97b5f",
                "modifierSchemaName": "string",
                "splittable": true,
                "measureUnit": "string",
                "sizePrices": [
                  {
                    "sizeId": "f98600f7-1d0f-4a64-936e-93e133055658",
                    "price": {
                      "currentPrice": 0,
                      "isIncludedInMenu": true,
                      "nextPrice": 0,
                      "nextIncludedInMenu": true,
                      "nextDatePrice": "2019-08-24 14:15:22.123"
                    }
                  }
                ],
                "modifiers": [
                  {
                    "id": "497f6eca-6276-4993-bfeb-53cbbbba6f08",
                    "defaultAmount": 0,
                    "minAmount": 0,
                    "maxAmount": 0,
                    "required": true,
                    "hideIfDefaultAmount": true,
                    "splittable": true,
                    "freeOfChargeAmount": 0
                  }
                ],
                "groupModifiers": [
                  {
                    "id": "497f6eca-6276-4993-bfeb-53cbbbba6f08",
                    "minAmount": 0,
                    "maxAmount": 0,
                    "required": true,
                    "childModifiersHaveMinMaxRestrictions": true,
                    "childModifiers": [
                      {
                        "id": "497f6eca-6276-4993-bfeb-53cbbbba6f08",
                        "defaultAmount": 0,
                        "minAmount": 0,
                        "maxAmount": 0,
                        "required": true,
                        "hideIfDefaultAmount": true,
                        "splittable": true,
                        "freeOfChargeAmount": 0
                      }
                    ],
                    "hideIfDefaultAmount": true,
                    "defaultAmount": 0,
                    "splittable": true,
                    "freeOfChargeAmount": 0
                  }
                ],
                "imageLinks": [
                  "string"
                ],
                "doNotPrintInCheque": true,
                "parentGroup": "258adf23-5b0c-4f5d-8998-e5cc7a8451dd",
                "order": 0,
                "fullNameEnglish": "string",
                "useBalanceForSell": true,
                "canSetOpenPrice": true,
                "id": "497f6eca-6276-4993-bfeb-53cbbbba6f08",
                "code": "string",
                "name": "string",
                "description": "string",
                "additionalInfo": "string",
                "tags": [
                  "string"
                ],
                "isDeleted": true,
                "seoDescription": "string",
                "seoText": "string",
                "seoKeywords": "string",
                "seoTitle": "string"
              }
            ],
            "sizes": [
              {
                "id": "497f6eca-6276-4993-bfeb-53cbbbba6f08",
                "name": "string",
                "priority": 0,
                "isDefault": true
              }
            ],
            "revision": 0
          }', true);

        return $this->handle($body);
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