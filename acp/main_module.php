<?php
/**
 *
 * @package phpBB extension - Telegram notifications
 * @copyright (c) 2017 Lassi Kortela
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace lassik\telegramnotifications\acp;

/**
 * Provide a "Telegram IDs" page in the ACP Extensions section.
 *
 * @package phpBB extension - Telegram notifications
 */
class main_module
{
	public $u_action;

	/**
	 * Show the extension's ACP page and accept input from that page.
	 */
	public function main($id, $mode)
	{
		global $phpbb_container;

		$this->tpl_name = 'acp_telegramnotifications_' . strtolower($mode);
		$this->page_title = 'ACP_TELEGRAM_' . strtoupper($mode);
		$controller = $phpbb_container->get(
			'lassik.telegramnotifications.acp.controller');
		$controller->$mode($this->u_action);
	}
}
