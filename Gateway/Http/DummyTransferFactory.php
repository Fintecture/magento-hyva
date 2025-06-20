<?php

namespace Fintecture\HyvaPayment\Gateway\Http;

use Magento\Payment\Gateway\Http\TransferBuilder;
use Magento\Payment\Gateway\Http\TransferFactoryInterface;
use Magento\Payment\Gateway\Http\TransferInterface;

class DummyTransferFactory implements TransferFactoryInterface
{
    /**
     * @var TransferBuilder
     */
    private $transferBuilder;

    /**
     * @param TransferBuilder $transferBuilder
     */
    public function __construct(
        TransferBuilder $transferBuilder
    ) {
        $this->transferBuilder = $transferBuilder;
    }

    /**
     * This is the place where the transfer objects for the the Payment Gateway
     * API requests are created. As we are a Redirect-based gateway and only used
     * the "initialize" method, we don't place API invocations or requests to the
     * Payment Gateway, so we don't need a transfer object.
     * TODO: check how to get rid of this, as the following error is raised
     * when not setting a transferFactory:
     * [Payment/Model/Method/Adapter][executeCommand]ERROR: Cannot instantiate
     * interface Magento\Payment\Gateway\Http\TransferFactoryInterface.
     * Builds gateway transfer object
     *
     * @param array $request
     *
     * @return TransferInterface
     */
    public function create(array $request)
    {
        return $this->transferBuilder
            ->setBody($request)
            ->setMethod('POST')
            ->build();
    }
}
