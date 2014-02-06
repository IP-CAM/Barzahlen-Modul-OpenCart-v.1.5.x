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

// Heading
$_['heading_title'] = "Barzahlen";
$_['heading_list_orders'] = "Orders";
$_['heading_list_refunds'] = "Refunds";

// Button
$_['button_list_orders'] = "Orders";

// Text
$_['text_payment'] = "Payment";
$_['text_success'] = "Success: You have modified Barzahlen account details!";
$_['text_no_more_refunds_possible'] = "No more refunds possible!";

// Column
$_['column_transaction_id'] = "Barzahlen Transaction ID";
$_['column_refund_transaction_id'] = "Barzahlen Refund Transaction ID";
$_['column_order_total_amount'] = "Total Order Amount";
$_['column_total_refund_amount'] = "Total Refund Amount";
$_['column_amount'] = "Amount";

// Action
$_['action_refunds'] = "Refunds";
$_['action_cancel'] = "Cancel";
$_['action_resend_payment_slip'] = "Resend payment slip";

// Entry
$_['entry_status'] = "Status";
$_['entry_shop_id'] = "Shop ID";
$_['entry_payment_key'] = "Payment Key";
$_['entry_notification_key'] = "Notification Key";
$_['entry_custom_variable1'] = "Custom Variable 1";
$_['entry_custom_variable2'] = "Custom Variable 2";
$_['entry_custom_variable3'] = "Custom Variable 3";
$_['entry_minimum_amount'] = "Minimum Amount";
$_['entry_maximum_amount'] = "Maximum Amount";
$_['entry_countries'] = "Countries";
$_['entry_payment_currency'] = "Payment Currency";
$_['entry_sandbox'] = "Sandbox";
$_['entry_debug'] = "Extended Logging";
$_['entry_failed_status_id'] = "Status: Order failed";
$_['entry_pending_status_id'] = "Status: Order confirmed";
$_['entry_paid_status_id'] = "Status: Order paid";
$_['entry_expired_status_id'] = "Status: Order expired";
$_['entry_refund_pending_status_id'] = "Status: Refund pending";
$_['entry_refund_completed_status_id'] = "Status: Refund completed";
$_['entry_refund_expired_status_id'] = "Status: Refund expired";
$_['entry_sort_order'] = "Sort Order";

$_['entry_shop_id_help'] = "Your Barzahlen Shop ID";
$_['entry_payment_key_help'] = "Your Barzahlen Payment Key";
$_['entry_notification_key_help'] = "Your Barzahlen Notification Key";
$_['entry_minimum_amount_help'] = "Which is the lowest cart amount to order with Barzahlen?";
$_['entry_maximum_amount_help'] = "Which is the highest cart amount to order with Barzahlen? (Max. 999.99 EUR)";
$_['entry_countries_help'] = "From which countries do you want to accept payments? (Germany only, at the moment.)";
$_['entry_payment_currency_help'] = "In which currency payments and refunds should be handled? (At the moment Euro only.)";
$_['entry_sandbox_help'] = "Activate the test mode to process Barzahlen payments via sandbox.";
$_['entry_debug_help'] = "Activate debugging for additional logging.";
$_['entry_failed_status_id_help'] = "Order will get this status if request can't be transferred to Barzahlen.";
$_['entry_pending_status_id_help'] = "Order will get this status if request is successfully transferred to Barzahlen.";
$_['entry_paid_status_id_help'] = "Order will get this status if it is paid via Barzahlen.";
$_['entry_expired_status_id_help'] = "Order will get this status if the payment is expired from Barzahlen.";
$_['entry_refund_pending_status_id_help'] = "Status which the order must have for handling refund notifications.";
$_['entry_refund_completed_status_id_help'] = "Order will get this status if a refund via Barzahlen is completed.";
$_['entry_refund_expired_status_id_help'] = "Status for refund order which are using this payment method and where the refund is expired.";

// Error
$_['error_permission'] = "Warning: You do not have permission to modify payment Barzahlen!";
$_['error_missing_shop_id'] = "Shop ID required!";
$_['error_missing_payment_key'] = "Payment Key required!";
$_['error_missing_notification_key'] = "Notification Key required!";
$_['error_maximum_amount_to_big'] = "Maximum amount is 999.99 EUR!";
$_['error_resend_payment_slip'] = "Error while resending payment slip. Check your logs!";
$_['error_cancel_transaction'] = "Error while canceling transaction. Check your logs!";
$_['error_create_refund'] = "Error while create refund transaction. Check your logs!";

// Success
$_['success_resend_payment_slip'] = "Resending payment slip successful!";
$_['success_cancel_transaction'] = "Cancel transaction successful!";
$_['success_create_refund'] = "Create refund transaction successful!";

// Infos
$_['new_version_available'] = "Barzahlen Update: %s! Available on <a href=\"http://www.barzahlen.de/partner/integration/shopsysteme/15/opencart\">Barzahlen.de</a>";
