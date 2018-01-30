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
	'TELEGRAM_BRIEF_EDIT'		=> 'Edit',
	'TELEGRAM_BRIEF_QUOTE'		=> 'Quote',
	'TELEGRAM_BRIEF_REPLY'		=> 'Re',
	'TELEGRAM_BRIEF_POST'		=> '',
	'TELEGRAM_BRIEF_USER'		=> 'User activated',
	'TELEGRAM_VERBOSE_EDIT'		=> 'edited post in topic',
	'TELEGRAM_VERBOSE_QUOTE'	=> 'replied with quote in topic',
	'TELEGRAM_VERBOSE_REPLY'	=> 'replied in topic',
	'TELEGRAM_VERBOSE_POST'		=> 'posted new topic',
	'TELEGRAM_VERBOSE_USER'		=> 'User activated in forum',
));
