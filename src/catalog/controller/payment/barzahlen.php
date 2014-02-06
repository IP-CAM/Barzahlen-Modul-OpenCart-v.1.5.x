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
 * Responsible for display Barzahlen relevant stuff in Step 6
 */
class ControllerPaymentBarzahlen extends Controller
{
    public function index()
    {
        $this->language->load('payment/barzahlen');

        $this->data['confirm'] = $this->url->link('payment/barzahlen_confirm');
        $this->data['payment_description'] = $this->language->get('text_payment_description');
        $this->data['button_confirm'] = $this->language->get('button_confirm');

        if ($this->config->get('barzahlen_sandbox')) {
            $this->data['error_warning'] = $this->language->get('text_sandbox');
        } else {
            $this->data['error_warning'] = false;
        }

        $this->loadTemplate();

        $this->render();
    }

    /**
     * Loads template file
     */
    private function loadTemplate()
    {
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/barzahlen.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/payment/barzahlen.tpl';
        } else {
            $this->template = 'default/template/payment/barzahlen.tpl';
        }
    }
}
