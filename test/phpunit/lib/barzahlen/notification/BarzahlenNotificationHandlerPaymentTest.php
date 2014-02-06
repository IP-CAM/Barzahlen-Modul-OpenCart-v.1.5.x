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

class BarzahlenNotificationHandlerPaymentTest extends PHPUnit_Framework_TestCase
{
    private $validator;
    private $statusUpdater;

    private $config = array(
        'test' => 333,
    );
    private $order = array(
        'order_id' => 123,
    );
    private $state = "fooo";
    private $requestData = array(
        'foo' => 123,
        'bar' => 456
    );

    protected function setUp()
    {
        $this->validator = $this->getMock("BarzahlenNotificationValidator", array("validate"), array(), "", false);
        $this->statusUpdater = $this->getMock("BarzahlenOrderStatusUpdater", array("update"), array(), "", false);
    }

    private function createNotificationHandler()
    {
        return new BarzahlenNotificationHandlerPayment($this->validator, $this->statusUpdater);
    }

    public function testIfValidatorWillBeCalledWithCorrectParameters()
    {
        $this->validator
            ->expects($this->once())
            ->method('validate')
            ->with($this->equalTo($this->config), $this->equalTo($this->order), $this->equalTo($this->requestData));

        $notificationHandler = $this->createNotificationHandler();
        $notificationHandler->handle($this->config, $this->order, $this->state, $this->requestData);
    }

    public function testIfStatusUpdaterWillBeCalledWithCorrectParameters()
    {
        $this->statusUpdater
            ->expects($this->once())
            ->method('update')
            ->with($this->equalTo($this->order), $this->equalTo($this->state));

        $notificationHandler = $this->createNotificationHandler();
        $notificationHandler->handle($this->equalTo($this->config), $this->order, $this->state, $this->requestData);
    }
}
