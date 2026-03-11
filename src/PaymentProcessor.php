<?php

declare(strict_types=1);

namespace App;

use App\DTO\PaymentRequest;
use App\DTO\ProcessingResult;
use App\Entity\Payment;
use App\Registry\PaymentHandlerRegistry;
use App\Services\PaymentGatewayClient;

class PaymentProcessor
{
    private PaymentHandlerRegistry $registry;
    private PaymentGatewayClient $client;

    public function __construct(PaymentHandlerRegistry $registry, )
    {
        $this->registry = $registry;

        $this->client = new PaymentGatewayClient(
            '5b6492f0-f8f5-11ea-976a-0242c0a85007',
            'd0ec0beca8a3c30652746925d5380cf3'
        );
    }

    public function process(Payment $payment, array $rawData): ProcessingResult
    {
        $request = new PaymentRequest($rawData);

        $response = $this->client->sale($request);

        $status = $response['status'] ?? 'declined';

        $handler = $this->registry->getHandler($status);

        if (!$handler) {
            return new ProcessingResult('declined', 'Unknown payment status');
        }

        return $handler->handle($payment, $response);
    }
}