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

/**
 * Interface for notification validators
 */
abstract class BarzahlenNotificationValidator
{
    /**
     * @var array
     */
    private $orderStatusMapStatusToId;

    /**
     * @var int
     */
    private $shopId;
    /**
     * @var array
     */
    private $order;

    /**
     * @param array $orderStatusMapStatusToId
     */
    public function __construct($orderStatusMapStatusToId)
    {
        $this->orderStatusMapStatusToId = $orderStatusMapStatusToId;
    }

    /**
     * Validates the notification
     *
     * @param int $shopId
     * @param array $order
     * @param array $data
     * @throws BarzahlenNotificationValidatorException
     */
    public function validate($shopId, $order, $data)
    {
        $this->shopId = $shopId;
        $this->order = $order;

        if (!$this->isOrderStatusValid($order['order_status_id'])) {
            throw new BarzahlenNotificationValidatorException("invalid status");
        }

        if (!$this->isShopIdValid($data['shop_id'])) {
            throw new BarzahlenNotificationValidatorException("invalid shop_id");
        }
    }

    /**
     * @param int $orderStatusId
     * @return bool
     */
    protected function isOrderStatusValid($orderStatusId)
    {
        return $orderStatusId == $this->orderStatusMapStatusToId[BarzahlenOrderStatus::STATUS_PENDING];
    }

    /**
     * @param int $shopId
     * @return bool
     */
    protected function isShopIdValid($shopId)
    {
        return $shopId == $this->shopId;
    }

    /**
     * @param int $orderId
     * @return bool
     */
    protected function isOrderIdValid($orderId)
    {
        return $orderId == $this->order['order_id'];
    }

    /**
     * @param int $transactionId
     * @return bool
     */
    protected function isTransactionIdValid($transactionId)
    {
        return $transactionId == $this->order['barzahlen_transaction_id'];
    }
}