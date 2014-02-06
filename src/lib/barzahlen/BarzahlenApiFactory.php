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
 * Creates Barzahlen api
 */
class BarzahlenApiFactory
{
    /**
     * @param string $debugLogFilePath
     */
    public function __construct($debugLogFilePath)
    {
        $this->debugLogFilePath = $debugLogFilePath;
    }

    /**
     * Creates and returns an Barzahlen_Api object from the given config
     *
     * @param Config $config
     * @return Barzahlen_Api
     */
    public function create($config)
    {
        $api = new Barzahlen_Api(
            $config->get('barzahlen_shop_id'),
            $config->get('barzahlen_payment_key'),
            $config->get('barzahlen_sandbox')
        );
        $api->setDebug($config->get('barzahlen_debug'), $this->debugLogFilePath);

        return $api;
    }
}
