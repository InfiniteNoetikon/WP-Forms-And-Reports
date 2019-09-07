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

function save_settings()
{
	if (isset($_GET['g-oauth-switch']))
	{
		$oauth_set = $_GET['g-oauth-switch'];
	}
	if (isset($_GET['g-oauth']))
	{
		$oauth_key = $_GET['g-oauth'];
	}
	
	$txt = "g-oauth: {$oauth_set}\ng-oauth-key: {$oauth_key}";
	$settings = fopen("../wp-content/plugins/wp-forms-and-reports/assets/settings.txt", "w") or die("Unable to save.");
	fwrite($settings, $txt);
	fclose($settings);
} 

function create_db()
{
	global $wpdb;
	$results = $wpdb->get_results("SELECT table_name FROM information_schema.tables WHERE table_name = 'wp_far_forms'");
	if (count($results) != 1){
		$sql = "CREATE TABLE wp_far_forms(
		wp_far_forms_id INT PRIMARY KEY AUTO_INCREMENT,
		wp_far_forms_name VARCHAR(999) NOT NULL UNIQUE,
		wp_far_forms_author VARCHAR(999) NOT NULL,
		wp_far_forms_creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
		)";
		$wpdb->query($sql);
	}
	
	$results = $wpdb->get_results("SELECT table_name FROM information_schema.tables WHERE table_name = 'wp_far_accounts'");
	if (count($results) != 1){
		$sql = "CREATE TABLE wp_far_accounts(
			wp_far_accounts_id INT PRIMARY KEY AUTO_INCREMENT,
			wp_far_accounts_email VARCHAR(999) NOT NULL,
			wp_far_accounts_forms VARCHAR(999) NOT NULL
		)";
		$wpdb->query($sql);
	}
	
	$results = $wpdb->get_results("SELECT table_name FROM information_schema.tables WHERE table_name = 'wp_far_schema'");
	if (count($results) != 1){
		$sql = "CREATE TABLE wp_far_schema(
		wp_far_schema_id INT PRIMARY KEY AUTO_INCREMENT,
		wp_far_schema_field VARCHAR(999) NOT NULL,
		wp_far_schema_field_num INT(3) NOT NULL,
		wp_far_schema_field_type VARCHAR(15) NOT NULL,
		wp_far_schema_field_length VARCHAR(6) NOT NULL, 
		wp_far_schema_field_options VARCHAR(999),
		wp_far_schema_forms_form_id INT(9) NOT NULL,
		FOREIGN KEY(wp_far_schema_forms_form_id) REFERENCES wp_far_forms(wp_far_forms_id) ON DELETE CASCADE
		)";
		$wpdb->query($sql);
	}
	
	$results = $wpdb->get_results("SELECT table_name FROM information_schema.tables WHERE table_name = 'wp_far_posts'");
	if (count($results) != 1){
		$sql = "CREATE TABLE wp_far_posts(
		wp_far_posts_id INT PRIMARY KEY AUTO_INCREMENT,
		wp_far_posts_answer_num INT(9) NOT NULL,
		wp_far_posts_answerer VARCHAR(999),
		wp_far_posts_answer VARCHAR(999) DEFAULT '',
		wp_far_posts_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		wp_far_posts_form_id INT NOT NULL,
		FOREIGN KEY(wp_far_posts_form_id) REFERENCES wp_far_forms(wp_far_forms_id) ON DELETE CASCADE,
		wp_far_posts_question_id INT NOT NULL,
		FOREIGN KEY(wp_far_posts_question_id) REFERENCES wp_far_schema(wp_far_schema_id) ON DELETE CASCADE
		)";
		$wpdb->query($sql);
	}
}

