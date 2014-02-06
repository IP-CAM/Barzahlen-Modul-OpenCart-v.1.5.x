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
 * Base for every Barzahlen admin controller
 */
abstract class BarzahlenControllerAdmin extends BarzahlenController
{
    /**
     * Adds default breadcrumbs to template variables
     */
    protected function initBreadCrumbs()
    {
        $this->addBreadCrumb('text_home', 'common/home', false);
        $this->addBreadCrumb('text_payment', 'extension/payment', ' :: ');
        $this->addBreadCrumb('heading_title', 'payment/barzahlen', ' :: ');
    }

    /**
     * Adds one breadcrumb to template variables
     *
     * @param $text
     * @param $href
     * @param $separator
     * @param string $params
     */
    protected function addBreadCrumb($text, $href, $separator, $params = "")
    {
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get($text),
            'href' => $this->url->link($href, 'token=' . $this->session->data['token'] . $params, 'SSL'),
            'separator' => $separator,
        );
    }
}
