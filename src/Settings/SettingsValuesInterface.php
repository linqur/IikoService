<?php

namespace Linqur\IikoService\Settings;

interface SettingsValuesInterface
{
    /**
     * Получить api логин
     * 
     * @return string
     */
    public function getApiLogin();

    /**
     * Получить доступ к базе данных
     * 
     * @return \nc_Db|null
     */
    public function getRepositoryConnect();

    /**
     * Получить префикс для таблиц библиотеки
     * 
     * @return string|null
     */
    public function getRepositoryPreffix();
}
