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
 * Creates Notification Handlers depended from the type of notification
 */
class BarzahlenNotificationHandlerFactory
{
    /**
     * @var BarzahlenNotificationValidator
     */
    private $validator;
    /**
     * @var BarzahlenTransactionRepository
     */
    private $orderBarzahlenRepository;
    /**
     * @var BarzahlenOrderStatusUpdater
     */
    private $statusUpdater;

    /**
     * @param BarzahlenNotificationValidator $validator
     * @param BarzahlenTransactionRepository $orderBarzahlenRepository
     * @param BarzahlenOrderStatusUpdater $statusUpdater
     */
    public function __construct($validator, $orderBarzahlenRepository, $statusUpdater)
    {
        $this->validator = $validator;
        $this->orderBarzahlenRepository = $orderBarzahlenRepository;
        $this->statusUpdater = $statusUpdater;
    }

    /**
     * Creates and returns an BarzahlenNotificationHandler from the given config
     *
     * @param string $state
     * @return BarzahlenNotificationHandler
     */
    public function create($state)
    {
        switch ($state) {
            case BarzahlenNotificationState::STATE_PAID;
                $handler = new BarzahlenNotificationHandlerPayment($this->validator, $this->statusUpdater);
                break;
            case BarzahlenNotificationState::STATE_EXPIRED:
                $handler = new BarzahlenNotificationHandlerPayment($this->validator, $this->statusUpdater);
                break;
            case BarzahlenNotificationState::STATE_REFUND_COMPLETED:
                $handler = new BarzahlenNotificationHandlerRefund($this->validator, $this->statusUpdater, $this->orderBarzahlenRepository);
                break;
            case BarzahlenNotificationState::STATE_REFUND_EXPIRED:
                $handler = new BarzahlenNotificationHandlerRefund($this->validator, $this->statusUpdater, $this->orderBarzahlenRepository);
                break;
            default:
                throw new RuntimeException("Unknown status");
        }

        return $handler;
    }
}
