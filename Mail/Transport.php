<?php

namespace Sysint\EmailFlow\Mail;

use Laminas\Mail\Message;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Exception\MailException;
use Magento\Framework\Mail\MessageInterface;
use Magento\Framework\Mail\TransportInterface;

use Sysint\EmailFlow\Adapter\Flow;

use Psr\Log\LoggerInterface;

class Transport implements TransportInterface
{
    /** @var MessageInterface */
    private $message;

    /** @var Template  */
    private $template;

    /** @var LoggerInterface */
    private $logger;

    /** @var Flow */
    private $flow;

    /**
     * @param MessageInterface $message
     * @param Template $template
     * @param LoggerInterface|null $logger
     * @param Flow|null $flow
     */
    public function __construct(
        MessageInterface $message,
        Template $template,
        LoggerInterface $logger = null,
        Flow $flow = null
    ) {
        $this->message = $message;
        $this->template = $template;
        $this->logger = $logger ?: ObjectManager::getInstance()->get(LoggerInterface::class);
        $this->flow = $flow ?: ObjectManager::getInstance()->create(Flow::class);
    }

    /**
     * Send a mail using this transport
     *
     * @return void
     * @throws MailException
     */
    public function sendMessage(): void
    {
        try {
            $laminasMessage = Message::fromString($this->message->getRawMessage())->setEncoding('utf-8');
            $addressList = $laminasMessage->getTo();
            $addressList->rewind();
            $message = [
                'variables' => $this->template->getVars(),
                'template_id' => $this->template->getTemplateId(),
                'template_options' => $this->template->getTemplateOptions(),
                'to' => $addressList->current()->getEmail()
            ];

            $this->flow->push($message);
        } catch (\Exception $exception) {
            $this->logger->error($exception);
        }
    }

    /**
     * Get message
     *
     * @return MessageInterface
     * @since 101.0.0
     */
    public function getMessage() : MessageInterface
    {
        return $this->message;
    }
}
