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
$_['heading_list_orders'] = "Bestellungen";
$_['heading_list_refunds'] = "Rückgaben";

// Button
$_['button_list_orders'] = "Bestellungen";

// Text
$_['text_payment'] = "Zahlung";
$_['text_success'] = "Sie haben die Barzahlen Einstellugen geändert!";
$_['text_no_more_refunds_possible'] = "Es sind keine weiteren Rückgaben möglich!";

// Column
$_['column_transaction_id'] = "Barzahlen Transaktionsnr.";
$_['column_refund_transaction_id'] = "Barzahlen Rückgabe Transaktionsnr.";
$_['column_order_total_amount'] = "Bestellwert";
$_['column_total_refund_amount'] = "Gesamter Rückgabebetrag";
$_['column_amount'] = "Amount";

// Action
$_['action_refunds'] = "Rückgaben";
$_['action_cancel'] = "Abbrechen";
$_['action_resend_payment_slip'] = "Resend payment slip";

// Entry
$_['entry_status'] = "Status";
$_['entry_shop_id'] = "Shop ID";
$_['entry_payment_key'] = "Zahlungsschlüssel";
$_['entry_notification_key'] = "Benachrichtigungsschlüssel";
$_['entry_custom_variable1'] = "Benutzerdefinierte Variable 1";
$_['entry_custom_variable2'] = "Benutzerdefinierte Variable 2";
$_['entry_custom_variable3'] = "Benutzerdefinierte Variable 3";
$_['entry_minimum_amount'] = "Mindestbetrag";
$_['entry_maximum_amount'] = "Höchstbetrag";
$_['entry_countries'] = "Länder";
$_['entry_payment_currency'] = "Zahlungswährung";
$_['entry_sandbox'] = "Testmodus";
$_['entry_debug'] = "Erweitertes Logging";
$_['entry_failed_status_id'] = "Status: Bestellung fehlgeschlagen";
$_['entry_pending_status_id'] = "Status: Bestellung aufgegeben";
$_['entry_paid_status_id'] = "Status: Bestellung bezahlt";
$_['entry_expired_status_id'] = "Status: Bestellung abgelaufen";
$_['entry_refund_pending_status_id'] = "Status: Rückzahlung ausstehend";
$_['entry_refund_completed_status_id'] = "Status: Rückzahlung abeschlossen";
$_['entry_refund_expired_status_id'] = "Status: Rückzahlung abgelaufen";
$_['entry_sort_order'] = "Sort Order";

$_['entry_shop_id_help'] = "Ihre Barzahlen Shop ID";
$_['entry_payment_key_help'] = "Ihr Barzahlen Zahlungsschüssel";
$_['entry_notification_key_help'] = "Ihr Barzahlen Benachrichtigungsschlüssel";
$_['entry_minimum_amount_help'] = "Welcher Warenwert muss mindestens erreicht werden, damit Barzahlen als Zahlungsweise angeboten wird?";
$_['entry_maximum_amount_help'] = "Welcher Warenwert darf höchstens erreicht werden, damit Barzahlen als Zahlungsweise angeboten wird? (Max. 999.99 EUR)";
$_['entry_countries_help'] = "Aus welchen Ländern möchten Sie Zahlungen akzeptieren? (Momentan nur Deutschland.)";
$_['entry_payment_currency_help'] = "In welcher Währung sollen Zahlungen abgewickelt werden? (Momentan nur Euro.)";
$_['entry_sandbox_help'] = "Aktivieren Sie den Testmodus um Zahlungen über die Sandbox abzuwickeln.";
$_['entry_debug_help'] = "Aktivieren Sie Debugging für zusätzliches Logging.";
$_['entry_failed_status_id_help'] = "Status für Bestellungen die diese Zahlungsmethode verwenden und fehlgeschlagen sind.";
$_['entry_pending_status_id_help'] = "Status für Bestellungen die diese Zahlungsmethode verwenden und noch nicht bezahlt sind.";
$_['entry_paid_status_id_help'] = "Status für Bestellungen die diese Zahlungsmethode verwenden und bezahlt wurden.";
$_['entry_expired_status_id_help'] = "Status für Bestellungen die diese Zahlungsmethode verwenden und abgelaufen sind.";
$_['entry_refund_pending_status_id_help'] = "Status für Bestellungen die diese Zahlungsmethode verwenden und bei denen eine Rückzahlungen aussteht.";
$_['entry_refund_completed_status_id_help'] = "Status für Bestellungen die diese Zahlungsmethode verwenden und bei denen eine Rückzahlungen abgeschlossen ist.";
$_['entry_refund_expired_status_id_help'] = "Status für Bestellungen die diese Zahlungsmethode verwenden und bei denen eine Rückzahlungen abgelaufen ist.";

// Error
$_['error_permission'] = "Warung: Sie haben keine Berechtigung die Barzahlen Einstellungen zu ändern!";
$_['error_missing_shop_id'] = "Geben Sie eine Shop ID an!";
$_['error_missing_payment_key'] = "Geben Sie einen Zahlungsschlüssel an!";
$_['error_missing_notification_key'] = "Geben Sie einen Benachrichtigungsschlüssel an!";
$_['error_maximum_amount_to_big'] = "Der Höchstbetrag ist 999.99 EUR!";
$_['error_resend_payment_slip'] = "Fehler beim erneuten Senden des Zahlscheins. Prüfen Sie das Log!";
$_['error_cancel_transaction'] = "Fehler beim erneuten Stornieren der Transaktion. Prüfen Sie das Log!";
$_['error_create_refund'] = "Fehler beim Erstellen der Rückgabe-Transaktion. Prüfen Sie das Log!";

// Success
$_['success_resend_payment_slip'] = "Erneutes Senden des Zahlscheins erfolgreich!";
$_['success_cancel_transaction'] = "Stornierung der Transaktion erfolgreich!";
$_['success_create_refund'] = "Erstellen der Rückgabe-Transaktion erfolgreich!";

// Infos
$_['new_version_available'] = "Barzahlen Update: %s! Verfügbar auf <a href=\"http://www.barzahlen.de/partner/integration/shopsysteme/15/opencart\">Barzahlen.de</a>";
