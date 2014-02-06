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

class BarzahlenVersionCheckTest extends PHPUnit_Framework_TestCase
{
    private $configRepository;
    private $versionCheckRequest;
    private $now;
    private $shopInfos;

    public function setUp()
    {
        $this->configRepository = $this->getMock("BarzahlenPluginCheckConfigRepositoryInterface",
            array("isModuleActivated", "getLastCheckDate", "getShopConfig", "updateLastRequestDate"), array(), "", false);

        $this->versionCheckRequest = $this->getMock("BarzahlenPluginCheckRequest",
            array("sendRequest", "getPluginVersion"), array(), "", false);

        $this->now = new DateTime("2013-01-01");
        $this->shopInfos = array(
            'shopsystem' => "foobar",
            'shopsystem_version' => "2.0.0",
            'plugin_version' => "1.5.0",
        );
    }

    private function createVersionCheck()
    {
        return new BarzahlenVersionCheck($this->configRepository, $this->versionCheckRequest);
    }

    public function testIsModuleActivatedReturnsCorrectValue()
    {
        $expectedIsModuleActivated = true;

        $this->configRepository
            ->expects($this->any())
            ->method('isModuleActivated')
            ->will($this->returnValue($expectedIsModuleActivated));

        $versionCheck = $this->createVersionCheck();
        $isModuleActivated = $versionCheck->isModuleActivated();

        $this->assertEquals($expectedIsModuleActivated, $isModuleActivated);
    }

    public function testIsCheckedInLastWeekReturnsFalseWhenNeverChecked()
    {
        $this->configRepository
            ->expects($this->any())
            ->method('getLastCheckDate')
            ->will($this->returnValue(false));

        $versionCheck = $this->createVersionCheck();
        $isCheckedInLastWeek = $versionCheck->isCheckedInLastWeek($this->now);

        $this->assertFalse($isCheckedInLastWeek);
    }

    public function testIsCheckedInLastWeekReturnsFalseWhenLastCheckIsMoreThanOneWeekAgo()
    {
        $lastCheck = new DateTime("2013-01-01");
        $this->now = new DateTime("2013-01-08");

        $this->configRepository
            ->expects($this->any())
            ->method('getLastCheckDate')
            ->will($this->returnValue($lastCheck));

        $versionCheck = $this->createVersionCheck();
        $isCheckedInLastWeek = $versionCheck->isCheckedInLastWeek($this->now);

        $this->assertFalse($isCheckedInLastWeek);
    }

    public function testIsCheckedInLastWeekReturnsTrueWhenLastCheckIsLesserThanOneWeekAgo()
    {
        $lastCheck = new DateTime("2013-01-01");
        $this->now = new DateTime("2013-01-03");

        $this->configRepository
            ->expects($this->any())
            ->method('getLastCheckDate')
            ->will($this->returnValue($lastCheck));

        $versionCheck = $this->createVersionCheck();
        $isCheckedInLastWeek = $versionCheck->isCheckedInLastWeek($this->now);

        $this->assertTrue($isCheckedInLastWeek);
    }

    public function testIsNewUpdateAvailableReturnsFalseWhenNoNewVersionIsAvailable()
    {
        $this->versionCheckRequest
            ->expects($this->any())
            ->method('getPluginVersion')
            ->will($this->returnValue($this->shopInfos['plugin_version']));

        $versionCheck = $this->createVersionCheck();
        $isNewUpdateAvailable = $versionCheck->isNewUpdateAvailable($this->shopInfos, $this->now);

        $this->assertFalse($isNewUpdateAvailable);
    }

    public function testIsNewUpdateAvailableReturnsTrueWhenNewVersionIsAvailable()
    {
        $this->versionCheckRequest
            ->expects($this->any())
            ->method('getPluginVersion')
            ->will($this->returnValue("1.6.0"));

        $versionCheck = $this->createVersionCheck();
        $isNewUpdateAvailable = $versionCheck->isNewUpdateAvailable($this->shopInfos, $this->now);

        $this->assertTrue($isNewUpdateAvailable);
    }

    public function testGetNewestVersionReturnsVersionFromVersionRequest()
    {
        $expectedNewestVersion = "1.6.0";

        $this->versionCheckRequest
            ->expects($this->any())
            ->method('getPluginVersion')
            ->will($this->returnValue($expectedNewestVersion));

        $versionCheck = $this->createVersionCheck();
        $newestVersion = $versionCheck->getNewestVersion();

        $this->assertEquals($expectedNewestVersion, $newestVersion);
    }

    public function testIsUpdateAvailableReturnsTrueIfEveryConditionIsTrue()
    {
        $lastCheck = new DateTime("2013-01-01");
        $this->now = new DateTime("2013-01-08");

        $this->configRepository
            ->expects($this->any())
            ->method('isModuleActivated')
            ->will($this->returnValue(true));

        $this->configRepository
            ->expects($this->any())
            ->method('getLastCheckDate')
            ->will($this->returnValue($lastCheck));

        $this->versionCheckRequest
            ->expects($this->any())
            ->method('getPluginVersion')
            ->will($this->returnValue("1.6.0"));

        $versionCheck = $this->createVersionCheck();
        $isUpdateAvailable = $versionCheck->isUpdateAvailable($this->shopInfos, $this->now);

        $this->assertTrue($isUpdateAvailable);
    }
}
