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
 * Creates a notification validator dependent from the type of notification
 */
class BarzahlenNotificationValidatorFactory
{
    /**
     * @var array
     */
    private $orderStatusMapStatusToId;

    /**
     * @param array $orderStatusMapStatusToId
     */
    public function __construct($orderStatusMapStatusToId)
    {
        $this->orderStatusMapStatusToId = $orderStatusMapStatusToId;
    }

    /**
     * Creates an BarzahlenNotificationValidator
     *
     * @param $state
     * @return BarzahlenNotificationValidator
     * @throws RuntimeException
     */
    public function create($state)
    {
        switch ($state) {
            case BarzahlenNotificationState::STATE_PAID:
                $validator = new BarzahlenNotificationValidatorPayment($this->orderStatusMapStatusToId);
                break;
            case BarzahlenNotificationState::STATE_EXPIRED:
                $validator = new BarzahlenNotificationValidatorPayment($this->orderStatusMapStatusToId);
                break;
            case BarzahlenNotificationState::STATE_REFUND_COMPLETED:
                $validator = new BarzahlenNotificationValidatorRefund($this->orderStatusMapStatusToId);
                break;
            case BarzahlenNotificationState::STATE_REFUND_EXPIRED:
                $validator = new BarzahlenNotificationValidatorRefund($this->orderStatusMapStatusToId);
                break;
            default:
                throw new RuntimeException("Unknown status");
        }

        return $validator;
    }
}