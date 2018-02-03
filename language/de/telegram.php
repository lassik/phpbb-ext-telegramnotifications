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
	'TELEGRAM_BRIEF_EDIT'		=> 'Bearbeitet',
	'TELEGRAM_BRIEF_QUOTE'		=> 'Zitat',
	'TELEGRAM_BRIEF_REPLY'		=> 'Antwort',
	'TELEGRAM_BRIEF_POST'		=> '',
	'TELEGRAM_BRIEF_USER'		=> 'Neuer Benutzer freigeschaltet',
	'TELEGRAM_VERBOSE_EDIT'		=> 'bearbeitete Beitrag in Thema',
	'TELEGRAM_VERBOSE_QUOTE'	=> 'antwortete mit Zitat in Beitrag',
	'TELEGRAM_VERBOSE_REPLY'	=> 'antwortete in Thema',
	'TELEGRAM_VERBOSE_POST'		=> 'schrieb ein neues Thema',
	'TELEGRAM_VERBOSE_USER'		=> 'Neuer Benutzer wurde freigeschaltet',
));
