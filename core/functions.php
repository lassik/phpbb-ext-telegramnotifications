<?php
/**
 *
 * @package phpBB extension - Telegram notifications
 * @copyright (c) 2017 Lassi Kortela
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
}
