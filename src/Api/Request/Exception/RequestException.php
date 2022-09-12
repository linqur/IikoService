<?php

namespace Linqur\IikoService\Api\Request\Exception;

use Linqur\IikoService\Exception\IikoServiceException;

class RequestException extends IikoServiceException
{
    const DEAFULT_MESSAGE = 'Ошибка запроса в сервис iiko';
    const DEFAULT_CODE = 500;

    public function __construct($message = "", $code = 0, $previous = null)
    {
        parent::__construct($message ?: self::DEAFULT_MESSAGE, $code ?: self::DEFAULT_CODE, $previous);
    }
}
