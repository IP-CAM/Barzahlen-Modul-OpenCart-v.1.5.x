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
 * Sends a plugin check request to the Barzahlen-API
 */
class BarzahlenPluginCheckRequest
{
    const URL = "https://plugincheck.barzahlen.de/check";

    /**
     * @var BarzahlenHttpsClient
     */
    private $httpClient;
    /**
     * @var string
     */
    private $certificatePath;

    /**
     * @var array
     */
    private $requestArray;

    /**
     * @var string
     */
    private $error;
    /**
     * @var string
     */
    private $response;

    /**
     * @var string
     */
    private $result;
    /**
     * @var string
     */
    private $pluginVersion;

    /**
     * @param BarzahlenHttpsClient $httpClient
     * @param string $certificatePath
     */
    public function __construct($httpClient, $certificatePath)
    {
        $this->httpClient = $httpClient;
        $this->certificatePath = $certificatePath;
    }

    /**
     * Sends request to the Barzahlen-API
     *
     * @param array $shopInfos
     * @param array $config
     */
    public function sendRequest($shopInfos, $config)
    {
        $requestParams = array(
            'shop_id' => $config['shop_id'],
            'shopsystem' => $shopInfos['shopsystem'],
            'shopsystem_version' => $shopInfos['shopsystem_version'],
            'plugin_version' => $shopInfos['plugin_version'],
        );

        $this->requestArray = array_merge($requestParams, array(
            'hash' => $this->hash($requestParams, $config['payment_key']),
        ));

        $this->doRequest();

        if ($this->error) {
            throw new BarzahlenPluginCheckException("An error occurred while request Barzahlen-API");
        }

        $this->parseResponse();

        if ($this->result > 0) {
            throw new BarzahlenPluginCheckException("Barzahlen-API returned result {$this->result}");
        }
    }

    /**
     * Returns the current plugin version from the Barzahlen-API
     *
     * @return string
     */
    public function getPluginVersion()
    {
        return $this->pluginVersion;
    }

    private function doRequest()
    {
        $result = $this->httpClient->post(self::URL, $this->certificatePath, $this->requestArray);

        $this->response = $result['response'];
        $this->error = $result['error'];
    }

    private function parseResponse()
    {
        $domDocument = new DOMDocument();
        $domDocument->loadXML($this->response);

        $this->result = $domDocument->getElementsByTagName("result")->item(0)->nodeValue;
        $this->pluginVersion = $domDocument->getElementsByTagName("plugin-version")->item(0)->nodeValue;
    }

    private function hash($params, $key)
    {
        $hashCreate = new BarzahlenHashCreate();
        return $hashCreate->getHash($params, $key);
    }
}
