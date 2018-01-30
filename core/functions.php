<?php
/**
 *
 * @package phpBB extension - Telegram notifications
 * @copyright (c) 2017, 2018 Lassi Kortela
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace lassik\telegramnotifications\core;

class functions
{
	/* @var \phpbb\controller\helper */
	protected $config;

	/** @var \phpbb\language\language */
	protected $language;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config		$config
	 * @param \phpbb\language\language	$language
	 */
	public function __construct(
		\phpbb\config\config		$config,
		\phpbb\language\language	$language
	)
	{
		$this->config	= $config;
		$this->language	= $language;
		$this->language->add_lang('telegram', 'lassik/telegramnotifications');
	}

	/**
	 * Set the last error message that we display in the ACP so users
	 * can see what went wrong if the extension doesn't work for them.
	 */
	private function set_last_error($errmsg)
	{
		$this->config->set('lassik_telegram_last_error',
						   $errmsg.' ('.date(DATE_RFC2822).')');
	}

	/**
	 * Call the given endpoint of the Telegram bot API.
	 *
	 * Returns decoded JSON on success, NULL on failure. Updates the
	 * last error message in any case.
	 */
	public function call_telegram_bot_api($endpoint, $query)
	{
		$auth = $this->config['lassik_telegram_bot_auth_token'];
		if (empty($auth))
		{
			$this->set_last_error('Telegram bot auth token not filled in');
			return NULL;
		}
		$url = 'https://api.telegram.org/bot'.urlencode($auth).'/'.
			 urlencode($endpoint);
		if (!function_exists('curl_version'))
		{
			$this->set_last_error('PHP cURL support is not enabled');
			return NULL;
		}
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($query));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_FAILONERROR, false);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		$result = curl_exec($curl);
		$curl_error = curl_error($curl);
		curl_close($curl);
		if ($result === false)
		{
			$this->set_last_error($curl_error);
			return NULL;
		}
		$result_json = json_decode($result, true);
		if ($result_json === NULL)
		{
			$this->set_last_error('JSON '.json_last_error_msg());
			return NULL;
		}
		if ($result_json['ok'] !== TRUE)
		{
			$this->set_last_error($result_json['description']);
			return NULL;
		}
		$this->set_last_error('Success');
		return $result_json;
	}

	/**
	 * Send a message to a Telegram group chat or user. The message
	 * will look as though it comes from the Telegram bot (which must
	 * have been invited to the group).
	 *
	 * A very bare-bones HTML subset is used to format the message.
	 * Links and bold are supported. Tags cannot be nested. Remember
	 * to escape plain text using htmlspecialchars().
	 *
	 * The Telegram bot's auth token as well as the target chat ID are
	 * retrieved from the phpBB configuration. Note that group chat
	 * IDs are negative numbers. The function will fail unless both
	 * configuration parameters are set.
	 *
	 * PHP's curl API is used to make a HTTPS connection to the
	 * Telegram API. The function will fail if curl support is not
	 * available.
	 */
	public function send_html_message_as_telegram_bot($html)
	{
		$chat_id = $this->config['lassik_telegram_chat_id'];
		if (empty($chat_id))
		{
			$this->set_last_error('Telegram chat ID not filled in');
			return NULL;
		}
		return $this->call_telegram_bot_api('sendMessage', array(
			'chat_id' => $chat_id,
			'disable_web_page_preview' => 'true',
			'parse_mode' => 'HTML',
			'text' => $html,
		));
	}

	public function parse_chat_id($json)
	{
		$ans = array(NULL, 'No chat found');
		if (is_array($json))
		{
			foreach ($json['result'] as $update)
			{
				$chat = $update['message']['chat'];
				if ($chat)
				{
					$ans = array($chat['id'], $this->parse_chat_desc($chat));
				}
			}
		}
		return $ans;
	}

	private function parse_chat_desc($chat)
	{
		$ans = 'Unknown chat';
		if ($chat['type'])
		{
			$ans = ucfirst($chat['type']).': ';
			foreach (array('title', 'first_name', 'last_name', 'username')
					 as $field)
			{
				if ($chat[$field])
				{
					$ans = $ans.' '.$chat[$field];
				}
			}
		}
		return $ans;
	}

	private function translation($mode, $verbose)
	{
		$langprefix = $verbose ? 'TELEGRAM_VERBOSE_' : 'TELEGRAM_BRIEF_';
		$langvar = $langprefix.strtoupper($mode);
		$what = $this->language->lang($langvar);
		$what = ($what == $langvar) ? '' : $what;
		$what = empty($what) ? '' : $what;
		return $what;
	}

	/**
	 * Given a phpBB event mode string (post, reply, quote, edit),
	 * return a human-readable string (like an email subject prefix)
	 * that indicates what happened to the topic.
	 */
	public function prefix_for_post_mode($mode, $username)
	{
		$verbose = $this->get_bool_config_var('lassik_telegram_verbose');
		$what = $this->translation($mode, $verbose);
		$what = empty($what) ? '' : $what.': ';
		if ($verbose)
		{
			return $username.' '.$what;
		}
		else
		{
			return '['.$username.'] '.$what;
		}
	}

	private function should_notify_about_post_mode($mode)
	{
		switch ($mode) {
		case 'post':	$var = 'lassik_telegram_notify_topic'; break;
		case 'reply':	$var = 'lassik_telegram_notify_reply'; break;
		case 'quote':	$var = 'lassik_telegram_notify_reply'; break;
		case 'edit':	$var = 'lassik_telegram_notify_edit';  break;
		default:        return false;
		}
		return $this->get_bool_config_var($var);
	}

	public function notify_about_post($url, $username, $mode, $title, $extra)
	{
		if (!$this->should_notify_about_post_mode($mode))
		{
			return;
		}
		$html = htmlspecialchars($this->prefix_for_post_mode($mode, $username)).
			  '<a href="'.htmlspecialchars($url).'">'.
			  htmlspecialchars($title).
			  '</a>';
		if (!empty($extra))
		{
			$html .= ' - '.htmlspecialchars($extra);
		}
		$this->send_html_message_as_telegram_bot($html);
	}

	public function notify_about_user_activation($username)
	{
		$what = $this->translation(
			'user', $this->get_bool_config_var('lassik_telegram_verbose'));
		$this->send_html_message_as_telegram_bot(htmlspecialchars(
			$what.': '.$username));
	}

	public function get_bool_config_var($var)
	{
		return (((string)($this->config[$var])) === '1');
	}

	private function get_string_from_db($table, $wanted_column, $where)
	{
		global $db;
		$sql = 'SELECT '.$wanted_column.' FROM '.$table.' WHERE '.
			 $db->sql_build_array('SELECT', $where);
		$result = $db->sql_query($sql);
		$ans = $db->sql_fetchfield($wanted_column);
		$db->sql_freeresult($result);
		return $ans;
	}

	public function get_username_by_id($user_id)
	{
		return $this->get_string_from_db(
			USERS_TABLE, 'username', array('user_id' => $user_id));
	}
}
