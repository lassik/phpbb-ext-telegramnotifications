<?php
/**
 *
 * @package phpBB extension - Telegram notifications
 * @copyright (c) 2017, 2018 Lassi Kortela
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
		$mode = $event['mode'];
		$username = $event['username'];
		if ($mode === 'edit')
		{
			$username = $this->functions->get_username_by_id(
				$event['data']['post_edit_user']);
		}
		$url = generate_board_url().'/'.
			 preg_replace('/^\.\//', '', html_entity_decode($event['url']));
		$html = '['.htmlspecialchars($username).'] '.
			  htmlspecialchars($this->prefix_from_mode($mode)).
			  '<a href="'.htmlspecialchars($url).'">'.
			  $event['data']['topic_title'].
			  '</a>';
		if ($mode === 'edit')
		{
			$reason = $event['data']['post_edit_reason'];
			if (empty($reason))
			{
				return;
			}
			$html .= ' - '.htmlspecialchars($reason);
		}
		$this->functions->send_html_message_as_telegram_bot($html);
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
}
