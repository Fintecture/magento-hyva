<?php

namespace Fintecture\HyvaPayment\Magewire\Checkout\Payment;

use Fintecture\HyvaPayment\Gateway\Config\Config;
use Magento\Framework\Locale\Resolver;
use Magento\Framework\UrlInterface;
use Magewirephp\Magewire\Component;

class Fintecture extends Component
{
    public string $code = 'fintecture';

    protected UrlInterface $url;
    protected Config $config;
    protected Resolver $localeResolver;

    public function __construct(
        UrlInterface $url,
        Config $config,
        Resolver $localeResolver
    ) {
        $this->url = $url;
        $this->config = $config;
        $this->localeResolver = $localeResolver;
    }

    public function isActive(): bool
    {
        return $this->config->isActive();
    }

    public function getCheckoutDesign(): string
    {
        return $this->config->getCheckoutDesign();
    }

    public function getAssetsUrl(): string
    {
        return 'https://assets.fintecture.com/plugins/prestashop/1.7-8';
    }

    public function getCurrentLang(): string
    {
        $locale = $this->localeResolver->getLocale();

        return $locale === 'fr_FR' ? 'fr' : 'en';
    }
}
