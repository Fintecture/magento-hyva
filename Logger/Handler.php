<?php

declare(strict_types=1);

namespace Fintecture\HyvaPayment\Logger;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger as MonoLogger;

class Handler extends Base
{
    protected $loggerType = MonoLogger::DEBUG;
    protected $fileName = '/var/log/fintecture.log';
}
