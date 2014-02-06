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
 * Will be called from Barzahlen if shop has to be notified for an event
 */
class ControllerCheckoutBarzahlenNotification extends Controller
{
    /**
     * @var Barzahlen_Notification
     */
    private $notification;

    public function index()
    {
        $this->load->model('checkout/order');
        $this->loadLibBarzahlen();

        try {
            $mapNotificationStateToStatusToId = array(
                BarzahlenNotificationState::STATE_PAID => $this->config->get('barzahlen_paid_status_id'),
                BarzahlenNotificationState::STATE_EXPIRED => $this->config->get('barzahlen_expired_status_id'),
            );

            $mapOrderStatusToStatusID = array(
                BarzahlenOrderStatus::STATUS_PENDING => $this->config->get('barzahlen_pending_status_id'),
                BarzahlenOrderStatus::STATUS_PAID => $this->config->get('barzahlen_paid_status_id'),
                BarzahlenOrderStatus::STATUS_EXPIRED => $this->config->get('barzahlen_expired_status_id'),
                BarzahlenOrderStatus::STATUS_FAILED => $this->config->get('barzahlen_failed_status_id'),
            );

            $shopId = $this->config->get('barzahlen_shop_id');

            $orderBarzahlenRepository = new BarzahlenTransactionRepository($this->db);
            $statusUpdater = new BarzahlenOrderStatusUpdater($this->model_checkout_order, $mapNotificationStateToStatusToId);
            $validatorFactory = new BarzahlenNotificationValidatorFactory($mapOrderStatusToStatusID);

            $this->initNotification();
            $state = $this->getState();
            $order = $this->getOrder();

            $validator = $validatorFactory->create($state);

            $notificationFactory = new BarzahlenNotificationHandlerFactory($validator, $orderBarzahlenRepository, $statusUpdater);
            $notificationHandler = $notificationFactory->create($state);
            $notificationHandler->handle($shopId, $order, $state, $this->request->get);
            echo "ok";
        } catch (Exception $e) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
            echo $e->getMessage();
        }
    }

    private function initNotification()
    {
        $this->notification = new Barzahlen_Notification(
            $this->config->get('barzahlen_shop_id'),
            $this->config->get('barzahlen_notification_key'),
            $this->request->get
        );
        $this->notification->validate();
    }

    private function getState()
    {
        return $this->notification->getState();
    }

    private function getOrder()
    {
        $repo = new BarzahlenTransactionRepository($this->db);

        if (in_array($this->getState(), array("paid", "expired"))) {
            $orderId = $this->notification->getOrderId();
        } else {
            $orderId = $this->notification->getOriginOrderId();
        }

        $order = $this->model_checkout_order->getOrder($orderId);

        if (!$order) {
            throw new RuntimeException("order not found");
        }

        $orderBarzahlen = $repo->getTransactionByOrderId($orderId);

        if (!$orderBarzahlen) {
            throw new RuntimeException("order_barzahlen not found");
        }

        return array_merge($order, $orderBarzahlen);
    }

    /**
     * Includes Barzahlen API library
     */
    private function loadLibBarzahlen()
    {
        require_once(
            DIR_SYSTEM .
                ".." . DIRECTORY_SEPARATOR .
                "lib" . DIRECTORY_SEPARATOR .
                "barzahlen" . DIRECTORY_SEPARATOR .
                "include.php"
        );
    }
}
