<?php

namespace Sysint\EmailFlow\Plugin;

use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Mail\TransportInterface;

use Sysint\EmailFlow\Model\Config\Source\FlowSendingMode;
use Sysint\EmailFlow\Model\Configuration;
use Sysint\EmailFlow\Mail\TransportFactory;
use Sysint\EmailFlow\Mail\TemplateFactory;
use Sysint\EmailFlow\Mail\TransportDecoratorFactory;

class TransportBuilderPlugin
{
    /** @var TransportFactory */
    private $transportFactory;

    /** @var TransportDecoratorFactory */
    private $transportDecoratorFactory;

    /** @var TemplateFactory */
    private $templateFactory;

    /** @var array */
    private $vars;

    /** @var string */
    private $templateIdentifier;

    /** @var array */
    private $templateOptions;

    /** @var Configuration */
    private $configuration;

    /**
     * @param TransportFactory $transport
     * @param TransportDecoratorFactory $transportDecoratorFactory
     * @param TemplateFactory $templateFactory
     * @param Configuration $configuration
     */
    public function __construct(
        TransportFactory $transport,
        TransportDecoratorFactory $transportDecoratorFactory,
        TemplateFactory $templateFactory,
        Configuration $configuration
    ) {
        $this->transportFactory = $transport;
        $this->transportDecoratorFactory = $transportDecoratorFactory;
        $this->templateFactory = $templateFactory;
        $this->configuration = $configuration;
    }

    /**
     * Create new transport if it's enabled
     * @param TransportBuilder $subject
     * @param callable $proceed
     * @return TransportInterface
     */
    public function aroundGetTransport(TransportBuilder $subject, callable $proceed): TransportInterface
    {
        /** @var TransportInterface $output */
        $output = $proceed();
        if ($this->configuration->isEnabled() === true) {
            $template = $this->templateFactory->create();
            $template->setVars($this->vars);
            $template->setTemplateId($this->templateIdentifier);
            $template->setTemplateOptions($this->templateOptions);

            $flowTransport = $this->transportFactory->create(
                ['message' => $output->getMessage(), 'template' => $template]
            );

            if ($this->configuration->getFlowSendingMode() === FlowSendingMode::MIXED) {
                return $this->transportDecoratorFactory->create(
                    ['originalTransport' => $output, 'flowTransport' => $flowTransport]
                );
            }

            return $flowTransport;
        }

        return $proceed();
    }

    /**
     * Get template vars
     * @param TransportBuilder $subject
     * @param $result
     * @param array $templateVars
     * @return mixed
     */
    public function afterSetTemplateVars(TransportBuilder $subject, $result, $templateVars)
    {
        $this->vars = $templateVars;
        return $result;
    }

    /**
     * Get template id
     * @param TransportBuilder $subject
     * @param $result
     * @param string $templateIdentifier
     * @return mixed
     */
    public function afterSetTemplateIdentifier(TransportBuilder $subject, $result, $templateIdentifier)
    {
        $this->templateIdentifier = $templateIdentifier;
        return $result;
    }

    /**
     * Get/Set template options
     * @param TransportBuilder $subject
     * @param $result
     * @param array $templateOptions
     * @return mixed
     */
    public function afterSetTemplateOptions(TransportBuilder $subject, $result, $templateOptions)
    {
        $this->templateOptions = $templateOptions;
        return $result;
    }
}
