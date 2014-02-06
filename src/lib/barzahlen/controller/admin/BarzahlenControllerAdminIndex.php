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

class BarzahlenControllerAdminIndex extends BarzahlenControllerAdmin
{
    private static $configFields = array(
        array(
            'name' => 'status',
            'help' => false,
            'error' => true,
        ),
        array(
            'name' => 'shop_id',
            'help' => true,
            'error' => true,
        ),
        array(
            'name' => 'payment_key',
            'help' => true,
            'error' => true,
        ),
        array(
            'name' => 'notification_key',
            'help' => true,
            'error' => true,
        ),
        array(
            'name' => 'custom_variable1',
            'help' => false,
            'error' => true,
        ),
        array(
            'name' => 'custom_variable2',
            'help' => false,
            'error' => true,
        ),
        array(
            'name' => 'custom_variable3',
            'help' => false,
            'error' => true,
        ),
        array(
            'name' => 'minimum_amount',
            'help' => true,
            'error' => true,
        ),
        array(
            'name' => 'maximum_amount',
            'help' => true,
            'error' => true,
        ),
        array(
            'name' => 'payment_currency',
            'help' => true,
            'error' => true,
        ),
        array(
            'name' => 'sandbox',
            'help' => true,
            'error' => true,
        ),
        array(
            'name' => 'debug',
            'help' => true,
            'error' => true,
        ),
        array(
            'name' => 'failed_status_id',
            'help' => true,
            'error' => true,
        ),
        array(
            'name' => 'pending_status_id',
            'help' => true,
            'error' => true,
        ),
        array(
            'name' => 'paid_status_id',
            'help' => true,
            'error' => true,
        ),
        array(
            'name' => 'expired_status_id',
            'help' => true,
            'error' => true,
        ),
        array(
            'name' => 'sort_order',
            'help' => false,
            'error' => false,
        ),
    );

    private $error = array();

    public function get()
    {
        $this->load->model('setting/setting');
        $this->load->model('localisation/order_status');
        $this->language->load('payment/barzahlen');

        if ($this->isRequestPost() && $this->isConfigValid()) {
            $this->saveConfig();
        }

        $this->document->setTitle($this->language->get('heading_title'));

        $this->addText('heading_title');
        $this->addText('button_list_orders');
        $this->addText('button_save');
        $this->addText('button_cancel');

        $this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
        $this->data['list_orders'] = $this->url->link('payment/barzahlen/orders', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['action'] = $this->url->link('payment/barzahlen', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

        $this->versionCheck();
        $this->addConfigToTemplate();
        $this->addBreadCrumbsToTemplate();

        $this->template = 'payment/barzahlen.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        return $this->render();
    }

    public function saveConfig()
    {
        $this->load->model('setting/setting');
        $this->model_setting_setting->editSetting('barzahlen', $this->request->post);

        $this->session->data['success'] = $this->language->get('text_success');

        $this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
    }

    private function addBreadCrumbsToTemplate()
    {
        $this->initBreadCrumbs();
    }

    private function versionCheck()
    {
        try {
            $now = new DateTime();
            $certificatePath = $this->getCertificateFilePath();

            $shopInfos = array(
                'shopsystem' => "OpenCart",
                'shopsystem_version' => VERSION,
                'plugin_version' => "1.0.0",
            );

            $httpClient = new BarzahlenHttpsClient();
            $versionCheckerRepository = new BarzahlenPluginCheckConfigRepository($this->config, $this->db);
            $versionCheckerRequest = new BarzahlenPluginCheckRequest($httpClient, $certificatePath);
            $versionChecker = new BarzahlenVersionCheck($versionCheckerRepository, $versionCheckerRequest);

            if ($versionChecker->isUpdateAvailable($shopInfos, $now)) {
                $message = $this->language->get("new_version_available");
                $newVersionAvailableMessage = sprintf($message, $versionChecker->getNewestVersion());
                $this->data['attention'] = $newVersionAvailableMessage;
            } else {
                $this->data['attention'] = "";
            }
        } catch (Exception $e) {
            $this->data['attention'] = "";
        }
    }

    private function addConfigToTemplate()
    {
        $this->addText('text_enabled');
        $this->addText('text_disabled');
        $this->addText('text_yes');
        $this->addText('text_no');
        $this->addError('warning');

        foreach (self::$configFields as $configField) {
            $this->addText("entry_" . $configField['name']);
            $this->addConfigValue($configField['name']);

            if ($configField['help']) {
                $this->addText("entry_" . $configField['name'] . "_help");
            }
            if ($configField['error']) {
                $this->addError($configField['name']);
            }
        }
    }

    private function addConfigValue($field)
    {
        if (isset($this->request->post['barzahlen_' . $field])) {
            $this->data['barzahlen_' . $field] = $this->request->post['barzahlen_' . $field];
        } else {
            $this->data['barzahlen_' . $field] = $this->config->get('barzahlen_' . $field);
        }
    }

    private function addError($field)
    {
        if (isset($this->error['barzahlen_' . $field])) {
            $this->data['error_' . $field] = $this->error['barzahlen_' . $field];
        } else {
            $this->data['error_' . $field] = '';
        }
    }

    /**
     * @return bool
     */
    public function isRequestPost()
    {
        return $this->request->server['REQUEST_METHOD'] == 'POST';
    }

    /**
     * @return bool
     */
    private function isConfigValid()
    {
        if (!$this->user->hasPermission('modify', 'payment/barzahlen')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->request->post['barzahlen_shop_id']) {
            $this->error['barzahlen_shop_id'] = $this->language->get('error_missing_shop_id');
        }

        if (!$this->request->post['barzahlen_payment_key']) {
            $this->error['barzahlen_payment_key'] = $this->language->get('error_missing_payment_key');
        }

        if (!$this->request->post['barzahlen_notification_key']) {
            $this->error['barzahlen_notification_key'] = $this->language->get('error_missing_notification_key');
        }

        if ($this->request->post['barzahlen_maximum_amount'] > 999.99) {
            $this->error['barzahlen_maximum_amount'] = $this->language->get('error_maximum_amount_to_big');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
}
