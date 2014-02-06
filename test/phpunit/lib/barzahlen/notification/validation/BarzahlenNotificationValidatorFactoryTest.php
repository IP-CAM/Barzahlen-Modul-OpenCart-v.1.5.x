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

class BarzahlenNotificationValidatorFactoryTest extends PHPUnit_Framework_TestCase
{
    private function createValidatorFactoryFactory()
    {
        return new BarzahlenNotificationValidatorFactory(array());
    }

    public function testIfFactoryReturnsCorrectClassOnStatusPaid()
    {
        $state = BarzahlenNotificationState::STATE_PAID;

        $validatorFactory = $this->createValidatorFactoryFactory();
        $validator = $validatorFactory->create($state);

        $this->assertInstanceOf("BarzahlenNotificationValidatorPayment", $validator);
    }

    public function testIfFactoryReturnsCorrectClassOnStatusExpired()
    {
        $state = BarzahlenNotificationState::STATE_EXPIRED;

        $validatorFactory = $this->createValidatorFactoryFactory();
        $validator = $validatorFactory->create($state);

        $this->assertInstanceOf("BarzahlenNotificationValidatorPayment", $validator);
    }

    public function testIfFactoryReturnsCorrectClassOnStatusRefundCompleted()
    {
        $state = BarzahlenNotificationState::STATE_REFUND_COMPLETED;

        $validatorFactory = $this->createValidatorFactoryFactory();
        $validator = $validatorFactory->create($state);

        $this->assertInstanceOf("BarzahlenNotificationValidatorRefund", $validator);
    }

    public function testIfFactoryReturnsCorrectClassOnStatusRefundExpired()
    {
        $state = BarzahlenNotificationState::STATE_REFUND_EXPIRED;

        $validatorFactory = $this->createValidatorFactoryFactory();
        $validator = $validatorFactory->create($state);

        $this->assertInstanceOf("BarzahlenNotificationValidatorRefund", $validator);
    }

    public function testIfFactoryThrowsExceptionOnUnknownStatus()
    {
        $state = "foobar";

        $this->setExpectedException("RuntimeException");

        $validatorFactory = $this->createValidatorFactoryFactory();
        $validator = $validatorFactory->create($state);
    }
}
