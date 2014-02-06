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

class BarzahlenControllerConfirm extends BarzahlenController
{
    private $error = false;

    /**
     * @var array
     */
    private $outputArray = array();


    public function get()
    {
        $this->language->load('payment/barzahlen');
        $this->load->model('checkout/order');

        $this->processOrder();

        return json_encode($this->outputArray);
    }

    public function hasError()
    {
        return $this->error;
    }

    /**
     * Sends order to Barzahlen API, creates order and handles errors if they occur
     */
    private function processOrder()
    {
        $orderId = $this->session->data['order_id'];
        $orderInfo = $this->model_checkout_order->getOrder($orderId);

        $apiFactory = new BarzahlenApiFactory($this->getDebugLogFilePath());
        $requestFactory = new BarzahlenRequestFactory();
        $transactionFactory = new BarzahlenTransactionRepository($this->db);

        $createPayment = new BarzahlenCreatePayment($transactionFactory, $apiFactory, $requestFactory, $this->model_checkout_order);

        try {
            $createPayment->create($orderInfo, $this->config, $this->session);

            $this->outputArray['redirect'] = $this->url->link('checkout/barzahlen');
        } catch (Exception $e) {
            $this->session->data['barzahlen_infotext'] = false;
            $this->log->write("BARZAHLEN :: Error while transferring order to Barzahlen - " . $e->getMessage());

            $this->outputArray['error'] = $this->language->get('text_error_api');
            $this->error = true;
        }
    }
}