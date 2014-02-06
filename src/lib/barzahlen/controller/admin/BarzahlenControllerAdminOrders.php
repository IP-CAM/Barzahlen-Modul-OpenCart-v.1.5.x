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

class BarzahlenControllerOrdersAdmin extends BarzahlenControllerAdmin
{
    public function get()
    {
        $this->language->load('sale/order');
        $this->language->load('payment/barzahlen');
        $this->load->model('sale/order');

        $this->data['error'] = "";
        $this->data['success'] = "";

        if ($this->isActionResendEmail()) {
            $this->resendPaymentSlip();
        }

        if ($this->isActionCancel()) {
            $this->cancel();
        }

        $this->document->setTitle($this->language->get('heading_list_orders'));

        $this->addText('heading_list_orders');
        $this->addText('column_order_id');
        $this->addText('column_customer');
        $this->addText('column_status');
        $this->addText('column_total');
        $this->addText('column_date_added');
        $this->addText('column_date_modified');
        $this->addText('column_transaction_id');
        $this->addText('column_refund_transaction_id');
        $this->addText('column_action');
        $this->addText('action_refunds');
        $this->addText('action_cancel');
        $this->addText('action_resend_payment_slip');
        $this->addText('text_no_results');

        $this->addBreadCrumbsToTemplate();
        $this->addOrdersToTemplate();

        $this->template = 'payment/barzahlen_orders.tpl';
        $this->children = array(
            'common/header',
            'common/footer',
        );

        return $this->render();
    }

    private function isActionResendEmail()
    {
        return array_key_exists("action", $this->request->get) && $this->request->get['action'] == "resend_payment_slip";
    }

    private function resendPaymentSlip()
    {
        try {
            $orderId = $this->request->get['order_id'];

            $apiFactory = new BarzahlenApiFactory($this->getDebugLogFilePath());
            $requestFactory = new BarzahlenRequestFactory();
            $transactionRepository = new BarzahlenTransactionRepository($this->db);
            $transaction = $transactionRepository->getTransactionByOrderId($orderId);

            $resendEmail = new BarzahlenResendEmail($apiFactory, $requestFactory);
            $resendEmail->resend($transaction['barzahlen_transaction_id'], $this->config);
            $this->addText("success", "success_resend_payment_slip");
        } catch (Exception $e) {
            $this->log->write("BARZAHLEN :: Error while resend payment slip - " . $e->getMessage());
            $this->addText("error", "error_resend_payment_slip");
        }
    }

    private function isActionCancel()
    {
        return array_key_exists("action", $this->request->get) && $this->request->get['action'] == "cancel";
    }

    private function cancel()
    {
        try {
            $orderId = $this->request->get['order_id'];

            $apiFactory = new BarzahlenApiFactory($this->getDebugLogFilePath());
            $requestFactory = new BarzahlenRequestFactory();
            $transactionRepository = new BarzahlenTransactionRepository($this->db);
            $transaction = $transactionRepository->getTransactionByOrderId($orderId);

            $resendEmail = new BarzahlenCancel($apiFactory, $requestFactory);
            $resendEmail->cancel($transaction['barzahlen_transaction_id'], $this->config);
            $this->addText("success", "success_cancel_transaction");
        } catch (Exception $e) {
            $this->log->write("BARZAHLEN :: Error while cancel transaction - " . $e->getMessage());
            $this->addText("error", "error_cancel_transaction");
        }
    }


    private function addBreadCrumbsToTemplate()
    {
        $this->initBreadCrumbs();
        $this->addBreadCrumb('heading_list_orders', 'payment/barzahlen/orders', ' :: ');
    }

    private function addOrdersToTemplate()
    {
        $orderRepository = new BarzahlenOrderRepository($this->db, $this->model_sale_order, (int)$this->config->get('config_language_id'));

        $orders = $orderRepository->getOrdersByPaymentMethod("barzahlen");
        $this->data['orders'] = array();

        foreach ($orders as $order) {
            $actions = array();

            if ($order['status_id'] != $this->config->get('barzahlen_failed_status_id') && $order['status_id'] != $this->config->get('barzahlen_expired_status_id')) {
                if ($order['status_id'] == $this->config->get('barzahlen_paid_status_id')) {
                    $actions['action_list_refunds'] = $this->url->link("payment/barzahlen/refunds", 'token=' . $this->session->data['token'] . "&order_id=" . $order['order_id'], 'SSL');
                }

                if ($order['status_id'] == $this->config->get('barzahlen_pending_status_id')) {
                    $actions['action_cancel'] = $this->url->link("payment/barzahlen/orders", 'token=' . $this->session->data['token'] . "&order_id=" . $order['order_id'] . "&action=cancel", 'SSL');
                }

                if ($order['status_id'] == $this->config->get('barzahlen_pending_status_id')) {
                    $actions['action_resend_payment_slip'] = $this->url->link("payment/barzahlen/orders", 'token=' . $this->session->data['token'] . "&order_id=" . $order['order_id'] . "&action=resend_payment_slip", 'SSL');
                }
            }


            $this->data['orders'][] = array_merge($order, $actions);
        }
    }
}
