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
 * Display site with barzahlen payment details
 */
class ControllerCheckoutBarzahlen extends Controller
{
    public function index()
    {
        $this->language->load('checkout/barzahlen');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['button_continue'] = $this->language->get('button_continue');
        $this->data['continue'] = $this->url->link('checkout/success');
        $this->data['payment_info'] =
            $this->session->data['barzahlen_infotext1'] .
                $this->session->data['barzahlen_infotext2'];

        $this->addBreadcrumbs();

        $this->children = array(
            'common/column_left',
            'common/column_right',
            'common/content_top',
            'common/content_bottom',
            'common/footer',
            'common/header'
        );

        $this->loadTemplate();

        $this->response->setOutput($this->render());
    }

    /**
     * Adds breadcrumbs
     */
    private function addBreadcrumbs()
    {
        $this->data['breadcrumbs'] = array(
            array(
                'href' => $this->url->link('common/home'),
                'text' => $this->language->get('text_home'),
                'separator' => false
            ),
            array(
                'href' => $this->url->link('checkout/cart'),
                'text' => $this->language->get('text_basket'),
                'separator' => $this->language->get('text_separator')
            ),
            array(
                'href' => $this->url->link('checkout/checkout'),
                'text' => $this->language->get('text_checkout'),
                'separator' => $this->language->get('text_separator')
            ),
            array(
                'href' => $this->url->link('checkout/barzahlen'),
                'text' => $this->language->get('text_barzahlen'),
                'separator' => $this->language->get('text_separator')
            ),
        );
    }

    /**
     * Loads template file
     */
    private function loadTemplate()
    {
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/barzahlen.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/checkout/barzahlen.tpl';
        } else {
            $this->template = 'default/template/checkout/barzahlen.tpl';
        }
    }
}
