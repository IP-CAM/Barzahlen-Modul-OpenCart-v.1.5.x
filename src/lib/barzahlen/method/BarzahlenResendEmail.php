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
 * Resend payment slip email via the Barzahlen API
 */
class BarzahlenResendEmail
{
    /**
     * @var BarzahlenApiFactory
     */
    private $barzahlenApiFactory;
    /**+
     * @var BarzahlenRequestFactory
     */
    private $barzahlenRequestFactory;

    /**
     * @param BarzahlenApiFactory $barzahlenApiFactory
     * @param BarzahlenRequestFactory $barzahlenRequestFactory
     */
    public function __construct($barzahlenApiFactory, $barzahlenRequestFactory)
    {
        $this->barzahlenApiFactory = $barzahlenApiFactory;
        $this->barzahlenRequestFactory = $barzahlenRequestFactory;
    }

    /**
     * Resend payment slip email
     *
     * @param int $transactionId
     * @param array $config
     */
    public function resend($transactionId, $config)
    {
        $request = $this->barzahlenRequestFactory->createResendEmailRequest($transactionId);
        $api = $this->barzahlenApiFactory->create($config);
        $api->handleRequest($request);
    }
}