function add_button()
{
?>
	<div class="wrap">
		<h1>Add Button</h1>
		<hr />
		<div style="margin-left:30px; margin-right:30px;">
			<form action="?page=far_settings&action=add-button&submit=1" method="POST">
				<div class="row">
					<div class="col-4">
						<div class="form-group">
							<label for="b-name">Button Name</label>
							<input type="text" name="b-name" class="form-control" placeholder="button name" required />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-4">
						<div class="form-group">
							<label for="b-type">Type</label>
							<select name="b-type" class="form-control" onchange="document.getElementById('submit').disabled = false" required>
								<option value="1" selected disabled>Select Type</option>
								<option>Buy Now</option>
								<option>Add to Cart</option>
								<option>Donate</option>
								<option>Subscription</option>
								<option>Installment Plan</option>
								<option>Automatic Billing</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<div class="form-group">
							<label for="b-html">HTML</label>
							<textarea name="b-html" class="form-control" placeholder="<button html></button html>" required></textarea>
						</div>
					</div>
				</div>
				<button name="submit" id="submit" class="button button-primary" disabled>Add Button</button>
			</form>
		</div>
	</div>
<?
}

function submit_pp_button()
{
	if (isset($_POST['b-name']))
	{
		$name = $_POST['b-name'];
	}
	if (isset($_POST['b-type']))
	{
		$type = str_replace("|", "", $_POST['b-type']);
	}
	if (isset($_POST['b-html']))
	{
		$html = $_POST['b-html'];
	}
	
	$file = html_entity_decode(htmlentities(file_get_contents(("../wp-content/plugins/wp-forms-and-reports/assets/buttons.php"))));
	$content = substr($file, 6);
	$content = explode("|", $content);
	
	if (count($content) > 1)
	{
		$name_list = explode(";", $content[0]);
		array_push($name_list, $name);
		$type_list = explode(";", $content[1]);
		array_push($type_list, $type);
		$html_list = explode(";", $content[2]);
		array_push($html_list, $html);
	
		$txt = "<?php ";
		
		foreach($name_list as $name)
		{
			$txt .= $name . ";";
		}
		
		$txt = substr($txt, 0, strlen($txt) - 1) . "|";
		
		foreach($type_list as $type)
		{
			$txt .= $type . ";";
		}
		
		$txt = substr($txt, 0, strlen($txt) - 1) . "|";
		
		foreach($html_list as $html)
		{
			$txt .= $html . ";";
		}
		
		$txt = substr($txt, 0, strlen($txt) - 1);
		$file = fopen('../wp-content/plugins/wp-forms-and-reports/assets/buttons.php', "w");
		fwrite($file, $txt);
		fclose($file);
	}
	else 
	{
		$txt = "<?php {$name}|{$type}|{$html}";
		$file = fopen('../wp-content/plugins/wp-forms-and-reports/assets/buttons.php', "w");
		fwrite($file, $txt);
		fclose($file);
	}
	
	?>
		<div class="alert alert-success">
			Successfully added button!
		</div>
		<script>
			window.location.href = '?page=far_settings';
		</script>
	<?php
}

