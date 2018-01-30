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

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config	$config
	 */
	public function __construct(\phpbb\config\config $config)
	{
		$this->config = $config;
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

	public function get_username_by_id($user_id)
	{
		global $db;
		$sql = 'SELECT username FROM '.USERS_TABLE.' WHERE '.
			 $db->sql_build_array('SELECT', array('user_id' => $user_id));
		$result = $db->sql_query($sql);
		$username = $db->sql_fetchfield('username');
		$db->sql_freeresult($result);
		return $username;
	}
}
