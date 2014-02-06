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
 * Base for every Barzahlen controller
 */
abstract class BarzahlenController extends Controller
{
    /**
     * Adds a text from a language file to template variables
     *
     * @param string $fieldName
     * @param string $stringName
     */
    protected function addText($fieldName, $stringName = "")
    {
        if ($stringName == "") {
            $stringName = $fieldName;
        }

        $this->data[$fieldName] = $this->language->get($stringName);
    }

    /**
     * Returns path to a debug log file
     *
     * @return string
     */
    protected function getDebugLogFilePath()
    {
        return DIR_LOGS . DIRECTORY_SEPARATOR . "barzahlen.log";
    }

    /**
     * Returns path to Barzahlen certificate file
     *
     * @return string
     */
    protected function getCertificateFilePath()
    {
        return
            DIR_SYSTEM .
            ".." . DIRECTORY_SEPARATOR .
            "lib" . DIRECTORY_SEPARATOR .
            "barzahlen" . DIRECTORY_SEPARATOR .
            "api" . DIRECTORY_SEPARATOR .
            "certs" . DIRECTORY_SEPARATOR .
            "ca-bundle.crt"
        ;
    }
}
