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

class BarzahlenApiFactoryTest extends PHPUnit_Framework_TestCase
{
    private $debugPath;
    private $configData;
    private $config;

    protected function setUp()
    {
        $this->debugPath = "foobar";
        $this->configData = array(
            'barzahlen_shop_id' => "112233",
            'barzahlen_payment_key' => "dd00ff",
            'barzahlen_notification_key' => "ff00ff",
            'barzahlen_sandbox' => true,
            'barzahlen_debug' => true,
        );

        $this->config = $this->getMock("Config", array("get"), array(), "", false);
    }

    private function createApiFactory()
    {
        return new BarzahlenApiFactory($this->debugPath);
    }

    public function testConfigFactoryReturnsCorrectType()
    {
        $apiFactory = $this->createApiFactory();
        $api = $apiFactory->create($this->config);

        $this->assertInstanceOf("Barzahlen_Api", $api);
    }
}
