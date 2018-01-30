<?php
/**
 *
 * @package phpBB extension - Telegram notifications
 * @copyright (c) 2017, 2018 Lassi Kortela
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace lassik\telegramnotifications\acp;

/**
 * @package phpBB extension - Telegram notifications
 */
class main_info
{
	function module()
	{
		return array(
			'filename'	=> '\lassik\telegramnotifications\acp\main_module',
			'title'		=> 'ACP_TELEGRAM_NOTIFICATIONS',
			'modes'		=> array(
				'settings' => array(
					'title' => 'ACP_TELEGRAM_SETTINGS',
					'auth'	=> 'ext_lassik/telegramnotifications && acl_a_board',
					'cat'	=> array('ACP_TELEGRAM_NOTIFICATIONS'),
				),
				'find_chat_id' => array(
					'title' => 'ACP_TELEGRAM_FIND_CHAT_ID',
					'auth'	=> 'ext_lassik/telegramnotifications && acl_a_board',
					'cat'	=> array('ACP_TELEGRAM_NOTIFICATIONS'),
				),
			),
		);
	}
}
