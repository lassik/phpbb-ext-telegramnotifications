<?php
/**
 *
 * @package phpBB extension - Telegram notifications
 * @copyright (c) 2017, 2018 Lassi Kortela
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
	'ACP_TELEGRAM_BOT_AUTH_TOKEN'	=> 'Telegram bot auth token',
	'ACP_TELEGRAM_CHAT_ID'			=> 'Telegram chat ID',
	'ACP_TELEGRAM_CONNECTION'		=> 'Telegram connection',
	'ACP_TELEGRAM_ERROR'			=> 'Error message',
	'ACP_TELEGRAM_FIND_CHAT_ID'		=> 'Find chat ID',
	'ACP_TELEGRAM_FOUND_CHAT_ID'	=> 'Found the following chat ID',
	'ACP_TELEGRAM_LAST_ERROR'		=> 'Last error',
	'ACP_TELEGRAM_NOTIFICATIONS'	=> 'Telegram Notifications',
	'ACP_TELEGRAM_SETTINGS'			=> 'Telegram settings',
	'ACP_TELEGRAM_SETTINGS_UPDATED'	=> 'Telegram settings have been updated',
	'ACP_TELEGRAM_USE_CHAT_ID'		=> 'Use this chat ID',
));
