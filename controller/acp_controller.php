<?php
/**
 *
 * @package phpBB extension - Telegram notifications
 * @copyright (c) 2017 Lassi Kortela
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace lassik\telegramnotifications\controller;

class acp_controller
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var phpbb\request\request_interface */
	protected $request;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config				$config
	 * @param \phpbb\language\language			$language
	 * @param \phpbb\template\template			$template
	 * @param \phpbb\request\request_interface	$request
	 */
	public function __construct(
		\phpbb\config\config			  $config,
		\phpbb\language\language		  $language,
		\phpbb\template\template		  $template,
		\phpbb\request\request_interface  $request
	)
	{
		$this->config	= $config;
		$this->language = $language;
		$this->template	= $template;
		$this->request	= $request;
	}

	/**
	 * Handle the "Telegram Settings" ACP page.
	 *
	 * @param string $u_action
	 */
	public function settings($u_action)
	{
		add_form_key('lassik/telegramnotifications');

		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key('lassik/telegramnotifications'))
			{
				trigger_error('FORM_INVALID');
			}

			$this->config->set('lassik_telegram_bot_auth_token',
							   $this->request->variable(
								   'lassik_telegram_bot_auth_token',
								   ''));

			$this->config->set('lassik_telegram_chat_id',
							   $this->request->variable(
								   'lassik_telegram_chat_id',
								   ''));

			$this->config->set('lassik_telegram_last_error', '');

			trigger_error($this->language->lang('ACP_TELEGRAM_SETTINGS_UPDATED') .
						  adm_back_link($this->u_action));
		}

		$this->template->assign_vars(array(
			'U_ACTION' =>
			$u_action,

			'LASSIK_TELEGRAM_BOT_AUTH_TOKEN' =>
			$this->config['lassik_telegram_bot_auth_token'],

			'LASSIK_TELEGRAM_CHAT_ID' =>
			$this->config['lassik_telegram_chat_id'],

			'LASSIK_TELEGRAM_LAST_ERROR' =>
			$this->config['lassik_telegram_last_error'],
		));
	}
}