function edit_button($button)
{
	$os = "<?php ";
	$file = html_entity_decode(htmlentities(file_get_contents(("../wp-content/plugins/wp-forms-and-reports/assets/buttons.php"))));
	$content = substr($file, 6);
	$content = explode("|", $content);
	if (count($content) > 1)
	{
		$names = explode(";", $content[0]);
		$types = explode(";", $content[1]);
		$htmls = explode(";", $content[2]);
		
		$name = "";
		$type = "";
		$html = "";
		
		if (count($names) > $button)
			$name = $names[$button];
		if (count($types) > $button)
			$type = $types[$button];
		if (count($htmls) > $button)
			$html = $htmls[$button];
	}
?>
	<div class="wrap">
		<h1>Add Button</h1>
		<hr />
		<div style="margin-left:30px; margin-right:30px;">
			<form action="?page=far_settings&action=edit&submit=1" method="POST">
				<div class="row">
					<div class="col-4">
						<div class="form-group">
							<label for="b-name">Button Name</label>
							<input type="text" name="b-name" class="form-control" placeholder="button name" value="<?php echo $name ?>" required />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-4">
						<div class="form-group">
							<label for="b-type">Type</label>
							<select name="b-type" class="form-control" onchange="document.getElementById('submit').disabled = false" required>
								<option value="1" selected disabled>Select Type</option>
								<option <?php echo $type == "Buy Now" ? "selected" : ""; $found = true;?>>Buy Now</option>
								<option <?php echo $type == "Add to Cart" ? "selected" : ""; $found = true;?>>Add to Cart</option>
								<option <?php echo $type == "Donate" ? "selected" : ""?>>Donate</option>
								<option <?php echo $type == "Subscription" ? "selected" : ""; $found = true;?>>Subscription</option>
								<option <?php echo $type == "Installment Plan" ? "selected" : ""; $found = true;?>>Installment Plan</option>
								<option <?php echo $type == "Automatic Billing" ? "selected" : ""; $found = true;?>>Automatic Billing</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<div class="form-group">
							<label for="b-html">HTML</label>
							<textarea name="b-html" class="form-control" placeholder="<button html></button html>" required><?php echo $html ?></textarea>
						</div>
					</div>
				</div>
				<input type="hidden" name="button" value="<?php echo $button ?>" />
				<button name="submit" id="submit" class="button button-primary" <?php echo $found ? "" : "disabled"?>>Edit Button</button>
			</form>
		</div>
	</div>
<?
}

function submit_edit_pp_button()
{
	if (isset($_POST['b-name']))
	{
		$name = $_POST['b-name'];
	}
	if (isset($_POST['b-type']))
	{
		$type = str_replace("|", "", $_POST['b-type']);
	}
	if (isset($_POST['b-html']))
	{
		$html = $_POST['b-html'];
	}
	if (isset($_POST['button']))
	{
		$button = $_POST['button'];
	}
	
	$file = html_entity_decode(htmlentities(file_get_contents(("../wp-content/plugins/wp-forms-and-reports/assets/buttons.php"))));
	$content = substr($file, 6);
	$content = explode("|", $content);
	
	if (count($content) > 1)
	{
		$name_list = explode(";", $content[0]);
		$type_list = explode(";", $content[1]);
		$html_list = explode(";", $content[2]);
	
		$txt = "<?php ";
		
		for ($i = 0; $i < count($name_list); $i++)
		{
			if ($i != $button)
				$txt .= $name_list[$i] . ";";
			else
				$txt .= $name . ";";
		}
		
		$txt = substr($txt, 0, strlen($txt) - 1) . "|";
		
		for ($i = 0; $i < count($type_list); $i++)
		{
			if ($i != $button)
				$txt .= $type_list[$i] . ";";
			else
				$txt .= $type . ";";
		}
		
		$txt = substr($txt, 0, strlen($txt) - 1) . "|";
		
		for ($i = 0; $i < count($html_list); $i++)
		{
			if ($i != $button)
				$txt .= $html_list[$i] . ";";
			else
				$txt .= $html . ";";
		}
		
		$txt = substr($txt, 0, strlen($txt) - 1);
		$file = fopen('../wp-content/plugins/wp-forms-and-reports/assets/buttons.php', "w");
		fwrite($file, $txt);
		fclose($file);
	}
	
	?>
		<div class="alert alert-success">
			Successfully edited button!
		</div>
		<script>
			window.location.href = '?page=far_settings';
		</script>
	<?php
}

