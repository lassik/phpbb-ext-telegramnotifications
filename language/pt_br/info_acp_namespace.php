<?php
/**
 *
 * @package phpBB extension - Telegram notifications
 * @copyright (c) 2017, 2018 Lassi Kortela
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
	'ACP_TELEGRAM_BOT_AUTH_TOKEN'	=> 'Token de autenticação do Telegram bot',
	'ACP_TELEGRAM_CHAT_ID'			=> 'ID do chat do Telegram',
	'ACP_TELEGRAM_CONNECTION'		=> 'Conexão do Telegram',
	'ACP_TELEGRAM_ERROR'			=> 'Mensagem de erro',
	'ACP_TELEGRAM_FIND_CHAT_ID'		=> 'Procurar ID de chat',
	'ACP_TELEGRAM_FOUND_CHAT_ID'	=> 'Encontrou o seguinte ID de chat',
	'ACP_TELEGRAM_INCLUDE_TEXT'		=> 'Incluir texto desde o início do post',
	'ACP_TELEGRAM_LAST_ERROR'		=> 'Último erro',
	'ACP_TELEGRAM_NOTIFICATIONS'	=> 'Notificações do Telegram',
	'ACP_TELEGRAM_NOTIFY_ABOUT'		=> 'Notificar sobre eventos',
	'ACP_TELEGRAM_NOTIFY_CONTENT'	=> 'Conteúdo de notificação',
	'ACP_TELEGRAM_NOTIFY_EDIT'		=> 'Posts editados (quando "razão para editar esta postagem" é fornecida)',
	'ACP_TELEGRAM_NOTIFY_REPLY'		=> 'Respostas aos tópicos existentes',
	'ACP_TELEGRAM_NOTIFY_TOPIC'		=> 'Novos tópicos',
	'ACP_TELEGRAM_NOTIFY_USER'		=> 'Novos usuários (quando a conta do usuário é ativada)',
	'ACP_TELEGRAM_SETTINGS'			=> 'Configurações do Telegram',
	'ACP_TELEGRAM_SETTINGS_UPDATED'	=> 'As configurações do Telegram foram atualizadas',
	'ACP_TELEGRAM_USE_CHAT_ID'		=> 'Use essa ID de chat',
	'ACP_TELEGRAM_VERBOSE'			=> 'Notificações verbais',
));
