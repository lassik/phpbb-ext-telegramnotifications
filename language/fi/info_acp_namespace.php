<?php
/**
 *
 * @package phpBB extension - Telegram notifications
 * @copyright (c) 2018 Lassi Kortela
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
	'ACP_TELEGRAM_BOT_AUTH_TOKEN'	=> 'Telegram-botin auth token',
	'ACP_TELEGRAM_CHAT_ID'			=> 'Telegram chat ID',
	'ACP_TELEGRAM_CONNECTION'		=> 'Telegram-yhteys',
	'ACP_TELEGRAM_ERROR'			=> 'Status',
	'ACP_TELEGRAM_FIND_CHAT_ID'		=> 'Etsi chat ID',
	'ACP_TELEGRAM_FOUND_CHAT_ID'	=> 'Löydettiin seuraava chat ID',
	'ACP_TELEGRAM_INCLUDE_TEXT'		=> 'Sisällytä tekstiä viestin alusta',
	'ACP_TELEGRAM_LAST_ERROR'		=> 'Viimeisen yhteydenoton status',
	'ACP_TELEGRAM_NOTIFICATIONS'	=> 'Telegram-ilmoitukset',
	'ACP_TELEGRAM_NOTIFY_ABOUT'		=> 'Mistä ilmoitetaan',
	'ACP_TELEGRAM_NOTIFY_CONTENT'	=> 'Ilmoituksen sisältö',
	'ACP_TELEGRAM_NOTIFY_EDIT'		=> 'Muokatut viestit (kun viestin muokkauksen syy on annettu)',
	'ACP_TELEGRAM_NOTIFY_REPLY'		=> 'Vastaukset viestiketjuihin',
	'ACP_TELEGRAM_NOTIFY_TOPIC'		=> 'Uudet viestiketjut',
	'ACP_TELEGRAM_NOTIFY_USER'		=> 'Uudet käyttäjät (kun käyttäjätili on aktivoitu)',
	'ACP_TELEGRAM_SETTINGS'			=> 'Telegram-asetukset',
	'ACP_TELEGRAM_SETTINGS_UPDATED'	=> 'Telegram-asetukset on tallennettu',
	'ACP_TELEGRAM_USE_CHAT_ID'		=> 'Käytä tätä chat ID:tä',
	'ACP_TELEGRAM_VERBOSE'			=> 'Helppotajuisemmat ilmoitukset',
));
