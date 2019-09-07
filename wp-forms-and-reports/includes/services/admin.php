<?php
/**
 * @package WP_Forms_and_Reports
 */

class Admin
{
	public function register()
	{
		require_once plugin_dir_path(__FILE__) . '../models/menu.php';
		
		$menu = new Menu('WP Forms and Reports', 'Forms and Reports','dashicons-analytics', 'far');
		$this->add_sub_pages($menu);
		
		$menu->create_menu();
	}
	
	private function add_sub_pages(Menu $menu)
	{
		require_once plugin_dir_path(__FILE__) . '../models/menu-page.php';
		
		$menu->push_sub_page(new MenuPage('Accounts', 'accounts-view.php', $menu));
		$menu->push_sub_page(new MenuPage('Documentation', 'documentation-view.php', $menu));
		$menu->push_sub_page(new MenuPage('Settings', 'settings-view.php', $menu));
	}
}