<?php
/**
 * @package WP_Forms_and_Reports
 */ 
 
class Menu
{
	private $main_page;
	private $sub_pages = [];
	private $icon;
	
	public $plugin_name;
	public $shortname;
	public $slug;
	
	public function __construct(string $plugin_name, string $main_page, string $icon='', string $shortname='')
	{
		$this->plugin_name = $plugin_name;
		$this->main_page = $main_page;
		$this->icon = $icon;
		$this->shortname = $shortname;
		$this->slug = str_replace(' ', '_', strtolower($this->plugin_name)) . '_admin_menu';
	}
	
	public function create_menu()
	{
		add_action('admin_menu', array($this, 'add_main_page'));
		
		
	}
	
	public function push_sub_page(MenuPage $sub_page)
	{
		array_push($this->sub_pages, $sub_page);
	}
	
	public function add_main_page()
	{
		add_menu_page(
			$this->plugin_name, 
			$this->main_page, 
			'manage_options', 
			$this->slug, 
			array($this, 'admin_index'), 
			$this->icon, 26
			);
			
			$this->add_sub_pages();
	}
	
	private function add_sub_pages()
	{
		foreach ($this->sub_pages as $menu_page)
		{
			add_submenu_page(
				$this->slug,
				$menu_page->menu->plugin_name . ' ' . $menu_page->title,
				$menu_page->title,
				'manage_options',
				str_replace(' ', '_', strtolower($menu_page->menu->shortname . '_' . $menu_page->title)),
				array($menu_page, 'render')
			);
		}
	}
	
	public function admin_index()
	{
		require_once plugin_dir_path(__FILE__) . '../views/menu-main.php';
	}
}