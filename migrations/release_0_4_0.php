<?php
/**
 *
 * @package phpBB extension - Telegram notifications
 * @copyright (c) 2017 Lassi Kortela
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace lassik\telegramnotifications\migrations;

/**
 * @package phpBB extension - Telegram notifications
 */
class release_0_4_0 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\lassik\telegramnotifications\migrations\release_0_2_0');
	}

	public function update_data()
	{
		return array(
			array('module.remove', array(
				'acp',
				'ACP_TELEGRAM_NOTIFICATIONS',
				array(
					'module_basename' => '\lassik\telegramnotifications\acp\main_module',
				),
			)),
			array('module.add', array(
				'acp',
				'ACP_TELEGRAM_NOTIFICATIONS',
				array(
					'module_basename' => '\lassik\telegramnotifications\acp\main_module',
					'modes' => array('telegram_ids', 'find_chat_id'),
				),
			)),
		);
	}
}
