<?php

namespace Fintecture\HyvaPayment\Gateway;

use Fintecture\Api\ApiResponse;
use Fintecture\HyvaPayment\Gateway\Config\Config;
use Fintecture\HyvaPayment\Gateway\Http\Sdk;
use Fintecture\HyvaPayment\Helper\Fintecture as FintectureHelper;
use Fintecture\HyvaPayment\Logger\Logger;
use Fintecture\Util\Crypto;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Order;

class RequestToPay
{
    /** @var FintectureHelper */
    protected $fintectureHelper;

    /** @var Logger */
    protected $fintectureLogger;

    /** @var Sdk */
    protected $sdk;

    /** @var Config */
    protected $config;

    /** @var OrderRepositoryInterface */
    protected $orderRepository;

    public function __construct(
        FintectureHelper $fintectureHelper,
        Logger $fintectureLogger,
        Sdk $sdk,
        Config $config,
        OrderRepositoryInterface $orderRepository
    ) {
        $this->fintectureHelper = $fintectureHelper;
        $this->fintectureLogger = $fintectureLogger;
        $this->sdk = $sdk;
        $this->config = $config;
        $this->orderRepository = $orderRepository;
    }

    public function get(Order $order, array $data): ApiResponse
    {
        $pisToken = $this->sdk->pisClient->token->generate();
        if (!$pisToken->error) {
            $this->sdk->pisClient->setAccessToken($pisToken); // set token of PIS client
        } else {
            throw new \Exception($pisToken->errorMsg);
        }

        $state = Crypto::encodeToBase64(['order_id' => $order->getIncrementId()]);

        $apiResponse = $this->sdk->pisClient->requestToPay->generate($data, 'fr', null, $state);

        if ($apiResponse->error) {
            $this->fintectureLogger->error('RequestToPay session', [
                'message' => 'Error building RTP URL',
                'orderIncrementId' => $order->getIncrementId(),
                'response' => $apiResponse->errorMsg,
            ]);
            throw new \Exception($apiResponse->errorMsg);
        }

        $sessionId = $apiResponse->meta->session_id ?? '';
        $order->setExtOrderId($sessionId);
        $this->orderRepository->save($order);

        return $apiResponse;
    }
}
