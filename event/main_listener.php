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
		$url = generate_board_url().'/'.
			 preg_replace('/^\.\//', '', html_entity_decode($event['url']));
		$username = $event['username'];
		$mode = $event['mode'];
		$title = html_entity_decode($event['data']['topic_title']);
		$extra = '';
		if ($mode === 'edit')
		{
			$username = $this->functions->get_username_by_id(
				$event['data']['post_edit_user']);
			$extra = $event['data']['post_edit_reason'];
			if (empty($extra))
			{
				return;
			}
		}
		$this->functions->notify_about_post(
			$url, $username, $mode, $title, $extra);
	}
}
