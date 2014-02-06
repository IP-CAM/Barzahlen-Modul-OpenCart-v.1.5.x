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

class BarzahlenPluginCheckRequestTest extends PHPUnit_Framework_TestCase
{
    private $httpClient;
    private $certificatePath;
    private $shopInformation;
    private $config;
    private $hash;

    protected function setUp()
    {
        $this->httpClient = $this->getMock("BarzahlenHttpClient", array("post"), array(), "", false);

        $this->certificatePath = "foobar";
        $this->shopInformation = array(
            'shopsystem' => "Test",
            'shopsystem_version' => "2.00",
            'plugin_version' => "1.5.0",
        );
        $this->config = array(
            'shop_id' => 123,
            'payment_key' => "0000ff",
        );
        $this->hash = "dcba68ba91e33322120ada9deefab6012a4de0527d86e5e2210521fb3a9f92bccedddbccc76141b7d0f2884668b7a9728d77e9fbabb24f4cc9316c54ba96db45";
    }

    private function createVersionCheckRequest()
    {
        return new BarzahlenPluginCheckRequest($this->httpClient, $this->certificatePath);
    }

    private function createResponseString($result, $pluginVersion)
    {
        return "<?xml version=\"1.0\"?><response><result>{$result}</result><plugin-version>{$pluginVersion}</plugin-version></response>";
    }

    public function testHttpClientIsCalled()
    {
        $result = array(
            'response' => $this->createResponseString("0", "1.6.0"),
            'error' => 0,
        );

        $this->httpClient
            ->expects($this->once())
            ->method('post')
            ->will($this->returnValue($result));

        $request = $this->createVersionCheckRequest();
        $request->sendRequest($this->shopInformation, $this->config);
    }

    public function testHttpClientIsCalledWithCorrectParameters()
    {
        $result = array(
            'response' => $this->createResponseString("0", "1.6.0"),
            'error' => 0,
        );

        $expectedParams = array(
            'shop_id' => $this->config['shop_id'],
            'shopsystem' => $this->shopInformation['shopsystem'],
            'shopsystem_version' => $this->shopInformation['shopsystem_version'],
            'plugin_version' => $this->shopInformation['plugin_version'],
            'hash' => $this->hash,
        );

        $this->httpClient
            ->expects($this->once())
            ->method('post')
            ->with($this->anything(), $this->anything(), $expectedParams)
            ->will($this->returnValue($result));

        $request = $this->createVersionCheckRequest();
        $request->sendRequest($this->shopInformation, $this->config);
    }

    public function testThrowsExceptionWhenHttpError()
    {
        $result = array(
            'response' => $this->createResponseString("0", "1.6.0"),
            'error' => 1,
        );

        $this->httpClient
            ->expects($this->any())
            ->method('post')
            ->will($this->returnValue($result));

        $this->setExpectedException("BarzahlenPluginCheckException");

        $request = $this->createVersionCheckRequest();
        $request->sendRequest($this->shopInformation, $this->config);
    }

    public function testThrowsExceptionWhenResponseError()
    {
        $result = array(
            'response' => $this->createResponseString("1", ""),
            'error' => 0,
        );

        $this->httpClient
            ->expects($this->any())
            ->method('post')
            ->will($this->returnValue($result));

        $this->setExpectedException("BarzahlenPluginCheckException");

        $request = $this->createVersionCheckRequest();
        $request->sendRequest($this->shopInformation, $this->config);
    }

    public function testRetrurnsCorrectPluginVersion()
    {
        $expectedPluginVersion = "1.6.0";

        $result = array(
            'response' => $this->createResponseString("0", $expectedPluginVersion),
            'error' => 0,
        );

        $this->httpClient
            ->expects($this->any())
            ->method('post')
            ->will($this->returnValue($result));

        $request = $this->createVersionCheckRequest();
        $request->sendRequest($this->shopInformation, $this->config);

        $this->assertEquals($expectedPluginVersion, $request->getPluginVersion());
    }
}
