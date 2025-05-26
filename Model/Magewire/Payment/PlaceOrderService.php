<?php

namespace Fintecture\HyvaPayment\Model\Magewire\Payment;

use Hyva\Checkout\Model\Magewire\Payment\AbstractPlaceOrderService;
use Magento\Quote\Model\Quote;

class PlaceOrderService extends AbstractPlaceOrderService
{
    public function canPlaceOrder(): bool
    {
        return true;
    }

    public function getRedirectUrl(Quote $quote, ?int $orderId = null): string
    {
        return '/fintecture/checkout/index';
    }
}
