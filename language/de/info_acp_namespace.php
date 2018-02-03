<?php
/**
 *
 * @package phpBB extension - Telegram notifications
 * @copyright (c) 2018 jan_2017
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_TELEGRAM_BOT_AUTH_TOKEN'	=> 'Telegram BOT - Autorisierungszeichen',
	'ACP_TELEGRAM_CHAT_ID'			=> 'Telegram Chat ID',
	'ACP_TELEGRAM_CONNECTION'		=> 'Telegram Verbindung',
	'ACP_TELEGRAM_ERROR'			=> 'Fehlermeldung',
	'ACP_TELEGRAM_FIND_CHAT_ID'		=> 'Finde Chat ID',
	'ACP_TELEGRAM_FOUND_CHAT_ID'	=> 'Es wurde folgende Chat ID gefunden',
	'ACP_TELEGRAM_INCLUDE_TEXT'		=> 'Füge den Text vom Anfang des Beitrages ein',
	'ACP_TELEGRAM_LAST_ERROR'		=> 'Letzte Fehlermeldung',
	'ACP_TELEGRAM_NOTIFICATIONS'	=> 'Telegram Benachrichtigungen',
	'ACP_TELEGRAM_NOTIFY_ABOUT'		=> 'Über Ereignisse benachrichtigen',
	'ACP_TELEGRAM_NOTIFY_CONTENT'	=> 'Benachrichtigungsinhalt',
	'ACP_TELEGRAM_NOTIFY_EDIT'		=> 'Bearbeitete Beiträge anzeigen (Wenn hierzu im Beitrag die Zeile "Grund für die Bearbeitung dieses Beitrags" angegeben wird)',
	'ACP_TELEGRAM_NOTIFY_REPLY'		=> 'Antworten auf vorhandene Themen',
	'ACP_TELEGRAM_NOTIFY_TOPIC'		=> 'Neue Themen',
	'ACP_TELEGRAM_NOTIFY_USER'		=> 'Neue Benutzer (wenn das Benutzerkonto aktiviert ist)',
	'ACP_TELEGRAM_SETTINGS'			=> 'Telegram Einstellungen',
	'ACP_TELEGRAM_SETTINGS_UPDATED'	=> 'Telegram Einstellungen wurden aktualisiert',
	'ACP_TELEGRAM_USE_CHAT_ID'		=> 'Verwende diese Chat-ID',
	'ACP_TELEGRAM_VERBOSE'			=> 'Ausführliche Benachrichtigungen',
));
