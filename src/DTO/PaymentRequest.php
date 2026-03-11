<?php

declare(strict_types=1);

namespace App\DTO;

class PaymentRequest
{
    public string $orderId;
    public string $orderAmount;
    public string $orderCurrency;
    public string $orderDescription;
    public string $cardNumber;
    public string $cardExpMonth;
    public string $cardExpYear;
    public string $cardCVV;
    public string $payerFirstName;
    public string $payerLastName;
    public string $payerAddress;
    public string $payerCountry;
    public string $payerCity;
    public string $payerZip;
    public string $payerEmail;
    public string $payerPhone;
    public string $payerIP;
    public string $termUrl3ds;

    public function __construct(array $data)
    {
        $this->orderId = $data['orderId'];
        $this->orderAmount = $data['orderAmount'];
        $this->orderCurrency = $data['orderCurrency'];
        $this->orderDescription = $data['orderDescription'];

        $this->cardNumber = $data['cardNumber'];
        $this->cardExpMonth = $data['cardExpMonth'];
        $this->cardExpYear = $data['cardExpYear'];
        $this->cardCVV = $data['cardCVV'];

        $this->payerFirstName = $data['payerFirstName'];
        $this->payerLastName = $data['payerLastName'];
        $this->payerAddress = $data['payerAddress'];
        $this->payerCountry = $data['payerCountry'];
        $this->payerCity = $data['payerCity'];
        $this->payerZip = $data['payerZip'];
        $this->payerEmail = $data['payerEmail'];
        $this->payerPhone = $data['payerPhone'];
        $this->payerIP = $data['payerIP'];

        $this->termUrl3ds = $data['termUrl3ds'];
    }
}