<?php
/**
*
* @package phpBB extension - Telegram notifications
* @copyright (c) 2017 Lassi Kortela
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace lassik\telegramnotifications\acp;

class main_info
{
	function module()
	{
		return array(
			'filename'	=> '\lassik\telegramnotifications\acp\main_module',
			'title'		=> 'TELEGRAM NOTIFICATIONS',
			'modes'		=> array(
				'main'	=> array(
					'title'	=> 'Telegram IDs',
					'auth'	=> 'ext_lassik/telegramnotifications && acl_a_board',
					'cat'	=> array('TELEGRAM NOTIFICATIONS')
				),
			),
		);
	}
}
