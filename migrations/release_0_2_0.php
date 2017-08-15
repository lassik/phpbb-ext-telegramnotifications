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
class release_0_2_0 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['lassik_telegram_last_error']);
	}

	static public function depends_on()
	{
		return array('\lassik\telegramnotifications\migrations\release_0_1_0');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('lassik_telegram_last_error', '')),
		);
	}
}
