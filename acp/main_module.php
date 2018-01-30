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
 * Provide "Telegram Notifications" pages in the ACP Extensions section.
 *
 * @package phpBB extension - Telegram notifications
 */
class main_module
{
	public $u_action;

	/**
	 * Show an ACP page and accept input from that page.
	 */
	public function main($id, $mode)
	{
		global $phpbb_container, $request, $template, $user;

		$user->add_lang('acp/common');
		$this->tpl_name = 'acp_telegramnotifications_' . strtolower($mode);
		$this->page_title = 'ACP_TELEGRAM_' . strtoupper($mode);
		$form_key = 'lassik/telegramnotifications';
		$controller = $phpbb_container->get(
			'lassik.telegramnotifications.acp.controller');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key($form_key))
			{
				trigger_error('FORM_INVALID');
			}
			$func = 'submit_' . $mode;
			$controller->$func();
			trigger_error(
				$user->lang('ACP_TELEGRAM_SETTINGS_UPDATED') .
				adm_back_link($u_action));
		}
		else
		{
			add_form_key($form_key);
			$template->assign_var('U_ACTION', $u_action);
			$func = 'display_' . $mode;
			$controller->$func();
		}
	}
}
