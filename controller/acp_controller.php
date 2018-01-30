<?php
/**
 *
 * @package phpBB extension - Telegram notifications
 * @copyright (c) 2017, 2018 Lassi Kortela
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace lassik\telegramnotifications\controller;

class acp_controller
{
	/** @var \lassik\telegramnotifications\core\functions */
	protected $functions;

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
	 * @param \lassik\telegramnotifications\core\functions	$functions
	 * @param \phpbb\config\config				$config
	 * @param \phpbb\language\language			$language
	 * @param \phpbb\template\template			$template
	 * @param \phpbb\request\request_interface	$request
	 */
	public function __construct(
		\lassik\telegramnotifications\core\functions $functions,
		\phpbb\config\config			  $config,
		\phpbb\language\language		  $language,
		\phpbb\template\template		  $template,
		\phpbb\request\request_interface  $request
	)
	{
		$this->functions = $functions;
		$this->config	 = $config;
		$this->language	 = $language;
		$this->template	 = $template;
		$this->request	 = $request;
	}

	/**
	 * Handle the "Telegram settings" ACP page.
	 *
	 * @param string $u_action
	 */
	public function settings($u_action)
	{
		add_form_key('lassik/telegramnotifications');

		$varnames = array('lassik_telegram_bot_auth_token',
						  'lassik_telegram_chat_id');

		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key('lassik/telegramnotifications'))
			{
				trigger_error('FORM_INVALID');
			}

			foreach ($varnames as $var)
			{
				$this->config->set($var, $this->request->variable($var, ''));
			}

			$this->config->set('lassik_telegram_last_error', '');

			trigger_error($this->language->lang('ACP_TELEGRAM_SETTINGS_UPDATED') .
						  adm_back_link($this->u_action));
		}

		$tvars = array(
			'U_ACTION' =>
			$u_action,

			'LASSIK_TELEGRAM_LAST_ERROR' =>
			$this->config['lassik_telegram_last_error']
		);
		foreach ($varnames as $var)
		{
			$tvars[strtoupper($var)] = $this->config[$var];
		}
		$this->template->assign_vars($tvars);
	}

	/**
	 * Handle the "Find chat ID" ACP page.
	 *
	 * @param string $u_action
	 */
	public function find_chat_id($u_action)
	{
		add_form_key('lassik/telegramnotifications');

		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key('lassik/telegramnotifications'))
			{
				trigger_error('FORM_INVALID');
			}

			$this->config->set('lassik_telegram_chat_id',
							   $this->request->variable(
								   'lassik_telegram_chat_id',
								   ''));

			$this->config->set('lassik_telegram_last_error', '');

			trigger_error($this->language->lang('ACP_TELEGRAM_SETTINGS_UPDATED') .
						  adm_back_link($this->u_action));
		}

		list($chat_id, $chat_desc) = $this->functions->parse_chat_id(
			$this->functions->call_telegram_bot_api('getUpdates', array()));

		$this->template->assign_vars(array(
			'U_ACTION' =>
			$u_action,

			'LASSIK_TELEGRAM_CHAT_ID' =>
			$chat_id,

			'LASSIK_TELEGRAM_CHAT_DESC' =>
			$chat_desc,

			'LASSIK_TELEGRAM_LAST_ERROR' =>
			$this->config['lassik_telegram_last_error'],

		));
	}
}
