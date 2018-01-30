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
			'core.user_active_flip_after' => 'handle_user_active_flip_after',
		);
	}

	/** @var \lassik\telegramnotifications\core\functions */
	protected $functions;

	/**
	 * Constructor
	 *
	 * @param \lassik\telegramnotifications\core\functions $functions
	 */
	public function __construct(
		\lassik\telegramnotifications\core\functions $functions
	)
	{
		$this->functions = $functions;
	}

	/**
	 * Handle phpBB's ucp_activate_after by sending a Telegram
	 * message that says which user was activated.
	 *
	 * @param Event $event
	 */
	public function handle_user_active_flip_after($event)
	{
		if (!$event['activated'])
		{
			return;
		}
		/* TODO: Notify about all activated users when there's more than one. */
		$username = $this->functions->get_username_by_id(
			$event['user_id_ary'][0]);
		$this->functions->notify_about_user_activation($username);
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
		if ($mode === 'edit')
		{
			$username = $this->functions->get_username_by_id(
				$event['data']['post_edit_user']);
			$extra = html_entity_decode($event['data']['post_edit_reason']);
			if (empty($extra))
			{
				return;
			}
		}
		else
		{
			$extra = $event['data']['message'];
			$extra = html_entity_decode($extra);
			$extra = strip_tags($extra);
		}
		$this->functions->notify_about_post(
			$url, $username, $mode, $title, $extra);
	}
}
