<?php

namespace Sysint\EmailFlow\Mail;

class Template
{
    /** @var array */
    private $vars = [];

    /** @var string */
    private $templateIdentifier = '';

    /** @var array */
    private $templateOptions = [];

    /**
     * Set template options
     * @param array $options
     * @return $this
     */
    public function setTemplateOptions(array $options) : self
    {
        $this->templateOptions = $options;
        return $this;
    }

    /**
     * Get template options
     * @return array
     */
    public function getTemplateOptions() : array
    {
        return $this->templateOptions;
    }

    /**
     * Set template id
     * @param string $templateId
     * @return $this
     */
    public function setTemplateId(string $templateId) : self
    {
        $this->templateIdentifier = $templateId;
        return $this;
    }

    /**
     * Returns template id
     * @return string
     */
    public function getTemplateId() : string
    {
        return $this->templateIdentifier;
    }

    /**
     * Set template vars
     * @param array $vars
     * @return $this
     */
    public function setVars(array $vars) : self
    {
        $this->vars = $vars;
        return $this;
    }

    /**
     * Returns template vars
     * @return array
     */
    public function getVars() : array
    {
        return $this->vars;
    }
}
