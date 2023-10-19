<?php

namespace Sysint\EmailFlow\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Encryption\EncryptorInterface;

use Sysint\EmailFlow\Model\Config\Source\Authentication;

class Configuration
{
    /** @var ScopeConfigInterface */
    private $scopeConfig;

    /** @var EncryptorInterface */
    private $encryptor;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param EncryptorInterface $encryptor
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        EncryptorInterface $encryptor
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->encryptor = $encryptor;
    }

    /**
     * Is enabled
     * @return bool
     */
    public function isEnabled() : bool
    {
        return $this->scopeConfig->isSetFlag('system/email_flow/enable', ScopeInterface::SCOPE_STORE);
    }

    /**
     * Is data optimization enabled
     * @return bool
     */
    public function isDataOptimizationEnabled() : bool
    {
        return $this->scopeConfig->isSetFlag('system/email_flow/data_optimization_enable', ScopeInterface::SCOPE_STORE);
    }

    /**
     * Debugging
     * @return bool
     */
    public function canDebug() : bool
    {
        return $this->scopeConfig->isSetFlag('system/email_flow/debug', ScopeInterface::SCOPE_STORE);
    }

    /**
     * Returns WebHook
     * @return string
     */
    public function getWebHook() : string
    {
        return trim($this->scopeConfig->getValue('system/email_flow/web_hook', ScopeInterface::SCOPE_STORE));
    }

    /**
     * Authentication type
     * @return int
     */
    public function getAuthentication() : int
    {
        return (int)$this->scopeConfig->getValue('system/email_flow/authentication', ScopeInterface::SCOPE_STORE);
    }

    /**
     * Authentication key/username
     * @return string
     */
    public function getAuthenticationName() : string
    {
        $path = '';
        if ($this->getAuthentication() === Authentication::AUTH_TYPE_BASE) {
            $path = 'system/email_flow/authentication_basic_name';
        }

        if ($this->getAuthentication() === Authentication::AUTH_TYPE_KEY) {
            $path = 'system/email_flow/authentication_key_name';
        }

        if ($path !== '') {
            return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE);
        }

        return $path;
    }

    /**
     * Authentication key/username
     * @return string
     */
    public function getAuthenticationValue() : string
    {
        $path = '';
        if ($this->getAuthentication() === Authentication::AUTH_TYPE_BASE) {
            $path = 'system/email_flow/authentication_basic_value';
        }

        if ($this->getAuthentication() === Authentication::AUTH_TYPE_KEY) {
            $path = 'system/email_flow/authentication_key_value';
        }

        if ($path !== '') {
            return $this->encryptor->decrypt($this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE));
        }

        return $path;
    }
}
