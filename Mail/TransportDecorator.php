<?php

namespace Sysint\EmailFlow\Mail;

use Magento\Framework\Exception\MailException;
use Magento\Framework\Mail\MessageInterface;
use Magento\Framework\Mail\TransportInterface;

class TransportDecorator implements TransportInterface
{
    /** @var TransportInterface */
    private $originalTransport;

    /** @var TransportInterface */
    private $flowTransport;

    /**
     * @param TransportInterface $originalTransport
     * @param TransportInterface $flowTransport
     */
    public function __construct(
        TransportInterface $originalTransport,
        TransportInterface $flowTransport
    ) {
        $this->originalTransport = $originalTransport;
        $this->flowTransport = $flowTransport;
    }

    /**
     * Send a mail using this transport
     *
     * @return void
     * @throws MailException
     */
    public function sendMessage()
    {
        $this->originalTransport->sendMessage();
        $this->flowTransport->sendMessage();
    }

    /**
     * Get message
     *
     * @return MessageInterface
     * @since 101.0.0
     */
    public function getMessage() : MessageInterface
    {
        return $this->originalTransport->getMessage();
    }
}