function delete_button($ignore)
{
	$os = "<?php ";
	$file = html_entity_decode(htmlentities(file_get_contents(("../wp-content/plugins/wp-forms-and-reports/assets/buttons.php"))));
	$content = substr($file, 6);
	$content = explode("|", $content);
	
	if (count($content) > 1)
	{
		$name_list = explode(";", $content[0]);
		$type_list = explode(";", $content[1]);
		$html_list = explode(";", $content[2]);
		
		echo "Skipping: $ignore";
		
		for ($i = 0; $i < count($name_list); $i++)
		{
			if ($i != $ignore)
			{
				$os .= "{$name_list[$i]};";
			}
		}
		
		$os = substr($os, 0, strlen($os) - 1) . "|";
		
		for ($i = 0; $i < count($type_list); $i++)
		{
			if ($i != $ignore)
			{
				$os .= "{$type_list[$i]};";
			}
		}
		
		$os = substr($os, 0, strlen($os) - 1) . "|";
		
		for ($i = 0; $i < count($html_list); $i++)
		{
			if ($i != $ignore)
			{
				$os .= "{$html_list[$i]};";
			}
		}
		
		$os = substr($os, 0, strlen($os) - 1);
	}
	
	$file = fopen('../wp-content/plugins/wp-forms-and-reports/assets/buttons.php', "w");
	fwrite($file, $os);
	fclose($file);
	
	?>
		<div class="alert alert-success">
			Successfully deleted button!
		</div>
		<script>
			window.location.href = '?page=far_settings';
		</script>
	<?php
}

