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

class BarzahlenCreatePaymentTest extends PHPUnit_Framework_TestCase
{
    private $transactionRepository;
    private $apiFactory;
    private $requestFactory;
    private $modelCheckoutOrder;
    private $api;
    private $request;
    private $order;
    private $config;
    private $session;

    public function setUp()
    {
        $this->transactionRepository = $this->getMock("BarzahlenTransactionRepository", array("createTransaction"), array(), "", false);
        $this->apiFactory = $this->getMock("BarzahlenApiFactory", array("create"), array(), "", false);
        $this->requestFactory = $this->getMock("BarzahlenRequestFactory", array("createPaymentRequest"), array(), "", false);
        $this->api = $this->getMock("Barzahlen_Api", array("setDebug", "handleRequest"), array(), "", false);
        $this->request = $this->getMock("Barzahlen_Request_Refund", array("getTransactionId", "getInfotext1", "getInfotext2"), array(), "", false);
        $this->modelCheckoutOrder = $this->getMock("ModelCheckoutOrder", array("confirm"), array(), "", false);

        $this->apiFactory
            ->expects($this->any())
            ->method("create")
            ->will($this->returnValue($this->api));

        $this->requestFactory
            ->expects($this->any())
            ->method("createPaymentRequest")
            ->will($this->returnValue($this->request));

        $this->order = array(
            'order_id' => 11,
            'total' => "100.00",
            'currency_value' => "1.00",
            'currency_code' => "EUR",
        );
        $this->config = $this->getMock("Config", array("get"), array(), "", false);
        $this->session = new StdClass();
        $this->session->data = array();
    }

    public function createPaymentCreate()
    {
        return new BarzahlenCreatePayment($this->transactionRepository, $this->apiFactory, $this->requestFactory, $this->modelCheckoutOrder);
    }

    public function testRequestWillBeSentToBarzahlenApi()
    {
        $this->api
            ->expects($this->once())
            ->method("handleRequest")
            ->with($this->request);

        $createPayment = $this->createPaymentCreate();
        $createPayment->create($this->order, $this->config, $this->session);
    }

    public function testOrderWillBeUpdated()
    {
        $statusId = 123;

        $this->config
            ->expects($this->any())
            ->method("get")
            ->will($this->returnValue($statusId));

        $this->modelCheckoutOrder
            ->expects($this->once())
            ->method("confirm")
            ->with($this->order['order_id'], $statusId);

        $createPayment = $this->createPaymentCreate();
        $createPayment->create($this->order, $this->config, $this->session);
    }

    public function testDatabaseEntryWillBeCreated()
    {
        $transactionId = 456;

        $this->request
            ->expects($this->any())
            ->method("getTransactionId")
            ->will($this->returnValue($transactionId));

        $this->transactionRepository
            ->expects($this->any())
            ->method("createTransaction")
            ->with($this->order['order_id'], $transactionId);

        $createPayment = $this->createPaymentCreate();
        $createPayment->create($this->order, $this->config, $this->session);
    }

    public function testSessionWillBeUpdatedWithInfotext1()
    {
        $infotext1 = "asdfsd";

        $this->request
            ->expects($this->any())
            ->method("getInfotext1")
            ->will($this->returnValue($infotext1));

        $createPayment = $this->createPaymentCreate();
        $createPayment->create($this->order, $this->config, $this->session);

        $this->assertEquals($infotext1, $this->session->data['barzahlen_infotext1']);
    }

    public function testSessionWillBeUpdatedWithInfotext2()
    {
        $infotext2 = "foobartest";

        $this->request
            ->expects($this->any())
            ->method("getInfotext2")
            ->will($this->returnValue($infotext2));

        $createPayment = $this->createPaymentCreate();
        $createPayment->create($this->order, $this->config, $this->session);

        $this->assertEquals($infotext2, $this->session->data['barzahlen_infotext2']);
    }
}
