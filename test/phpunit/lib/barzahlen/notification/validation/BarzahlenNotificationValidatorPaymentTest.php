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

class BarzahlenNotificationValidatorPaymentTest extends PHPUnit_Framework_TestCase
{
    private $statusMap;
    private $shopId;
    private $orderId;
    private $statusId;
    private $transactionId;
    private $order;
    private $data;

    protected function setUp()
    {
        $this->statusMap = array(
            BarzahlenOrderStatus::STATUS_PENDING => 2,
        );
        $this->shopId = 123;
        $this->statusId = 2;
        $this->order = array(
            'order_id' => $this->orderId,
            'order_status_id' => $this->statusId,
            'barzahlen_transaction_id' => $this->transactionId,
        );
        $this->data = array(
            'shop_id' => $this->shopId,
            'order_id' => $this->orderId,
            'transaction_id' => $this->transactionId,
        );
    }

    private function createNotificationValidator()
    {
        return new BarzahlenNotificationValidatorPayment($this->statusMap);
    }

    public function testNoErrorIsThrownOnCorrectData()
    {
        $validator = $this->createNotificationValidator();

        $validator->validate($this->shopId, $this->order, $this->data);

        // Testing if no exception is thrown so this will not be reached if there is an exception
        $this->assertTrue(true);
    }

    public function testExceptionIsThrownOnInvalidStatus()
    {
        $this->setExpectedException("BarzahlenNotificationValidatorException");

        $validator = $this->createNotificationValidator();

        $this->order['order_status_id'] = 5;

        $validator->validate($this->shopId, $this->order, $this->data);
    }

    public function testExceptionIsThrownOnInvalidShopId()
    {
        $this->setExpectedException("BarzahlenNotificationValidatorException");

        $validator = $this->createNotificationValidator();

        $validator->validate(111, $this->order, $this->data);
    }

    public function testExceptionIsThrownOnInvalidOrderId()
    {
        $this->setExpectedException("BarzahlenNotificationValidatorException");

        $validator = $this->createNotificationValidator();

        $order = $this->order;
        $order['order_id'] = 555;

        $validator->validate($this->shopId, $order, $this->data);
    }

    public function testExceptionIsThrownOnInvalidTransactionId()
    {
        $this->setExpectedException("BarzahlenNotificationValidatorException");

        $validator = $this->createNotificationValidator();

        $order = $this->order;
        $order['barzahlen_transaction_id'] = 666;

        $validator->validate($this->shopId, $order, $this->data);
    }
}
