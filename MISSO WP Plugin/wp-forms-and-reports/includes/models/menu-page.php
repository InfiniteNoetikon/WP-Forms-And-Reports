<?php
/**
 * @package WP_Forms_and_Reports
 */

class MenuPage
{
	public $title;
	public $renderfile;
	public $menu;
	
	public function __construct(string $title, string $renderfile, Menu $menu) {
		$this->title = $title;
		$this->renderfile = $renderfile;
		$this->menu = $menu;
	}
	
	public function create()
	{
		add_submenu_page(
				$this->menu->slug,
				$this->menu->plugin_name . ' ' . $this->title,
				$this->title,
				'manage_options',
				str_replace(' ', '_', strtolower($this->menu->shortname . '_' . $this->title)),
				array($this, 'render')
			);
	}
	
	public function render() 
	{
		$file = strpos($this->renderfile, '.php') == false ? $this->renderfile . '.php': $this->renderfile;
		include_once plugin_dir_path(__FILE__) . '../views/' . $file;
	}
}