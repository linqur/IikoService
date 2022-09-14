<?php

namespace Linqur\IikoService;

use Linqur\IikoService\Entity\Organization\OrganizationList;
use Linqur\IikoService\Settings\Settings;
use Linqur\IikoService\Settings\SettingsValues;
use Linqur\IikoService\Settings\SettingsValuesInterface;
use Linqur\Singleton\SingletonTrait;

class IikoProvider
{
    use SingletonTrait;

    /**
     * Получить объект настроек
     * 
     * @return SettingsValues
     */
    public function getSettingsValues()
    {
        return new SettingsValues();
    }

    /**
     * Установить настройки
     * 
     * @param SettingsValuesInterface $settingsValues
     */
    public function setSettings($settingsValues)
    {
        Settings::getInstance()->setValues($settingsValues);
    }

    public function getOrganizationList()
    {
        return OrganizationList::getInstance();
    }
}