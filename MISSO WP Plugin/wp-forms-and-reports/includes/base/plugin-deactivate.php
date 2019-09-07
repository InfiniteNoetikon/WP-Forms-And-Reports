<?php
/**
 * @package WP_Forms_and_Reports
 */

class PluginDeactivate
{
	public static function deactivate()
	{
		flush_rewrite_rules();
	}
}