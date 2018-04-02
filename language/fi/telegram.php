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
	'TELEGRAM_BRIEF_EDIT'		=> 'Muokkaus',
	'TELEGRAM_BRIEF_QUOTE'		=> 'Lainaus',
	'TELEGRAM_BRIEF_REPLY'		=> 'VS',
	'TELEGRAM_BRIEF_POST'		=> '',
	'TELEGRAM_BRIEF_USER'		=> 'Käyttäjä aktivoitu',
	'TELEGRAM_VERBOSE_EDIT'		=> 'muokkasi viestiä ketjussa',
	'TELEGRAM_VERBOSE_QUOTE'	=> 'vastasi lainauksella ketjussa',
	'TELEGRAM_VERBOSE_REPLY'	=> 'vastasi ketjussa',
	'TELEGRAM_VERBOSE_POST'		=> 'aloitti uuden ketjun',
	'TELEGRAM_VERBOSE_USER'		=> 'Käyttäjä aktivoitu foorumilla',
));
