<?php

declare(strict_types=1);

namespace Fintecture\HyvaPayment\Helper;

use Magento\Framework\Stdlib\Cookie\CookieMetadataFactory;
use Magento\Framework\Stdlib\CookieManagerInterface;

class Cookie
{
    /**
     * @var CookieManagerInterface
     */
    private $cookieManager;

    /**
     * @var CookieMetadataFactory
     */
    private $cookieMetadataFactory;

    public function __construct(
        CookieManagerInterface $cookieManager,
        CookieMetadataFactory $cookieMetadataFactory
    ) {
        $this->cookieManager = $cookieManager;
        $this->cookieMetadataFactory = $cookieMetadataFactory;
    }

    /**
     * @param mixed $value Value
     */
    public function setCookie(string $name, $value, int $duration = 3600): void
    {
        $publicCookieMetadata = $this->cookieMetadataFactory->createPublicCookieMetadata();
        $publicCookieMetadata->setDuration($duration);
        $publicCookieMetadata->setPath('/');
        $publicCookieMetadata->setHttpOnly(true);

        $this->cookieManager->setPublicCookie($name, $value, $publicCookieMetadata);
    }

    public function getCookie(string $name): ?string
    {
        return $this->cookieManager->getCookie($name);
    }
}
