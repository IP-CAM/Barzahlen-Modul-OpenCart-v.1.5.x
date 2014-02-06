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
 * Responsible for return payment method config in Step 5
 */
class ModelPaymentBarzahlen extends Model
{
    /**
     * @param array $address
     * @param float $total
     * @return array
     */
    public function getMethod($address, $total)
    {
        $this->language->load('payment/barzahlen');

        if (
            $this->isCurrencyValid() &&
            $this->isTotalAmountValid($total) &&
            $this->isAddressValid($address)
        ) {
            $return = array(
                'code' => "barzahlen",
                'title' => $this->language->get('text_title'),
                'sort_order' => $this->config->get('barzahlen_sort_order')
            );
        } else {
            $return = false;
        }

        return $return;
    }

    private function isCurrencyValid()
    {
        return
            $this->config->get('config_currency') == "EUR" &&
            $this->currency->getCode() == "EUR";
    }

    private function isTotalAmountValid($total)
    {
        $maximumAmount = $this->config->get("barzahlen_maximum_amount");
        $minimumAmount = $this->config->get("barzahlen_minimum_amount");

        return
            (!$maximumAmount || $total <= $maximumAmount) &&
            (!$minimumAmount || $total >= $minimumAmount);
    }

    private function isAddressValid($address)
    {
        return $address['iso_code_2'] == "DE";
    }
}
