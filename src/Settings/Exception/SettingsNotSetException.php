<?php

namespace Linqur\IikoService\Settings\Exception;

use Linqur\IikoService\Exception\IikoServiceException;

class SettingsNotSetException extends IikoServiceException
{
    const MESSAGE = 'Не установлины настройки для Iiko';
    const CODE = 500;

    public function __construct()
    {
        parent::__construct(self::MESSAGE, self::CODE);
    }
}
