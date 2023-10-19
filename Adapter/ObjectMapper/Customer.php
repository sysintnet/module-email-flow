<?php

namespace Sysint\EmailFlow\Adapter\ObjectMapper;

use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Model\Data\CustomerSecure;
use Magento\Framework\UrlInterface;

use Psr\Log\LoggerInterface;

class Customer implements ObjectMapperInterface
{
    /** @var UrlInterface */
    private $urlBuilder;

    /** @var AccountManagementInterface */
    private $accountManagement;

    /** @var LoggerInterface */
    private $logger;

    /**
     * @param UrlInterface $urlBuilder
     * @param AccountManagementInterface $accountManagement
     * @param LoggerInterface $logger
     */
    public function __construct(
        UrlInterface $urlBuilder,
        AccountManagementInterface $accountManagement,
        LoggerInterface $logger
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->accountManagement = $accountManagement;
        $this->logger = $logger;
    }

    /**
     * Return values for the object
     * @param mixed $object
     * @return array
     */
    public function getValues($object): array
    {
        if ($object instanceof CustomerSecure) {
            $customerId = $object->getData('id');
            $token = $object->getRpToken();
            $keys = [
                'id', 'group_id', 'created_at', 'updated_at',
                'created_in', 'email', 'firstname', 'lastname',
                'store_id', 'website_id'
            ];
            $values = $object->toArray($keys);
            try {
                if ($this->accountManagement->validateResetPasswordLinkToken($customerId, $token)) {
                    $resetLink = $this->urlBuilder->getUrl(
                        'customer/account/createPassword/',
                        [
                            '_query' => [
                                'id' => $object->getData('id') , 'token' => $object->getRpToken()
                            ], '_nosid' => 1
                        ]
                    );
                    $values['reset_link'] = $resetLink;
                }
            } catch (\Exception $exception) {
                $this->logger->error($exception);
            }

            return $values;
        }

        return [];
    }
}
