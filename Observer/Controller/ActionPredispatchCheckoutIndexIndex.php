<?php

declare(strict_types=1);

namespace Fintecture\HyvaPayment\Observer\Controller;

use Fintecture\Config\Telemetry;
use Fintecture\HyvaPayment\Helper\Cookie as CookieHelper;
use Fintecture\HyvaPayment\Helper\Stats;
use Magento\Checkout\Model\Session;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class ActionPredispatchCheckoutIndexIndex implements ObserverInterface
{
    /** @var Stats */
    protected $stats;

    /** @var Session */
    protected $_checkoutSession;

    /** @var CookieHelper */
    protected $_cookieHelper;

    public function __construct(
        Stats $stats,
        Session $checkoutSession,
        CookieHelper $cookieHelper
    ) {
        $this->stats = $stats;
        $this->_checkoutSession = $checkoutSession;
        $this->_cookieHelper = $cookieHelper;
    }

    /**
     * Execute observer
     *
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(Observer $observer)
    {
        $quoteId = (int) $this->_checkoutSession->getQuote()->getId();
        $storedQuoteId = (int) $this->_cookieHelper->getCookie('fintecture-cartId');

        // Don't send the call several time for the same cart id
        if ($storedQuoteId && $quoteId === $storedQuoteId) {
            return;
        }

        $configurationSummary = $this->stats->getConfigurationSummary();
        try {
            Telemetry::logAction('checkout', $configurationSummary);
        } catch (\Exception $e) {
            // do nothing
        }

        $this->_cookieHelper->setCookie('fintecture-cartId', $quoteId, 3600 * 24 * 7);
    }
}
