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

class BarzahlenHashCreateTest extends PHPUnit_Framework_TestCase
{
    public function testCreatedHashIsCorrect()
    {
        $expectedHash = "514d01564e29400d27886815747dc080a358029431ec9440e48d5b85e630d8fceb75daabe5624bb36e10ed72b33d8f25bac0fca9d69d2597fe7b8e12c418bc8a";

        $data = array(
            'test',
            123,
            'foo',
        );
        $key = "ed0164df332a9e3e5cc858a738439dbf";

        $hashCreate = new BarzahlenHashCreate();
        $hash = $hashCreate->getHash($data, $key);

        $this->assertEquals($expectedHash, $hash);
    }
}
