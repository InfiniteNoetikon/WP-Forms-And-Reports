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

function far_create()
{
	?>
	<style>
		.point {
			cursor: pointer;
			background: black;
		}
	</style>
	<script>
	var Field_Num = 0;

	function add_input(){
		Field_Num++;
		var form = document.getElementById("form_inputs");
		form.innerHTML += "<div class='form-group' id='group" + Field_Num.toString() + "'>" +
				"<label>Field:</label>" +
				"<div class='row'>" +
					"<div class='col-5'>" +
						"<input name='input" + Field_Num.toString() + "' id='input" + Field_Num.toString() + "' class='form-control' type='input' required/>" +
					"</div>" +
					"<div class='col-2'>" +
						"<select name='input" + Field_Num.toString() + "_type' id='input" + Field_Num.toString() + "_type' onchange='check_type(\"input" + Field_Num.toString() + "\")' class='form-control'>" +
							get_options() + 
						"</select>" +
					"</div>" +
					"<div class='col-2'>" +
						"<input name='input" + Field_Num.toString() + "_length' id='input" + Field_Num.toString() + "_length' class='form-control' maxlength='5' />" +
					"</div>" +
					"<div class='col-2'>" +
						"<textarea name='input" + Field_Num.toString() + "_options' id='input" + Field_Num.toString() + "_options' class='form-control' maxlength='999' disabled></textarea>" +
					"</div>" +
					"<div class='col-1>" +
						"<button class='btn' onclick='delete_group(\"group" + Field_Num.toString() + "\")'><img src='" + document.getElementById('trash').value + "' /></button>" +					
					"</div>" +
				"</div>" +
			"</div>";
	}

	function get_options(){
		return "<option value='text'>Text</option>" +
					"<option value='email'>Email</option>" +
					"<option value='phone'>Phone</option>" +
					"<option value='number'>Number</option>" +
					"<option value='currency'>Currency</option>" +
					"<option value='paragraph'>Paragraph</option>" +
					"<option value='options'>Dropdown</option>" +
					"<option value='date'>Date</option>" +
					"<option value='time'>Time</option>" +
					"<option value='radio'>Multiple Choice</option>" +
					"<option value='checkbox'>Checkbox</option>" +
					"<option value='file'>File</option>" +
					"<option value='timestamp'>Current Timestamp</option>";
	}

	function check_type(input_name){
		var type = document.getElementById(input_name + "_type").value;
		var length = document.getElementById(input_name + "_length");
		var options = document.getElementById(input_name + "_options");
		if (type == "options" || type == "file" || type == "radio"){
			options.disabled = false;
			length.disabled = true;
			options.required = false;
			length.required = true;
		}
		else if (type != "paragraph" && type != "datetime" && type != "timestamp" && type != "phone"){
			length.disabled = false;
			options.disabled = true;
		}
		else {
			length.disabled = true;
			options.disabled = true;
		}
	}

	function delete_group(elementId){
		var element = document.getElementById(elementId);
		element.parentNode.removeChild(element);
	}
	</script>

	<!-- HEADING -->
	<div class="wrap">
		<input type="hidden" id="trash" value="<?php echo plugins_url('../../assets/trash.png', __FILE__); ?>" />
		<h1 class="wp-heading-inline">Create Form</h1>
		<a href="#" class="page-title-action" onclick="add_input()">+ Add Field</a>
		<br />
		<br />
		<form action="?page=wp_forms_and_reports_admin_menu&token=create&submit=true" method="POST">
			
			<strong>
				<div class='form-group'><label>Form Title:</label>
					<div class="row"><div class="col-10"><input name="form_name" class="form-control" required /></div></div>
				</div>
				
				<br />
				
				<div class="row">
					<div class="col-5">
						Field Name:
					</div>
					<div class="col-2">
						Type of Answer:
					</div>
					<div class="col-2">
						Length of Answer (Number of characters (3,2 = xxx.xx))
					</div>
					<div class="col-2">
						Options (Put each option/file extension on a new line for)
					</div>
					<div class="col-1">
						Delete
					</div>
				</div>
				
				
			</strong>

			<div id="form_inputs"></div>
			<?php submit_button('Create Form'); ?>
		</form>
	</div>
<?php
}

function far_edit()
{
	
}

function far_delete()
{
	
}

function clean_str(string $str)
{
	$str = str_replace("'", '', $str);
	$str = str_replace('"', '', $str);
	return $str;
}

function far_submit_new_form()
{
	global $wpdb;
	$results = $wpdb->get_results("SELECT wp_far_forms_id FROM wp_far_forms WHERE wp_far_forms_name = " . $_POST[form_name]);
	$id = $results['wp_far_forms_id'];
	$name = clean_str($_POST['form_name']);
	$user = wp_get_current_user();
	$sql = $wpdb->prepare("INSERT INTO wp_far_forms(wp_far_forms_name, wp_far_forms_author) values('{$name}', '{$user}')");
	$wpdb->query($sql);
	
	for ($i = 0; $i < (count($_POST) + 1) / 4; $i++)
	{
		$field_name = $_POST["input{$i}"];
		$type = $_POST["input{$i}_type"];
		$length = $_POST["input{$i}_length"];
		$options = str_replace("\n", ';', $_POST["input{i}_options"]);
		$sql = "INSERT INTO wp_far_schema(wp_far_schema_field, wp_far_schema_field_num, wp_far_schema_field_type, wp_far_schema_field_length, wp_far_schema_field_options, wp_far_schema_forms_form_id) VALUES('{$field_name}', $i, '{$type}', '{$length}', '{$options}', $id)";
		echo "<p> $sql </p>";
	}
	
	?>
		<form name="f1" action="?page=wp_forms_and_reports_admin_menu"></form>
		<input type="submit" />
		<script>
			var form = document.f1;
			//form.submit();
		</script>
	<?php
}

function main() 
{
	global $wpdb;
	$results = $wpdb->get_results("SELECT table_name FROM information_schema.tables WHERE table_name = 'wp_far_forms'");
?>
<div class="wrap">
	<h1 class="wp-heading-inline">Forms</h1>
	<a href="admin.php?page=wp_forms_and_reports_admin_menu&token=create" class="page-title-action">Add New</a>
	<br />
	<br />
	<table class="wp-list-table widefat fixed striped pages">		
		<thead>
			<tr>
				<th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
					<a href="#">
						<span>Form Title</span>
					</a>
				</th>
				<th scope="col" id="author" class="manage-column column-author">
					Author
				</th>
				<th scope="col" id="date" class="manage-column column-date sortable asc">
					<a href="#">
						<span>Date</span>
					</a>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if (count($results) > 0)
			{
				$sql = "SELECT wp_far_forms_id, wp_far_forms_name, wp_far_forms_author, DATE_FORMAT(wp_far_forms_creation_date, '%Y/%m/%d') FROM wp_far_forms";
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
						<a class="row-title" href="https://timothyaltemus.com/wp-admin?page=wp_forms_and_reports_admin_menu&token=edit&lastrow=<?php echo count($results) > 1 ? $results[count($results) - 1][0] : 0; ?>" aria-label="“<?php echo $result['wp_far_forms_name']; ?>” (Edit)">
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

enqueue();

if (isset($_GET['token']))
	$token = $_GET['token'];
else
	$token='default';

switch ($token)
{
	case 'create':
		if (isset($_GET['submit']))
			far_submit_new_form();
		else
			far_create();
		break;
	case 'edit':
		far_edit();
		break;
	case 'delete':
		far_delete();
		break;
	case 'default':
	default:
		main();
}