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

class BarzahlenPluginCheckConfigRepository implements BarzahlenPluginCheckConfigRepositoryInterface
{
    /**
     * @var Config
     */
    private $config;
    /**
     * @var DB
     */
    private $db;

    /**
     * @param Config $config
     * @param DB $db
     */
    public function __construct($config, $db)
    {
        $this->config = $config;
        $this->db = $db;
    }

    public function isModuleActivated()
    {
        return $this->config->get("barzahlen_status");
    }

    public function getLastCheckDate()
    {
        $lastCheckDate = $this->config->get("barzahlen_last_plugin_check_date");
        if ($lastCheckDate) {
            return new DateTime($lastCheckDate);
        } else {
            return false;
        }
    }

    public function getShopConfig()
    {
        return array(
            'shop_id' => $this->config->get("barzahlen_shop_id"),
            'payment_key' => $this->config->get("barzahlen_payment_key"),
        );
    }

    public function updateLastRequestDate($now)
    {
        $storeId = 0;
        $group = $this->db->escape("barzahlen");
        $key = $this->db->escape("barzahlen_last_plugin_check_date");
        $value = $this->db->escape($now->format("Y-m-d H:i:s"));

        if ($this->getLastCheckDate()) {
            $this->db->query("UPDATE " . DB_PREFIX . "setting SET `value` = '$value' WHERE `group` = '$group' AND `key` = '$key' AND store_id = $storeId");
        } else {
            $this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '$storeId', `group` = '$group', `key` = '$key', `value` = '$value'");
        }
    }
}
