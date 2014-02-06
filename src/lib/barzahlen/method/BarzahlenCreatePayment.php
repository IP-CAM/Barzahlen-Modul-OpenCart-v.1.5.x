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
 * Creates a transaction at the Barzahlen API
 */
class BarzahlenCreatePayment
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
     * @var BarzahlenTransactionRepository
     */
    private $transactionRepository;
    /**
     * @var ModelCheckoutOrder
     */
    private $modelCheckoutOrder;

    /**
     * @var array
     */
    private $order;
    /**
     * @var Config
     */
    private $config;
    /**
     * @var Session
     */
    private $session;

    /**
     * @var int
     */
    private $transactionId;
    /**
     * @var string
     */
    private $infotext1;
    /**
     * @var string
     */
    private $infotext2;

    /**
     * @param BarzahlenTransactionRepository $transactionRepository
     * @param BarzahlenApiFactory $barzahlenApiFactory
     * @param BarzahlenRequestFactory $barzahlenRequestFactory
     * @param ModelCheckoutOrder $modelCheckoutOrder
     */
    public function __construct($transactionRepository, $barzahlenApiFactory, $barzahlenRequestFactory, $modelCheckoutOrder)
    {
        $this->transactionRepository = $transactionRepository;
        $this->barzahlenApiFactory = $barzahlenApiFactory;
        $this->barzahlenRequestFactory = $barzahlenRequestFactory;
        $this->modelCheckoutOrder = $modelCheckoutOrder;
    }

    /**
     * Create transaction
     *
     * @param array $order
     * @param Config $config
     * @param Session $session
     */
    public function create($order, $config, $session)
    {
        $this->order = $order;
        $this->config = $config;
        $this->session = $session;

        $this->sendRequestToBarzahlenApi();
        $this->updateOrder();
        $this->createDatabaseEntry();
        $this->updateSession();
    }

    private function sendRequestToBarzahlenApi()
    {
        $api = $this->barzahlenApiFactory->create($this->config);
        $request = $this->barzahlenRequestFactory->createPaymentRequest($this->order);

        $api->handleRequest($request);

        $this->transactionId = $request->getTransactionId();
        $this->infotext1 = $request->getInfotext1();
        $this->infotext2 = $request->getInfotext2();
    }

    private function updateOrder()
    {
        $statusId = $this->config->get('barzahlen_pending_status_id');
        $this->modelCheckoutOrder->confirm($this->order['order_id'], $statusId);
    }

    private function createDatabaseEntry()
    {
        $this->transactionRepository->createTransaction($this->order['order_id'], $this->transactionId);
    }

    private function updateSession()
    {
        $this->session->data['barzahlen_infotext1'] = $this->infotext1;
        $this->session->data['barzahlen_infotext2'] = $this->infotext2;
    }
}
