<?php
/**
 *
 * @package phpBB extension - Telegram notifications
 * @copyright (c) 2017 Lassi Kortela
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace lassik\telegramnotifications\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 *
 * @package phpBB extension - Telegram notifications
 */
class main_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.submit_post_end' => 'handle_submit_post_end',
		);
	}

	/* @var \phpbb\controller\helper */
	protected $config;

	/**
	 * Constructor
	 *
	 * @param \phpbb\config\config	$config	 Configuration object
	 */
	public function __construct(\phpbb\config\config $config)
	{
		$this->config = $config;
	}

	/**
	 * @param Event $event
	 */
	public function handle_submit_post_end($event)
	{
		$mode = $event['mode'];
		$user = $event['username'];
		$prefix = $this->prefix_from_mode($mode);
		$title = html_entity_decode($event['data']['topic_title']);
		$url = generate_board_url().'/'.
			 preg_replace('/^.\//', '', html_entity_decode($event['url']));
		$html = '['.htmlspecialchars($user).'] '.
			  htmlspecialchars($prefix).
			  '<a href="'.htmlspecialchars($url).'">'.
			  htmlspecialchars($title).
			  '</a>';
		$this->send_html_message_as_telegram_bot($html);
	}

	private function prefix_from_mode($mode) {
		if ($mode === 'post') {
			return '';
		} else if ($mode === 'reply') {
			return 'Re: ';
		} else {
			return ucfirst($mode).': ';
		}
	}

	private function send_html_message_as_telegram_bot($html) {
		$auth = $this->config['lassik_telegram_bot_auth_token'];
		$chat_id = $this->config['lassik_telegram_chat_id'];
		if (empty($auth) || empty($chat_id))
			return;
		$url = 'https://api.telegram.org/bot'.urlencode($auth).'/sendMessage';
		$data = array(
			'chat_id' => $chat_id,
			'disable_web_page_preview' => 'true',
			'parse_mode' => 'HTML',
			'text' => $html
        );
		if (!function_exists('curl_version'))
			return;
		$curl = curl_init($url);
		//curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, false);
		curl_exec($curl);
		curl_close($curl);
	}
}
