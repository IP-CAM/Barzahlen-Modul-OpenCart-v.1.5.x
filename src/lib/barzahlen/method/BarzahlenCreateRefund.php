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
 * Creates a refund transaction at the Barzahlen API
 */
class BarzahlenCreateRefund
{
    /**
     * @var BarzahlenTransactionRepository
     */
    private $transactionRepository;
    /**
     * @var BarzahlenApiFactory
     */
    private $barzahlenApiFactory;
    /**+
     * @var BarzahlenRequestFactory
     */
    private $barzahlenRequestFactory;

    /**
     * @var array
     */
    private $order;
    /**
     * @var float
     */
    private $amount;
    /**
     * @var Config
     */
    private $config;

    /**
     * @var array
     */
    private $transaction;
    /**
     * @var array
     */
    private $previousRefunds;
    /**
     * @var int
     */
    private $refundTransactionId;

    /**
     * @param BarzahlenTransactionRepository $transactionRepository
     * @param BarzahlenApiFactory $barzahlenApiFactory
     * @param BarzahlenRequestFactory $barzahlenRequestFactory
     */
    public function __construct($transactionRepository, $barzahlenApiFactory, $barzahlenRequestFactory)
    {
        $this->transactionRepository = $transactionRepository;
        $this->barzahlenApiFactory = $barzahlenApiFactory;
        $this->barzahlenRequestFactory = $barzahlenRequestFactory;
    }

    /**
     * Create transaction
     *
     * @param array $order
     * @param array $transaction
     * @param array $previousRefunds
     * @param float $amount
     * @param Config $config
     */
    public function create($order, $transaction, $previousRefunds, $amount, $config)
    {
        $this->order = $order;
        $this->transaction = $transaction;
        $this->previousRefunds = $previousRefunds;
        $this->amount = $amount;
        $this->config = $config;

        $this->check();
        $this->sendRequestToBarzahlenApi();
        $this->createDatabaseEntry();
    }

    private function check()
    {
        $refundAmount = new BarzahlenRefundAmount($this->order, $this->previousRefunds);
        $orderValue = $refundAmount->calculateRemainingOrderValue();

        if ($this->amount <= 0) {
            throw new RuntimeException("refund amount too low");
        }

        if ($this->amount > $orderValue) {
            throw new RuntimeException("refund amount too high");
        }
    }

    private function sendRequestToBarzahlenApi()
    {
        $refund = array(
            'transaction_id' => $this->transaction['barzahlen_transaction_id'],
            'amount' => $this->amount,
            'currency_value' => $this->order['currency_value'],
            'currency' => $this->order['currency_code'],
        );

        $api = $this->barzahlenApiFactory->create($this->config);
        $request = $this->barzahlenRequestFactory->createRefundRequest($refund);

        $api->handleRequest($request);

        $this->refundTransactionId = $request->getRefundTransactionId();
    }

    private function createDatabaseEntry()
    {
        $this->transactionRepository->addRefund($this->order['order_id'], $this->refundTransactionId, $this->amount);
    }
}
