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
 * Checks current plugin version against the Barzahlen API
 */
class BarzahlenVersionCheck
{
    /**
     * @var BarzahlenPluginCheckConfigRepositoryInterface
     */
    private $configRepository;
    /**
     * @var BarzahlenPluginCheckRequest
     */
    private $versionCheckRequest;


    /**
     * @param BarzahlenPluginCheckConfigRepositoryInterface $configRepository
     * @param BarzahlenPluginCheckRequest $versionCheckRequest
     */
    public function __construct($configRepository, $versionCheckRequest)
    {
        $this->configRepository = $configRepository;
        $this->versionCheckRequest = $versionCheckRequest;
    }

    /**
     * Checks if an update for the module is available
     *
     * @param array $shopInfos
     * @param DateTime $now
     * @return bool
     */
    public function isUpdateAvailable($shopInfos, $now)
    {
        return
            $this->isModuleActivated() &&
            !$this->isCheckedInLastWeek($now) &&
            $this->isNewUpdateAvailable($shopInfos, $now);
    }

    /**
     * Checks if the module is activated in config
     *
     * @return bool
     */
    public function isModuleActivated()
    {
        return $this->configRepository->isModuleActivated();
    }

    /**
     * Checks if the module check was happened in last week
     *
     * @param DateTime $now
     * @return bool
     */
    public function isCheckedInLastWeek($now)
    {
        $lastCheckDate = $this->configRepository->getLastCheckDate();
        if ($lastCheckDate) {
            $diff = $lastCheckDate->diff($now);
            $isChecked = $diff->d < 7;
        } else {
            $isChecked = false;
        }
        return $isChecked;
    }

    /**
     * Performs the check request to the Barzahlen-API and returns if an update is available
     *
     * @param array $shopInfos
     * @param DateTime $now
     * @return bool
     */
    public function isNewUpdateAvailable($shopInfos, $now)
    {
        $this->versionCheckRequest->sendRequest($shopInfos, $this->configRepository->getShopConfig());
        $this->configRepository->updateLastRequestDate($now);
        return $this->versionCheckRequest->getPluginVersion() != $shopInfos['plugin_version'];
    }

    /**
     * @return string
     */
    public function getNewestVersion()
    {
        return $this->versionCheckRequest->getPluginVersion();
    }
}
