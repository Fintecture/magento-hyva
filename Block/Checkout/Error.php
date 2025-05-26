<?php

namespace Fintecture\HyvaPayment\Block\Checkout;

use Magento\Framework\App\Request\Http;
use Magento\Framework\View\Element\Template;

class Error extends Template
{
    /** @var Http */
    protected $request;

    public function __construct(
        Template\Context $context,
        Http $request,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->request = $request;
    }

    public function getPaymentStatus(): string
    {
        return $this->request->getParam('status', '');
    }
}
