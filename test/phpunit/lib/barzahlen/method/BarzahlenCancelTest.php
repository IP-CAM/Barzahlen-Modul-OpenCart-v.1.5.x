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

class BarzahlenCancelTest extends PHPUnit_Framework_TestCase
{
    private $apiFactory;
    private $requestFactory;
    private $api;
    private $request;
    private $transactionId;
    private $config;

    public function setUp()
    {
        $this->apiFactory = $this->getMock("BarzahlenApiFactory", array("create"), array(), "", false);
        $this->requestFactory = $this->getMock("BarzahlenRequestFactory", array("createCancelRequest"), array(), "", false);
        $this->api = $this->getMock("Barzahlen_Api", array("setDebug", "handleRequest"), array(), "", false);
        $this->request = $this->getMock("Barzahlen_Request_Cancel", array(), array(), "", false);

        $this->apiFactory
            ->expects($this->any())
            ->method("create")
            ->will($this->returnValue($this->api));

        $this->requestFactory
            ->expects($this->any())
            ->method("createCancelRequest")
            ->will($this->returnValue($this->request));

        $this->transaction = 123;
        $this->config = $this->getMock("Config", array("get"), array(), "", false);
    }

    public function createRefundCreate()
    {
        return new BarzahlenCancel($this->apiFactory, $this->requestFactory);
    }

    public function testRequestWillBeSentToBarzahlenApi()
    {
        $this->api
            ->expects($this->once())
            ->method("handleRequest")
            ->with($this->request);

        $createRefund = $this->createRefundCreate();
        $createRefund->cancel($this->transactionId, $this->config);
    }
}
