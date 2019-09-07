<?php
/**
 * @package WP_Forms_and_Reports
 */

final class init
{
	public static function get_services()
	{
		$classes = [];
		$services_path = plugin_dir_path(__FILE__) . 'services';
		$files = scandir($services_path);
		foreach ($files as $file)
		{
			if (fnmatch('*.php', $file))
			{
				require_once "$services_path/$file";
				$class = ucfirst(basename(str_replace('_', '', $file), '.php'));
				if ($class != "index" || $class != "Index")
					array_push($classes, $class);
			}
		}
		return $classes;
	}
	
	public static function register_service()
	{
		foreach (self::get_services() as $class)
		{
			$service = self::instantiate($class);
			if (method_exists($service, 'register'))
			{
				$service->register();
			}
		}
	}
	
	private static function instantiate($class)
	{
		if (class_exists($class))
			return new $class;
	}
}

/*
if (!class_exists('WoFormsAndReports'))
{	
	class WpFormsAndReports
	{
		public $plugin_name;
		
		function __construct()
		{
			$this->plugin_name = plugin_basename(__FILE__);
		}
		
		function register()
		{
			add_action('admin_enqueue_scripts', array($this, 'enqueue'));
			
			add_action('admin_menu', array($this, 'add_admin_pages'));
			
			add_filter("plugin_action_links_$this->plugin_name", array($this, 'settings_link'));
		}
		
		function settings_link($links)
		{
			$settings_link = '<a href="admin.php?page=wp_forms_and_reports">Forms</a>';
			array_push($links, $settings_link);
			$settings_link = '<a href="admin.php?page=wp_forms_and_reports">Accounts</a>';
			array_push($links, $settings_link);
			$settings_link = '<a href="admin.php?page=wp_forms_and_reports">Documentation</a>';
			array_push($links, $settings_link);
			return $links;
		}
		
		function add_admin_pages()
		{
			add_menu_page('WP Forms and Reports', 'Forms and Reports', 'manage_options', 'wp_forms_and_reports', array($this, 'admin_index'), 'dashicons-analytics', 26);
		}
		
		function admin_index()
		{
			require_once plugin_dir_path(__FILE__) . '/views/admin-main.php';
		}
		
		protected function create_post_type()
		{
			add_action('init', array($this, 'custom_post_type'));
		}
		
		function custom_post_type()
		{
			register_post_type('book', ['public' => true, 'label' => 'Books']);
		}
		
		function enqueue()
		{
			// enqueue all scripts
			wp_enqueue_style('mypluginstyle', plugins_url('/assets/mystyle.css', __FILE__));
			wp_enqueue_script('mypluginscript', plugins_url('/assets/myscript.js', __FILE__));
		}
		
		function activate()
		{
			require_once plugin_dir_path(__FILE__) . 'includes/base/plugin-activate.php';
			PluginActivate::activate();
		}
		
		function deactivate()
		{
			// flush rewrite rules
			flush_rewrite_rules();
		}
	}

	$wpFormsAndReports = new WpFormsAndReports();
	$wpFormsAndReports->register();
	
	// activation
	register_activation_hook(__FILE__, array($wpFormsAndReports, 'activate'));
	
	// deactivation
	require_once plugin_dir_path(__FILE__) . 'includes/base/plugin-deactivate.php';
	register_deactivation_hook(__FILE__, array('PluginDeactivate', 'deactivate'));
}
*/