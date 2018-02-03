<?php
/**
 *
 * @package phpBB extension - Telegram notifications
 * @copyright (c) 2018 Lassi Kortela
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace lassik\telegramnotifications\migrations;

/**
 * @package phpBB extension - Telegram notifications
 */
class release_0_6_0 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\lassik\telegramnotifications\migrations\release_0_5_0');
	}

	public function effectively_installed()
	{
		return (isset($this->config['lassik_telegram_version']) &&
				phpbb_version_compare($this->config['lassik_telegram_version'],
									  '0.6.0', '>='));
	}

	public function update_data()
	{
		return array(
			array('config.update', array('lassik_telegram_version', '0.6.0')),
		);
	}
}
