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

class BarzahlenOrderRepository
{
    /**
     * @var MySQL
     */
    private $db;
    /**
     * @var ModelCheckoutOrder|ModelSaleOrder
     */
    private $modelOrder;
    /**
     * @var int
     */
    private $languageId;

    /**
     * @param MySQL $db
     * @param ModelCheckoutOrder|ModelSaleOrder $modelOrder
     * @param int $languageId
     */
    public function __construct($db, $modelOrder, $languageId)
    {
        $this->db = $db;
        $this->modelOrder = $modelOrder;
        $this->languageId = $languageId;
    }

    /**
     * Find and returns one order by id
     *
     * @param $orderId
     * @return array
     */
    public function getOrderById($orderId)
    {
        return $this->modelOrder->getOrder($orderId);
    }

    /**
     * Find and returns more orders by payment method
     *
     * @param string $paymentMethod
     * @param array $data
     * @return array
     */
    public function getOrdersByPaymentMethod($paymentMethod, $data = array())
    {
        $dbPrefix = DB_PREFIX;

        $sql = "SELECT o.order_id, CONCAT(o.firstname, ' ', o.lastname) AS customer, (SELECT os.name FROM {$dbPrefix}order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->languageId . "') AS status, order_status_id as status_id, o.total, o.currency_code, o.currency_value, o.date_added, o.date_modified, ob.barzahlen_transaction_id FROM `{$dbPrefix}order` o";
        $sql .= " INNER JOIN {$dbPrefix}order_barzahlen_transaction ob ON ob.order_id = o.order_id";
        $sql .= " WHERE o.order_status_id > 0 AND o.payment_code = '" . $paymentMethod . "'";

        $sort_data = array(
            'o.order_id',
            'customer',
            'status',
            'o.date_added',
            'o.date_modified',
            'o.total'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY o.order_id";
        }

        if (isset($data['order']) && ($data['order'] == 'ASC')) {
            $sql .= " ASC";
        } else {
            $sql .= " DESC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $result = $this->db->query($sql);
        if ($result) {
            $orders = $result->rows;
        } else {
            $orders = array();
        }

        return $orders;
    }
}
