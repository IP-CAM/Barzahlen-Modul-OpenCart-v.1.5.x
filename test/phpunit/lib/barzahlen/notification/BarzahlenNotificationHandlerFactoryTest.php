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

class BarzahlenNotificationHandlerFactoryTest extends PHPUnit_Framework_TestCase
{
    private $orderBarzahlenRepository;
    private $statusUpdater;
    private $validator;
    private $state;

    protected function setUp()
    {
        $this->orderBarzahlenRepository = $this->getMock("BarzahlenOrderBarzahlenRepository", array(), array(), "", false);
        $this->statusUpdater = $this->getMock("BarzahlenOrderStatusUpdater", array(), array(), "", false);
        $this->validator = $this->getMock("BarzahlenNotificationValidator", array(), array(), "", false);
    }

    private function createNotificationFactory()
    {
        return new BarzahlenNotificationHandlerFactory(
            $this->validator,
            $this->orderBarzahlenRepository,
            $this->statusUpdater
        );
    }

    public function testNotificationFactoryReturnsCorrectTypeOnPaid()
    {
        $this->state = BarzahlenNotificationState::STATE_PAID;

        $notificationFactory = $this->createNotificationFactory();
        $handler = $notificationFactory->create($this->state);

        $this->assertInstanceOf("BarzahlenNotificationHandlerPayment", $handler);
    }

    public function testNotificationFactoryReturnsCorrectTypeOnExpired()
    {
        $this->state = BarzahlenNotificationState::STATE_EXPIRED;

        $notificationFactory = $this->createNotificationFactory();
        $handler = $notificationFactory->create($this->state);

        $this->assertInstanceOf("BarzahlenNotificationHandlerPayment", $handler);
    }

    public function testNotificationFactoryReturnsCorrectTypeOnRefundCompleted()
    {
        $this->state = BarzahlenNotificationState::STATE_REFUND_COMPLETED;

        $notificationFactory = $this->createNotificationFactory();
        $handler = $notificationFactory->create($this->state);

        $this->assertInstanceOf("BarzahlenNotificationHandlerRefund", $handler);
    }

    public function testNotificationFactoryReturnsCorrectTypeOnRefundExpired()
    {
        $this->state = BarzahlenNotificationState::STATE_REFUND_EXPIRED;

        $notificationFactory = $this->createNotificationFactory();
        $handler = $notificationFactory->create($this->state);

        $this->assertInstanceOf("BarzahlenNotificationHandlerRefund", $handler);
    }

    public function testIfFactoryThrowsExceptionOnUnknownStatus()
    {
        $this->state = "foobar";

        $this->setExpectedException("RuntimeException");

        $notificationFactory = $this->createNotificationFactory();
        $handler = $notificationFactory->create($this->state);
    }
}
