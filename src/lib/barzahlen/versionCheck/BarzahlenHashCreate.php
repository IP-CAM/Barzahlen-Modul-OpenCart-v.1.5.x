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
 * Hash creation for Barzahlen params
 */
class BarzahlenHashCreate
{
    const SEPERATOR = ";";
    const HASH_ALGORITHM = "sha512";

    /**
     * Creates a Hash from an array and a key
     *
     * @param array $array
     * @param string $key
     * @return string
     */
    public function getHash($array, $key)
    {
        $array[] = $key;
        $hash = implode(self::SEPERATOR, $array);
        return hash(self::HASH_ALGORITHM, $hash);
    }
}
