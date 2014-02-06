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

class BarzahlenRefundAmountTest extends PHPUnit_Framework_TestCase
{
    private $order;
    private $refunds;

    public function setUp()
    {
        $this->order = array(
            'total' => "50.00",
        );
        $this->refunds = array(
            array(
                'amount' => "22.5",
            ),
            array(
                'amount' => "12.5",
            ),
        );
    }

    public function createRefundAmountCalculator()
    {
        return new BarzahlenRefundAmount($this->order, $this->refunds);
    }

    public function testCaclculateTotalRefundAmountReturnsCorrectValue()
    {
        $refundAmountCalculator = $this->createRefundAmountCalculator();
        $totalRefundAmount = $refundAmountCalculator->calculateTotalRefundAmount();

        $this->assertEquals("35.00", $totalRefundAmount);
    }

    public function testCalculateRemainingOrderValueReturnsCorrectValue()
    {
        $refundAmountCalculator = $this->createRefundAmountCalculator();
        $remainingOrderValue = $refundAmountCalculator->calculateRemainingOrderValue();

        $this->assertEquals("15.00", $remainingOrderValue);
    }

    public function testMaxAmountReachedWithHigherAmount()
    {
        $this->order = array(
            'total' => "30.00",
        );

        $refundAmountCalculator = $this->createRefundAmountCalculator();
        $maxAmountReached = $refundAmountCalculator->hasMaxRefundAmountReached();

        $this->assertTrue($maxAmountReached);
    }

    public function testMaxAmountReachedWithEqualAmount()
    {
        $this->order = array(
            'total' => "35.00",
        );

        $refundAmountCalculator = $this->createRefundAmountCalculator();
        $maxAmountReached = $refundAmountCalculator->hasMaxRefundAmountReached();

        $this->assertTrue($maxAmountReached);
    }

    public function testMaxAmountReachedWithLowerAmount()
    {
        $refundAmountCalculator = $this->createRefundAmountCalculator();
        $maxAmountReached = $refundAmountCalculator->hasMaxRefundAmountReached();

        $this->assertFalse($maxAmountReached);
    }
}
