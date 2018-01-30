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

	/** @var \lassik\telegramnotifications\core\functions */
	protected $functions;

	/** @var \phpbb\config\config */
	protected $config;

	/**
	 * Constructor
	 *
	 * @param \lassik\telegramnotifications\core\functions	$functions
	 * @param \phpbb\config\config							$config
	 */
	public function __construct(
		\lassik\telegramnotifications\core\functions $functions,
		\phpbb\config\config $config
	)
	{
		$this->functions = $functions;
		$this->config	 = $config;
	}

	/**
	 * Handle phpBB's submit_post_end event by sending a Telegram
	 * message that says what happened.
	 *
	 * @param Event $event
	 */
	public function handle_submit_post_end($event)
	{
		$url = generate_board_url().'/'.
			 preg_replace('/^\.\//', '', html_entity_decode($event['url']));
		$html = '['.htmlspecialchars($event['username']).'] '.
			  htmlspecialchars($this->prefix_from_mode($event['mode'])).
			  '<a href="'.htmlspecialchars($url).'">'.
			  $event['data']['topic_title'].
			  '</a>';
		$this->send_html_message_as_telegram_bot($html);
	}

	/**
	 * Given a phpBB event mode string (post, reply, quote, edit),
	 * return a human-readable string (like an email subject prefix)
	 * that indicates what happened to the topic.
	 */
	private function prefix_from_mode($mode)
	{
		if ($mode === 'post')
		{
			return '';
		}
		else if ($mode === 'reply')
		{
			return 'Re: ';
		}
		else
		{
			return ucfirst($mode).': ';
		}
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
	 * IDs are negative numbers. The function will silently fail
	 * unless both configuration parameters are set.
	 *
	 * PHP's curl API is used to make a HTTPS connection to the
	 * Telegram API. The function will silently fail if curl support
	 * is not available.
	 */
	private function send_html_message_as_telegram_bot($html)
	{
		$chat_id = $this->config['lassik_telegram_chat_id'];
		if (empty($chat_id))
		{
			$this->functions->set_last_error('Telegram chat ID not filled in');
			return;
		}
		$this->functions->call_telegram_bot_api('sendMessage', array(
			'chat_id' => $chat_id,
			'disable_web_page_preview' => 'true',
			'parse_mode' => 'HTML',
			'text' => $html,
		));
	}
}
