<?php

namespace Sysint\EmailFlow\Adapter;

use Magento\Framework\HTTP\ClientInterface;
use Magento\Framework\Serialize\SerializerInterface;

use Sysint\EmailFlow\Adapter\ObjectMapper\ObjectMapperResolver;
use Sysint\EmailFlow\Model\Config\Source\Authentication;
use Sysint\EmailFlow\Model\Configuration;

use Psr\Log\LoggerInterface;

class Flow
{
    /** @var ClientInterface */
    private $client;

    /** @var ObjectMapperResolver */
    private $objectMapperResolver;

    /** @var SerializerInterface */
    private $json;

    /** @var Configuration */
    private $configuration;

    /** @var LoggerInterface */
    private $logger;

    /**
     * @param ClientInterface $client
     * @param ObjectMapperResolver $objectMapperResolver
     * @param Configuration $configuration
     * @param SerializerInterface $json
     * @param LoggerInterface $logger
     */
    public function __construct(
        ClientInterface $client,
        ObjectMapperResolver $objectMapperResolver,
        Configuration $configuration,
        SerializerInterface $json,
        LoggerInterface $logger
    ) {
        $this->client = $client;
        $this->objectMapperResolver = $objectMapperResolver;
        $this->configuration = $configuration;
        $this->json = $json;
        $this->logger = $logger;
    }

    /**
     * Push data to the flow
     * @param array $dataSet
     * @return void
     */
    public function push(array $dataSet): void
    {
        $uri  = $this->configuration->getWebHook();
        if (empty($uri) === false) {
            try {
                $data = $this->dataPreparation($dataSet);

                if ($this->isDataOptimizationEnabled() === true) {
                    $data = $this->dataOptimization($data);
                }

                $this->client->setHeaders(
                    [
                        'Content-Type' => 'application/json'
                    ]
                );
                $this->setAuth();
                $this->client->post($uri, $this->json->serialize($data));
                if ($this->configuration->canDebug()) {
                    $this->logger->debug($this->client->getBody());
                }
            } catch (\Exception $exception) {
                $this->logger->error($exception);
            }
        }
    }

    /**
     * If the data optimization enabled
     * @return bool
     */
    private function isDataOptimizationEnabled() : bool
    {
        return $this->configuration->isDataOptimizationEnabled();
    }

    /**
     * Set auth for the client
     * @return void
     */
    private function setAuth() : void
    {
        if ($this->configuration->getAuthentication() === Authentication::AUTH_TYPE_BASE) {
            $this->client->setCredentials(
                $this->configuration->getAuthenticationName(),
                $this->configuration->getAuthenticationValue()
            );
        }

        if ($this->configuration->getAuthentication() === Authentication::AUTH_TYPE_KEY) {
            $this->client->addHeader(
                $this->configuration->getAuthenticationName(),
                $this->configuration->getAuthenticationValue()
            );
        }
    }

    /**
     * Data Optimization
     * @param array $dataSet
     * @return array
     */
    private function dataOptimization(array &$dataSet) : array
    {
        foreach ($dataSet as $key => &$value) {
            if ($value === null || $value === '') {
                unset($dataSet[$key]);
            } elseif (is_array($value)) {
                $this->dataOptimization($value);
            }
        }

        return $dataSet;
    }

    /**
     * Data preparation
     * @param array $dataSet
     * @return array
     */
    private function dataPreparation(array &$dataSet) : array
    {
        foreach ($dataSet as &$value) {
            if (is_object($value)) {
                $value = $this->objectMapperResolver->getValues($value);
            } elseif (is_array($value)) {
                $this->dataPreparation($value);
            }
        }

        return $dataSet;
    }
}
