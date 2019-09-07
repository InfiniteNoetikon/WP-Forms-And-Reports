<?php
/*
 * @package WP_Forms_and_Reports
 */
function enqueue()
{
	wp_enqueue_style('mypluginstyle', plugins_url('../../assets/mystyle.css', __FILE__));
	wp_enqueue_style('bootstrapstyle', plugins_url('../../assets/bootstrap.min.css', __FILE__));
	wp_enqueue_style('w3style', plugins_url('../../assets/w3.css', __FILE__));
	wp_enqueue_script('bootstrapjqueryscript', plugins_url('../../assets/jquery-3.3.1.slim.min.js', __FILE__));
	wp_enqueue_script('bootstrapminscript', plugins_url('../../assets/bootstrap.min.js', __FILE__));
	wp_enqueue_script('bootstrappopperscript', plugins_url('../../assets/popper.min.js', __FILE__));	
	wp_enqueue_script('mypluginscript', plugins_url('../../assets/myscript.js', __FILE__));
}

function g_auth_enabled()
{
	$settings = fopen(plugins_url('../../assets/settings.txt', __FILE__), "r") or die("unable to open");
	$g_oauth = fgets($settings);
	$g_oauth = str_replace("\n", '', str_replace(' ', '', substr($g_oauth, strpos($g_oauth, ": ") + 2)));
	$g_oauth_key = fgets($settings);
	$g_oauth_key = str_replace("\n", '', str_replace(' ', '', substr($g_oauth_key, strpos($g_oauth_key, ": ") + 2)));
	fclose($settings);
	
	if ($g_oauth_key != '' && $g_oauth != 'true')
		return true;
	
	return false;
}

function __main()
{
	enqueue();
	
	global $wpdb;
	$results = $wpdb->get_results("SELECT table_name FROM information_schema.tables WHERE table_name = 'wp_far_Accounts'");
?>

<div class="wrap">
	<h1	class="wp-heading-inline">Accounts</h1>
	<a href="admin.php?page=wp_forms_and_reports_admin_menu&token=create" class="page-title-action">Add New</a>
	<?php
	if (!g_auth_enabled())
	{
	?>
		<div class="alert alert-warning" id="g-auth-warning">Inorder for the accounts to work you must first enable the Google open authorization in the WP Forms and Reports <a href="?page=far_settings">"Settings"</a> page.</div>
	<?php
	}
	?>
	<div class="custom-alert">Add accounts to access pages of reports with sensitive information. The accounts must be Google acounts.</div>
	<table class="table table-striped w3-table-responsive w3-border">		
		<thead>
			<tr>
				<th scope="col" id="title" class="manage-column column-title column-primary">
					<a href="#">
						<span>Google Account</span>
					</a>
				</th>
				<th scope="col" id="author" class="manage-column column-title">
					Forms Allowed
				</th>
			</tr>
		</thead>
		<tbody>
		<?php
		if (count($results))
		{
			$sql = "SELECT * FROM wp_far_forms";
			$results = $wpdb->get_results($sql);
			foreach ($results as $result)
			{
		?>
			<tr>
				<td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
					<div class="locked-info">
						<span class="locked-avatar"></span>
						<span class="locked-text"></span>
					</div>
					<strong>
						<a class="row-title" href="https://timothyaltemus.com/wp-admin?page=wp_forms_and_reports_admin_menu&token=edit&lastrow=<?php echo count($results) > 1 ? $results[count($results) - 1][0] : 0; ?>" aria-label="“<?php echo $result['wp_far_accounts_name']; ?>” (Edit)">
							<?php echo $result['wp_far_forms_name']; ?>
						</a>
					</strong>
					<div class="row-actions">
						<span class="edit">
							<a href="" aria-label="Edit">Edit</a> | 
						</span>
						<span class="view">
							<a href="" aria-label="View">View</a> |
						</span>
						<span class="trash">
							<a href="" class="submitdelete" aria-label="Delete">Delete</a>
						</span>
					</div>
				</td>
				<td class="author column-author"><a href="#"><?php echo $result['wp_far_forms_author']; ?></a></td>
				<td class="date column-date"><?php echo $result['wp_far_forms_creation_date']; ?> </td>
			</tr>
		<?php
			}
		}
		?>
		</tbody>
	</table>
</div>

<?php
}

__main();