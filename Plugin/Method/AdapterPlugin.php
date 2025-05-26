<?php

namespace Fintecture\HyvaPayment\Plugin\Method;

use Fintecture\HyvaPayment\Gateway\Config\Config;
use Magento\Payment\Model\Method\Adapter;

class AdapterPlugin
{
    protected Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param Adapter $subject
     * @param string $result
     *
     * @return string
     */
    public function afterGetTitle(Adapter $subject, $result)
    {
        if ($subject->getCode() !== 'fintecture') {
            return $result;
        }

        $design = $this->config->getCheckoutDesign();

        if ($design === 'ist_long' || $design === 'ist_short') {
            $label = __('Secured wire transfer');
        } else {
            $label = __('Wire transfer');
        }

        return $label;
    }
}
