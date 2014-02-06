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

class BarzahlenControllerAdminRefunds extends BarzahlenControllerAdmin
{
    /**
     * @var BarzahlenOrderRepository
     */
    private $orderRepository;
    /**
     * @var BarzahlenTransactionRepository
     */
    private $transactionRepository;

    /**
     * @var int
     */
    private $orderId;
    /**
     * @var array
     */
    private $order;
    /**
     * @var array
     */
    private $transaction;

    public function get()
    {
        $this->load->model('sale/order');
        $this->language->load('sale/order');
        $this->language->load('payment/barzahlen');

        $this->data['error'] = "";
        $this->data['success'] = "";

        $this->init();

        $this->orderId = $this->request->get['order_id'];
        $this->order = $this->orderRepository->getOrderById($this->orderId);
        $this->transaction = $this->transactionRepository->getTransactionByOrderId($this->orderId);

        if ($this->isRequestPost()) {
            $this->createRefund();
        }

        $this->document->setTitle($this->language->get('heading_list_refunds'));

        $this->addText('heading_list_refunds');
        $this->addText('column_order_id');
        $this->addText('column_amount');
        $this->addText('column_order_total_amount');
        $this->addText('column_total_refund_amount');
        $this->addText('column_date_added');
        $this->addText('column_date_modified');
        $this->addText('column_transaction_id');
        $this->addText('column_refund_transaction_id');
        $this->addText('text_no_results');
        $this->addText('text_no_more_refunds_possible');

        $this->data['action_create_refund'] = $this->url->link('payment/barzahlen/refunds', 'token=' . $this->session->data['token'] . "&order_id=" . $this->orderId, 'SSL');

        $this->addBreadCrumbsToTemplate();

        $this->addRefundDataTemplate();

        $this->template = 'payment/barzahlen_refunds.tpl';
        $this->children = array(
            'common/header',
            'common/footer',
        );

        return $this->render();
    }

    private function init()
    {
        $this->transactionRepository = new BarzahlenTransactionRepository($this->db);
        $this->orderRepository = new BarzahlenOrderRepository($this->db, $this->model_sale_order, (int)$this->config->get('config_language_id'));
    }

    private function createRefund()
    {
        try {
            $amount = $this->request->post['amount'];

            $apiFactory = new BarzahlenApiFactory($this->getDebugLogFilePath());
            $requestFactory = new BarzahlenRequestFactory();
            $createRefund = new BarzahlenCreateRefund($this->transactionRepository, $apiFactory, $requestFactory);

            $previousRefunds = $this->transactionRepository->getRefundsByOrderId($this->order['order_id']);

            $createRefund->create($this->order, $this->transaction, $previousRefunds, $amount, $this->config);
            $this->addText("success", "success_create_refund");
        } catch (Exception $e) {
            $this->log->write("BARZAHLEN :: Error while create refund - " . $e->getMessage());
            $this->addText("error", "error_create_refund");
        }
    }

    private function addBreadCrumbsToTemplate()
    {
        $this->initBreadCrumbs();
        $this->addBreadCrumb('heading_list_orders', 'payment/barzahlen/orders', ' :: ', '&order_id=' . $this->orderId);
        $this->addBreadCrumb('heading_list_refunds', 'payment/barzahlen/refunds', ' :: ', '&order_id=' . $this->orderId);
    }

    private function addRefundDataTemplate()
    {
        $refunds = $this->transactionRepository->getRefundsByOrderId($this->orderId);

        $refundAmountCalc = new BarzahlenRefundAmount($this->order, $refunds);

        $totalRefundAmount = $refundAmountCalc->calculateTotalRefundAmount();
        $maxRefundAmount = $refundAmountCalc->calculateRemainingOrderValue();
        $maxRefundAmountReached = $refundAmountCalc->hasMaxRefundAmountReached();

        $this->data['order_id'] = $this->orderId;
        $this->data['transaction_id'] = $this->transaction['barzahlen_transaction_id'];
        $this->data['order_total_amount'] = $this->order['total'];
        $this->data['total_refund_amount'] = $totalRefundAmount;
        $this->data['refunds'] = $refunds;
        $this->data['maxRefundAmount'] = $maxRefundAmount;
        $this->data['maxRefundAmountReached'] = $maxRefundAmountReached;
    }

    /**
     * @return bool
     */
    public function isRequestPost()
    {
        return $this->request->server['REQUEST_METHOD'] == 'POST';
    }
}
