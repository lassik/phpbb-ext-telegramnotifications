<?php
/**
 *
 * @package phpBB extension - Telegram notifications
 * @copyright (c) 2018 Lassi Kortela
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * Brazilian Portuguese translation by eunaumtenhoid (c) 2017 [ver 0.5.0] (https://github.com/phpBBTraducoes)
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
	'TELEGRAM_BRIEF_EDIT'		=> 'Editar',
	'TELEGRAM_BRIEF_QUOTE'		=> 'Citar',
	'TELEGRAM_BRIEF_REPLY'		=> 'Re',
	'TELEGRAM_BRIEF_POST'		=> '',
	'TELEGRAM_BRIEF_USER'		=> 'Usuário ativado',
	'TELEGRAM_VERBOSE_EDIT'		=> 'post editado no tópico',
	'TELEGRAM_VERBOSE_QUOTE'	=> 'respondeu com citação no tópico',
	'TELEGRAM_VERBOSE_REPLY'	=> 'respondeu no tópico',
	'TELEGRAM_VERBOSE_POST'		=> 'Postou novo tópico',
	'TELEGRAM_VERBOSE_USER'		=> 'Usuário ativado no fórum',
));
