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

class BarzahlenOrderStatusUpdaterTest extends PHPUnit_Framework_TestCase
{
    private $orderId;
    private $state;
    private $statusId;
    private $modelCheckoutOrder;
    private $config;
    private $order;

    protected function setUp()
    {
        $this->orderId = 123;
        $this->state = "foobar";
        $this->statusId = 123;
        $this->modelCheckoutOrder = $this->getMock("ModelCheckoutOrder", array("update"), array(), "", false);
        $this->config = array(
            $this->state => $this->statusId
        );
        $this->order = array(
            'order_id' => $this->orderId
        );
    }

    private function createOrderStatusUpdater()
    {
        return new BarzahlenOrderStatusUpdater($this->modelCheckoutOrder, $this->config);
    }

    public function testIfUpdateIsCalledWithCorrectParameters()
    {
        $this->modelCheckoutOrder
            ->expects($this->once())
            ->method('update')
            ->with($this->equalTo($this->orderId), $this->equalTo($this->statusId));

        $orderStatusUpdater = $this->createOrderStatusUpdater();
        $orderStatusUpdater->update($this->order, $this->state);
    }
}
