<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\PaymentRequest;

class PaymentGatewayClient
{
    private const API_URL = 'https://dev-api.rafinita.com/post';

    private string $publicKey;
    private string $secretKey;

    public function __construct(string $publicKey, string $secretKey)
    {
        $this->publicKey = $publicKey;
        $this->secretKey = $secretKey;
    }

    public function sale(PaymentRequest $request): array
    {
        $params = $this->buildParams($request);
        $params['hash'] = $this->generateHash($request->payerEmail, $request->cardNumber, $this->secretKey);
        $ch = curl_init(self::API_URL);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/x-www-form-urlencoded'
            ]
        ]);

        $response = curl_exec($ch);

        if (!$response) {
            return [
                'status' => 'declined',
                'message' => 'Gateway connection failed'
            ];
        }

        return json_decode($response, true) ?? [];
    }

    private function buildParams(PaymentRequest $request): array
    {
        return [
            'action' => 'SALE',
            'client_key' => $this->publicKey,

            'order_id' => $request->orderId,
            //'order_amount' => number_format($request->amount, 2, '.', ''),
            'order_amount' => $request->orderAmount,
            'order_currency' => $request->orderCurrency,
            //'order_description' => 'Product purchase',
            'order_description' => $request->orderDescription,

            'card_number' => $request->cardNumber,
            'card_exp_month' => $request->cardExpMonth,
            'card_exp_year' => $request->cardExpYear,
            'card_cvv2' => $request->cardCVV,

            'payer_first_name' => $request->payerFirstName,
            'payer_last_name' =>  $request->payerLastName,
            'payer_address' => $request->payerAddress,
            'payer_country' => $request->payerCountry,
            'payer_city' => $request->payerCity,
            'payer_zip' => $request->payerZip,
            'payer_email' => $request->payerEmail,
            'payer_phone' => $request->payerPhone,

            'payer_ip' => $request->payerIP,

            //'term_url_3ds' => 'https://frontend.com/checkout-complete' // Fake fronetnd return url
            'term_url_3ds' => $request->termUrl3ds,
        ];
    }

    // https://docs.rafinita.com/docs/guides/s2s_card#appendix-a-hash - formula 1 creation pattern
    function generateHash($email, $card_number, $password) {
        $revEmail = strrev($email);
        $cardPart = substr($card_number, 0, 6) . substr($card_number, -4);
        $revCard = strrev($cardPart);
        $combined = $revEmail . $password . $revCard;

        return md5(strtoupper($combined));
    }
}