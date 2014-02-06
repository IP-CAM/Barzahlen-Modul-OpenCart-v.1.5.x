<?php

/**
 * Barzahlen Payment Module for OpenCart
 * Copyright (C) 2013 Zerebro Internet GmbH (http://www.barzahlen.de)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @category   ZerebroInternet
 * @package    ZerebroInternet_Barzahlen
 * @copyright  Copyright (C) 2013 Zerebro Internet GmbH (http://www.barzahlen.de)
 * @author     Mathias Hertlein
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt GNU General Public License
 */

class BarzahlenRequestFactoryTest extends PHPUnit_Framework_TestCase
{
    private $order;
    private $refund;
    private $transactionId;

    protected function setUp()
    {
        $this->order = array(
            'email' => "barzahlen@example.com",
            'payment_address_1' => "Street 11",
            'payment_postcode' => "12345",
            'payment_city' => "Test City",
            'payment_iso_code_2' => "DE",
            'total' => "10.0050",
            'currency_value' => "0.9",
            'currency_code' => "EUR",
            'order_id' => "1337",
        );

        $this->refund = array(
            'transaction_id' => 123,
            'amount' => "10.0050",
            'currency' => "10.0050",
            'currency_value' => "0.9",
        );
        $this->transactionId = 123;
    }

    private function createRequestFactory()
    {
        return new BarzahlenRequestFactory();
    }

    public function testCreatePaymentRequestReturnsCorrectType()
    {
        $requestFactory = $this->createRequestFactory();
        $request = $requestFactory->createPaymentRequest($this->order);

        $this->assertInstanceOf("Barzahlen_Request_Payment", $request);
    }

    public function testCreatePaymentRequestAmountIsCorrect()
    {
        $requestFactory = $this->createRequestFactory();
        $request = $requestFactory->createPaymentRequest($this->order);

        $this->assertAttributeEquals("9.00", "_amount", $request);
    }

    public function testCreateRefundRequestReturnsCorrectType()
    {
        $requestFactory = $this->createRequestFactory();
        $request = $requestFactory->createRefundRequest($this->refund);

        $this->assertInstanceOf("Barzahlen_Request_Refund", $request);
    }

    public function testCreateRefundRequestAmountIsCorrect()
    {
        $requestFactory = $this->createRequestFactory();
        $request = $requestFactory->createRefundRequest($this->refund);

        $this->assertAttributeEquals("9.00", "_amount", $request);
    }

    public function testCreateResendEmailRequestReturnsCorrectType()
    {
        $requestFactory = $this->createRequestFactory();
        $request = $requestFactory->createResendEmailRequest($this->transactionId);

        $this->assertInstanceOf("Barzahlen_Request_Resend", $request);
    }

    public function testCreateResendEmailRequestAmountIsCorrect()
    {
        $requestFactory = $this->createRequestFactory();
        $request = $requestFactory->createResendEmailRequest($this->transactionId);

        $this->assertAttributeEquals($this->transactionId, "_transactionId", $request);
    }

    public function testCreateCancelRequestReturnsCorrectType()
    {
        $requestFactory = $this->createRequestFactory();
        $request = $requestFactory->createCancelRequest($this->transactionId);

        $this->assertInstanceOf("Barzahlen_Request_Cancel", $request);
    }

    public function testCreateCancelRequestAmountIsCorrect()
    {
        $requestFactory = $this->createRequestFactory();
        $request = $requestFactory->createCancelRequest($this->transactionId);

        $this->assertAttributeEquals($this->transactionId, "_transactionId", $request);
    }
}
