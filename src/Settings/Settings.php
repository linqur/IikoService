<?php

namespace Linqur\IikoService\Settings;

use Linqur\IikoService\Settings\Exception\SettingsNotSetException;
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
        $this->checkValues();
        return $this->values->getApiLogin();
    }

    public function getRepositoryConnect()
    {
        $this->checkValues();
        return $this->values->getRepositoryConnect();
    }

    public function getRepositoryPreffix()
    {
        $this->checkValues();
        return $this->values->getRepositoryPreffix();
    }

    private function checkValues()
    {
        if ($this->values instanceof SettingsValuesInterface) {
            return true;
        }

        throw new SettingsNotSetException();
    }
}
