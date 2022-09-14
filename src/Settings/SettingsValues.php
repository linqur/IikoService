<?php

namespace Linqur\IikoService\Settings;

class SettingsValues implements SettingsValuesInterface
{
    private $apiLogin;
    private $repositoryConnect;
    private $repositoryPreffx;

    /**
     * Установить API логин
     * 
     * @param string $apiLogin
     * 
     * @return static
     */
    public function setApiLogin($apiLogin)
    {
        $this->apiLogin = $apiLogin;
        return $this;
    }

    public function getApiLogin()
    {
        return $this->apiLogin;
    }

    /**
     * Установить Коннект с хронилищем
     * 
     * @param \nc_Db $connect
     * 
     * @return static
     */
    public function setRepositoryConnect($connect)
    {
        $this->repositoryConnect = $connect;
        return $this;
    }

    public function getRepositoryConnect()
    {
        return $this->repositoryConnect;
    }

    /**
     * Установить преффикс таблиц хранилища
     * 
     * @param string $preffix
     * 
     * @return static
     */
    public function setRepositoryPreffix($preffix)
    {
        $this->repositoryPreffx;
        return $this;
    }

    public function getRepositoryPreffix()
    {
        return $this->repositoryPreffx;
    }
}