<?php
namespace Alvor\Shop\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

class Config extends AbstractHelper
{

    public function __construct(
        Context $context
    ) {
        $this->scopeConfig = $context->getScopeConfig();
        parent::__construct($context);
    }

    public function getSmsTemplate(): string
    {
        return $this->scopeConfig->getValue('customer_confirmation/templates/sms_template');
    }


}
