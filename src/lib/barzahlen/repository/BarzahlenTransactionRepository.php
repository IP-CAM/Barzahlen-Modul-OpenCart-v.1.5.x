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
 * Provides access to the Barzahlen tables, which contains additional information for Barzahlen orders
 */
class BarzahlenTransactionRepository
{
    /**
     * @var MySQL
     */
    private $db;

    /**
     * @param MySQL $db
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Add a transaction_id to an order_id
     *
     * @param int $orderId
     * @param int $transactionId
     */
    public function createTransaction($orderId, $transactionId)
    {
        $dbPrefix = DB_PREFIX;
        $orderIdEscaped = (int)$orderId;
        $transactionIdEscaped = (int)$transactionId;

        $sql = <<<SQL
INSERT INTO `{$dbPrefix}order_barzahlen_transaction`
(`order_id`, `barzahlen_transaction_id`, `date_added`, `date_modified`)
VALUES
({$orderIdEscaped}, {$transactionIdEscaped}, NOW(), NOW())
SQL;

        $this->db->query($sql);
    }

    /**
     * Add a refund to an order_id
     *
     * @param int $orderId
     * @param int $refundTransactionId
     * @param float $amount
     */
    public function addRefund($orderId, $refundTransactionId, $amount)
    {
        $dbPrefix = DB_PREFIX;

        $orderIdEscaped = (int)$orderId;
        $refundTransactionIdEscaped = (int)$refundTransactionId;
        $amountEscaped = $this->db->escape($amount);

        $sql = <<<SQL
INSERT INTO `{$dbPrefix}order_barzahlen_refund_transaction`
(`order_id`, `barzahlen_transaction_id`, `barzahlen_refund_transaction_id`, `amount`, `date_added`, `date_modified`)
VALUES
({$orderIdEscaped}, (SELECT barzahlen_transaction_id FROM oc_order_barzahlen_transaction WHERE order_id = {$orderIdEscaped}), {$refundTransactionIdEscaped}, {$amountEscaped}, NOW(), NOW())
SQL;

        $this->db->query($sql);
    }

    /**
     * Find and returns one transaction by order_id
     *
     * @param int $orderId
     * @return array|null
     */
    public function getTransactionByOrderId($orderId)
    {
        $dbPrefix = DB_PREFIX;
        $orderIdEscaped = (int)$orderId;

        $sql = <<<SQL
SELECT *
FROM `{$dbPrefix}order_barzahlen_transaction`
WHERE `order_id` = $orderIdEscaped
SQL;

        $result = $this->db->query($sql);
        if ($result) {
            $orderBarzahlen = $result->row;
        } else {
            $orderBarzahlen = null;
        }
        return $orderBarzahlen;
    }

    /**
     * Find and returns more refunds by order_id
     *
     * @param int $orderId
     * @return array|null
     */
    public function getRefundsByOrderId($orderId)
    {
        $dbPrefix = DB_PREFIX;
        $orderIdEscaped = (int)$orderId;

        $sql = <<<SQL
SELECT *
FROM `{$dbPrefix}order_barzahlen_refund_transaction`
WHERE `order_id` = $orderIdEscaped
SQL;

        $result = $this->db->query($sql);
        if ($result) {
            $refunds = $result->rows;
        } else {
            $refunds = array();
        }
        return $refunds;
    }
}
