<?php

namespace Linqur\IikoService\Settings;

use Linqur\Singleton\SingletonTrait;

class Settings
{
    use SingletonTrait;
    /** @var SettingsValuesInterface */
    private $values;

    /** @param SettingsValuesInterface $values */
    public function setValues($values)
    {
        $this->values = $values;
    }

    public function getApiLogin()
    {
        return $this->values->getApiLogin();
    }
}
