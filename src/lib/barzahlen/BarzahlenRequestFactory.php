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
 * Creates Barzahlen requests
 */
class BarzahlenRequestFactory
{
    /**
     * Creates and return a payment request from the given order
     *
     * @param array $order
     * @return Barzahlen_Request_Payment
     */
    public function createPaymentRequest($order)
    {
        $request = new Barzahlen_Request_Payment(
            $order['email'],
            $order['payment_address_1'],
            $order['payment_postcode'],
            $order['payment_city'],
            $order['payment_iso_code_2'],
            self::convertTotalCurrency($order['total'], $order['currency_value']),
            $order['currency_code'],
            $order['order_id']
        );

        return $request;
    }

    /**
     * Creates and return a refund request for the given refund
     *
     * @param array $refund
     * @return Barzahlen_Request_Refund
     */
    public function createRefundRequest($refund)
    {
        $request = new Barzahlen_Request_Refund(
            $refund['transaction_id'],
            self::convertTotalCurrency($refund['amount'], $refund['currency_value']),
            $refund['currency']
        );

        return $request;
    }

    /**
     * Creates and return a resend email request for the given transaction_id
     *
     * @param int $transactionId
     * @return Barzahlen_Request_Resend
     */
    public function createResendEmailRequest($transactionId)
    {
        $request = new Barzahlen_Request_Resend($transactionId);

        return $request;
    }

    /**
     * Creates and return a cancel request for the given transaction_id
     *
     * @param int $transactionId
     * @return Barzahlen_Request_Resend
     */
    public function createCancelRequest($transactionId)
    {
        $request = new Barzahlen_Request_Cancel($transactionId);

        return $request;
    }

    /**
     * Converts an amount into the selected currency
     *
     * @param float $amount
     * @param float $currencyMultiplier
     * @return float
     */
    private static function convertTotalCurrency($amount, $currencyMultiplier)
    {
        return round(bcmul($amount, $currencyMultiplier, 8), 4);
    }
}
