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

class BarzahlenCreateRefundTest extends PHPUnit_Framework_TestCase
{
    private $transactionRepository;
    private $apiFactory;
    private $requestFactory;
    private $api;
    private $request;
    private $order;
    private $transaction;
    private $previousRefunds;
    private $amount;
    private $config;

    public function setUp()
    {
        $this->transactionRepository = $this->getMock("BarzahlenTransactionRepository", array("addRefund"), array(), "", false);
        $this->apiFactory = $this->getMock("BarzahlenApiFactory", array("create"), array(), "", false);
        $this->requestFactory = $this->getMock("BarzahlenRequestFactory", array("createRefundRequest"), array(), "", false);
        $this->api = $this->getMock("Barzahlen_Api", array("setDebug", "handleRequest"), array(), "", false);
        $this->request = $this->getMock("Barzahlen_Request_Refund", array("getRefundTransactionId"), array(), "", false);

        $this->apiFactory
            ->expects($this->any())
            ->method("create")
            ->will($this->returnValue($this->api));

        $this->requestFactory
            ->expects($this->any())
            ->method("createRefundRequest")
            ->will($this->returnValue($this->request));

        $this->order = array(
            'order_id' => 11,
            'total' => "100.00",
            'currency_value' => "1.00",
            'currency_code' => "EUR",
        );
        $this->transaction = array(
            'barzahlen_transaction_id' => 111,
        );
        $this->previousRefunds = array();
        $this->amount = "12.00";
        $this->config = $this->getMock("Config", array("get"), array(), "", false);
    }

    public function createRefundCreate()
    {
        return new BarzahlenCreateRefund($this->transactionRepository, $this->apiFactory, $this->requestFactory);
    }

    public function testRequestWillBeSentToBarzahlenApi()
    {
        $this->api
            ->expects($this->once())
            ->method("handleRequest")
            ->with($this->request);

        $createRefund = $this->createRefundCreate();
        $createRefund->create($this->order, $this->transaction, $this->previousRefunds, $this->amount, $this->config);
    }

    public function testDatabaseEntryWillBeCreated()
    {
        $this->api
            ->expects($this->once())
            ->method("handleRequest")
            ->with($this->request);

        $createRefund = $this->createRefundCreate();
        $createRefund->create($this->order, $this->transaction, $this->previousRefunds, $this->amount, $this->config);
    }

    public function testExceptionIsThrownWhenRefundAmountIsToLow()
    {
        $this->setExpectedException("RuntimeException");

        $createRefund = $this->createRefundCreate();
        $createRefund->create($this->order, $this->transaction, $this->previousRefunds, "-1.00", $this->config);
    }

    public function testExceptionIsThrownWhenRefundAmountIsToHigh()
    {
        $this->setExpectedException("RuntimeException");

        $createRefund = $this->createRefundCreate();
        $createRefund->create($this->order, $this->transaction, $this->previousRefunds, "101.00", $this->config);
    }

    public function testExceptionIsThrownWhenRefundAmountIsToHighWithExisitingRefunds()
    {
        $this->setExpectedException("RuntimeException");

        $this->previousRefunds = array(
            array(
                'amount' => "10.00"
            )
        );

        $createRefund = $this->createRefundCreate();
        $createRefund->create($this->order, $this->transaction, $this->previousRefunds, "91.00", $this->config);
    }
}
