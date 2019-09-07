<?php
/**
 * @package WP_Forms_and_Reports
 */

class PluginActivate
{
	public static function activate()
	{
		flush_rewrite_rules();
	}
}