function __main()
{
	$settings = fopen(plugins_url('../../assets/settings.txt', __FILE__), "r") or die("Unable to open" . plugins_url('../../assets/settings.txt', __FILE__));
	$g_oauth = fgets($settings);
	$g_oauth = str_replace("|", '', str_replace(' ', '', substr($g_oauth, strpos($g_oauth, ": ") + 1)));
	$g_oauth_key = fgets($settings);
	$g_oauth_key = str_replace("|", '', str_replace(' ', '', substr($g_oauth_key, strpos($g_oauth_key, ": ") + 1)));
	fclose($settings);
?>
<script>
	function enable_g_oauth()
	{
		document.getElementById('g-oauth').disabled = !document.getElementById('g-oauth').disabled;
		document.getElementById('submit-save').disabled = !document.getElementById('submit-save').disabled;
		if (document.getElementById('g-oauth-switch').checked)
		{
			document.getElementById('g-oauth-row').style.color = "black";
			document.getElementById('g-oauth-row2').style.color = "black";
		}
		else
		{
			document.getElementById('g-oauth-row').style.color = "grey";
			document.getElementById('g-oauth-row2').style.color = "grey";
		}
	}
</script>

<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	
	<div style="margin-left:30px; margin-right:30px;">
		<hr />
		<form action="admin.php?page=far_settings" method="get">
			<input type="hidden" name="page" value="far_settings" />
			<h4 style="margin-bottom: 15px;">Create WP Forms and Reports Database</h4>
			<ul>
				<li style="margin-left: 25px">
					<div class="row">
						<div class="col-auto"><button name="submit" id="submit" class="button button-primary">Create Database</button></div><div class="col">You must press this option once in order for the plugin to work. This may take a couple minutes.</div>
					</div>
					<input type="hidden" name="action" value="createdb"/>
				</li>
				<li style="margin-left: 25px">
					<?php 
					if (isset($_POST['action']))
					{
						if ($_POST['action'] == 'createdb')
						{
						?>
							<div class="alert alert-success" id="successdb">Successfully created database.</div>
						<?php
						}
					}
					?>
				</li>
		</form>
		
		<hr />
		
		<form action="admin.php?page=far_settings" method="get">
			<input type="hidden" name="page" value="far_settings" />
			<h4 style="margin-bottom: 15px;">Google Open Authorization</h4>
			<ul>
				<li style="margin-left: 25px">
					<div class="col">
						<div class="row" style="color: grey" id="g-oauth-row">
							<div class="custom-control custom-switch">
								<?php echo "$g_oauth<br />"; ?>
								<input type="checkbox" class="custom-control-input" name="g-oauth-switch" id="g-oauth-switch" onclick="enable_g_oauth()" <?php if ($g_oauth == "on") echo 'checked'; ?>/>
								<label class="custom-control-label" for="g-oauth-switch">Enable Google OAuth</label>
							</div>
						</div>
					</div>
				</li>
				<li>
					<p />
				</li>
				<li style="margin-left: 25px;">
					<div class="row" style="color: grey" id="g-oauth-row2">
						<div class="col-auto"><label>Google OAuth Client ID:</label></div>
						<div class="col-4"><input type="text" name="g-oauth" id="g-oauth" placeholder="YOUR_CLIENT_ID.apps.googleusercontent.com" disabled class="form-control" value="<?php echo $g_oauth_key; ?>"/></div>
						<div class="col">Make sure you have correctly enabled the google OAuth in <a href="http://Console.developers.google.com">Console.developers.google.com</a>.</div>
					</div>
				</li>
				<li style="margin-left: 25px;">
					<input type="hidden" name="action" value="save" />
					<button name="submit" id="submit-save" class="button button-primary">Save</button>
					<?php 
					if (isset($_POST['action']))
					{
						if ($_POST['action'] == 'save')
						{
						?>
							<div class="alert alert-success" id="successdb">Successfully saved settings.</div>
						<?php
						}
					}
					?>
				</li>
			</ul>
			<script>
				if (document.getElementById('g-oauth-switch').checked)
				{
					document.getElementById('g-oauth').disabled = false;
					document.getElementById('g-oauth-row').style.color = "black";
					document.getElementById('g-oauth-row2').style.color = "black";
					document.getElementById('submit-save').disabled = false;
				}
				else
				{
					document.getElementById('g-oauth').disabled = true;
					document.getElementById('g-oauth-row').style.color = "grey";
					document.getElementById('g-oauth-row2').style.color = "grey";
					document.getElementById('submit-save').disabled = true;
				}
			</script>
		</form>
		
		<hr />
		
		<form action="" method="get">
			<input type="hidden" name="page" value="far_settings" />
			<div class="row"><div class="col-auto"><h4 style="margin-bottom: 15px;">PayPal Buttons</h4></div><div class="col-auto"><button style="margin: auto; display: flex" id="submit" class="button button-primary">Add Button</button></div></div>
			<table class="table table-striped w3-border">
				<thead>
					<tr>
						<th>
							Button Name
						</th>
						<th>
							Button Type
						</th>
						<th>
							Button HTML
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$file = html_entity_decode(htmlentities(file_get_contents('../wp-content/plugins/wp-forms-and-reports/assets/buttons.php')));
						$content = substr($file, 6);
						$content = explode("|", $content);
						if (count($content) > 1)
						{
							$name = explode(";", $content[0]);
							$type = explode(";", $content[1]);
							$html = explode(";", $content[2]);
							
							for ($i = 0; $i < count($name); $i++)
							{
							?>
								<tr>
									<td><a href="?page=far_settings&action=edit&button=<?php echo $i ?>"><?php echo count($name) > $i ? $name[$i] : ''; ?></a></td>
									<td><?php echo count($type) > $i ? $type[$i] : ''; ?></td>
									<td><?php echo count($html) > $i ? str_replace("\\", "", $html[$i]) : ''; ?></td>
									<td><a href="?page=far_settings&action=delete&button=<?php echo $i ?>"><img src="<?php echo plugins_url('../../assets/trash.png', __FILE__); ?>"></a></td>
								</tr>
							<?php
							}
						}
					?>
				</tbody>
			</table>
			<input name="action" type="hidden" value="add-button" />
		</form>
	</div>
</div>
<?php
}

enqueue();

if (isset($_GET['action']))
	$action = $_GET['action'];
else
	$action = '';

switch ($action)
{
	case 'createdb':
		create_db();
		__main();
		break;
	case 'save':
		save_settings();
		__main();
		break;
	case 'add-button':
		if (isset($_GET['submit']))
		{
			submit_pp_button();
		}
		else
			add_button();
		break;
	case 'edit':
		if (isset($_GET['submit']))
		{
			submit_edit_pp_button();
		}
		else
			edit_button($_GET['button']);		
		break;
	case 'delete':
		delete_button($_GET['button']);
		break;
	case 'main':
	default:
		__main();
}

