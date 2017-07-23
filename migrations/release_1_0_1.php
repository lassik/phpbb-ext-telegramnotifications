<?php
/**
*
* @package phpBB extension - Telegram notifications
* @copyright (c) 2017 Lassi Kortela
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace lassik\telegramnotifications\migrations;

class release_1_0_1 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->db_tools->sql_column_exists(
            $this->table_prefix . 'users',
            'user_lassik_telegramnotif');
	}

	static public function depends_on()
	{
		return array('\lassik\telegramnotifications\migrations\release_1_0_0');
	}

	public function update_schema()
	{
		return array(
			'add_tables'		=> array(
				$this->table_prefix . 'acme_demo'	=> array(
					'COLUMNS'		=> array(
						'acme_id'			=> array('UINT', null, 'auto_increment'),
						'acme_name'			=> array('VCHAR:255', ''),
					),
					'PRIMARY_KEY'	=> 'acme_id',
				),
			),
			'add_columns' => array(
				$this->table_prefix . 'users' => array(
					'user_lassik_telegramnotif' => array('UINT', 0),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns' => array(
				$this->table_prefix . 'users' => array(
					'user_lassik_telegramnotif',
				),
			),
			'drop_tables'		=> array(
				$this->table_prefix . 'acme_demo',
			),
		);
	}
}
