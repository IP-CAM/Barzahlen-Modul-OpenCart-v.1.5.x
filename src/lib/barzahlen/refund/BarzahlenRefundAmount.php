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

class BarzahlenRefundAmount
{
    private $order;
    private $refunds;

    /**
     * @param array $order
     * @param array $refunds
     */
    public function __construct($order, $refunds)
    {
        $this->order = $order;
        $this->refunds = $refunds;
    }

    /**
     * Checks if the maximum refund amount for an order has reached
     *
     * @return bool
     */
    public function hasMaxRefundAmountReached()
    {
        return $this->calculateRemainingOrderValue() <= 0;
    }

    /**
     * Calculates remaining order value without refunds
     *
     * @return float
     */
    public function calculateRemainingOrderValue()
    {
        return bcsub($this->order['total'], $this->calculateTotalRefundAmount($this->refunds), 4);
    }

    /**
     * Calculates refund total
     *
     * @return float
     */
    public function calculateTotalRefundAmount()
    {
        $refundsTotal = 0;

        foreach ($this->refunds as $refund) {
            $refundsTotal = bcadd($refundsTotal, $refund['amount'], 4);
        }

        return $refundsTotal;
    }
}