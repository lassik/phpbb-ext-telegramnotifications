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

	private $config_vars = array(
		'lassik_telegram_bot_auth_token',
		'lassik_telegram_chat_id');

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
	 * Save settings from the "Telegram settings" ACP page.
	 */
	public function submit_settings()
	{
		foreach ($this->config_vars as $var)
		{
			$this->config->set($var, $this->request->variable($var, ''));
		}
		$this->config->set('lassik_telegram_last_error', '');
	}

	/**
	 * Display the "Telegram settings" ACP page.
	 */
	public function display_settings()
	{
		foreach ($this->config_vars as $var)
		{
			$this->template->assign_var(strtoupper($var), $this->config[$var]);
		}
		$this->template->assign_var(
			'LASSIK_TELEGRAM_LAST_ERROR',
			$this->config['lassik_telegram_last_error']);
	}

	/**
	 * Save settings from the "Find chat ID" ACP page.
	 */
	public function submit_find_chat_id()
	{
		$this->config->set(
			'lassik_telegram_chat_id',
			$this->request->variable('lassik_telegram_chat_id', ''));
		$this->config->set('lassik_telegram_last_error', '');
	}

	/**
	 * Display the "Find chat ID" ACP page.
	 */
	public function display_find_chat_id()
	{
		list($chat_id, $chat_desc) = $this->functions->parse_chat_id(
			$this->functions->call_telegram_bot_api('getUpdates', array()));
		$this->template->assign_var('LASSIK_TELEGRAM_CHAT_ID', $chat_id);
		$this->template->assign_var('LASSIK_TELEGRAM_CHAT_DESC', $chat_desc);
		$this->template->assign_var(
			'LASSIK_TELEGRAM_LAST_ERROR',
			$this->config['lassik_telegram_last_error']);
	}
}
