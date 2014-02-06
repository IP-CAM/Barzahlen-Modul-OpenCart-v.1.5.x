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
 * Abstraction layer to the database. Will be implemented for each shop module
 */
interface BarzahlenPluginCheckConfigRepositoryInterface
{
    /**
     * Returns if the Barzahlen module is activated or not
     *
     * @return bool
     */
    public function isModuleActivated();

    /**
     * Returns the date when the last plugin version check happened
     *
     * @return DateTime
     */
    public function getLastCheckDate();

    /**
     * Returns an array with at least shop_id and payment_key
     *
     * @return array
     */
    public function getShopConfig();

    /**
     * Updates last plugin check date
     *
     * @param DateTime $now
     */
    public function updateLastRequestDate($now);
}
